@extends('layouts.app')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .dash-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8eeff 0%, #f0f4ff 40%, #e4ecff 100%);
        }

        .hero-strip {
            background: linear-gradient(100deg, #1e3a8a 0%, #3b4fd8 50%, #4f46e5 100%);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(20, 40, 120, 0.16);
            color: #fff;
        }

        .hero-strip::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        .hero-strip::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: 30%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        .panel {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(30, 58, 138, 0.06), 0 4px 20px rgba(30, 58, 138, 0.06);
            overflow: hidden;
        }

        .panel-header {
            background: linear-gradient(110deg, #1e3a8a 0%, #3b4fd8 100%);
            color: #fff;
        }

        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 14px;
        }

        .stats-shell {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .pengajuan-table {
            min-width: 760px;
        }

        @media (max-width: 640px) {
            .hero-title {
                font-size: 1.55rem;
                line-height: 1.3;
            }

            .panel-content {
                padding: 1rem;
            }

            .stats-shell {
                grid-template-columns: 1fr;
            }

            .pengajuan-table th,
            .pengajuan-table td {
                padding: 0.7rem 0.65rem;
                font-size: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dash-bg py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="hero-strip mb-6">
                <div class="relative z-10 px-6 py-7">
                    <div>
                        <h1 class="hero-title text-3xl sm:text-4xl font-bold leading-tight mb-2">
                            Pengajuan Peserta Magang
                        </h1>
                        <p class="text-blue-100">Catat dan kelola pengajuan peserta magang Anda</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards (Optional - untuk informasi tambahan) -->
            {{-- @if ($pengajuans->count() > 0) --}}
            {{-- Stats Cards --}}
            <div class="stats-shell mb-8">

                @php
                    $stats = [
                        [
                            'label' => 'Total Pengajuan',
                            'value' => $totalPengajuan,
                            'color' => 'blue',
                            'icon' => 'fa-calendar-check',
                        ],
                        [
                            'label' => 'Disetujui',
                            'value' => $totalDiterima,
                            'color' => 'green',
                            'icon' => 'fa-calendar-times',
                        ],
                        [
                            'label' => 'Menunggu Approval',
                            'value' => $totalMenunggu,
                            'color' => 'yellow',
                            'icon' => 'fa-calendar-minus',
                        ],
                        [
                            'label' => 'Revisi',
                            'value' => $totalRevisi,
                            'color' => 'orange',
                            'icon' => 'fa-exclamation-circle',
                        ],
                        ['label' => 'Ditolak', 'value' => $totalDitolak, 'color' => 'red', 'icon' => 'fa-file-alt'],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-4 sm:p-6 flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-700 truncate">{{ $stat['label'] }}</p>
                                <p class="text-xl font-semibold text-gray-900 truncate">{{ $stat['value'] }}</p>
                            </div>
                            <div
                                class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-{{ $stat['color'] }}-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas {{ $stat['icon'] }} text-white text-xl sm:text-2xl"></i>
                            </div>
                        </div>
                        <div class="h-1 bg-{{ $stat['color'] }}-500"></div>
                    </div>
                @endforeach

            </div>

            <div class="panel mb-6 border-t-4 border-blue-500">
                <div class="panel-content p-6">
                    <h2 class="text-lg font-semibold text-blue-900 mb-1 flex items-center">
                        <i class="fas fa-filter mr-2 text-blue-600"></i>Filter & Pencarian
                    </h2>
                    <p class="section-label">Filter Monitoring</p>
                    <form method="GET" action="{{ route('admin.pengajuan.index') }}"
                        class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-blue-900 mb-1">Cari Nomor
                                Surat</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Cari nomor surat..."
                                class="w-full px-3 py-2 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-blue-900 mb-1">Filter Status</label>
                            <select name="status" id="status"
                                class="w-full px-3 py-2 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                                <option value="revised" {{ request('status') == 'revised' ? 'selected' : '' }}>Revised
                                </option>
                            </select>
                        </div>
                        <!-- status filter removed; inactive interns shown in separate table below -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200 flex-1">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                            @if (request()->anyFilled(['search', 'status']))
                                <a href="{{ route('admin.pengajuan.index') }}"
                                    class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold py-2 px-4 rounded-lg transition duration-200">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Pengajuan Magang Table -->
            <div class="panel border border-blue-100">
                <div class="panel-header px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-list mr-3"></i>
                        Data Pengajuan Magang
                    </h2>
                </div>
                <div class="panel-content p-6">
                    <div class="overflow-x-auto overflow-y-auto max-h-[500px]">
                        <table class="pengajuan-table min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-blue-50">
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">
                                        Nomor Surat</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Institusi</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Tanggal Pengajuan</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($pengajuanTabel as $pengajuan)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p class="text-sm text-gray-500 font-medium">
                                                {{ $pengajuan->no_surat }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <p class="text-sm text-gray-500 font-medium">
                                                    {{ $pengajuan->institusi->nama_institusi }}
                                                </p>

                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <p class="text-sm text-gray-500 font-medium text-center">
                                                    {{ $pengajuan->created_at->format('d/m/y') }}
                                                </p>

                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            <div class="flex flex-col space-y-1 items-center">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if ($pengajuan->status == 'approved') bg-green-100 text-green-800 
                                                @elseif($pengajuan->status == 'rejected') bg-red-100 text-red-800 
                                                @elseif($pengajuan->status == 'revised') bg-orange-100 text-orange-800 
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                    {{ ucfirst($pengajuan->status) }}
                                                </span>
                                                {{-- @if ($pengajuan->needs_revision)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                    Revisi
                                                </span>
                                            @endif --}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex gap-2 justify-center">
                                                <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}"
                                                    class="inline-flex items-center justify-center w-10 h-10 bg-green-100 hover:bg-green-600 rounded-lg transition-all duration-200 group"
                                                    title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.pengajuan.destroy', $pengajuan->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center w-10 h-10 bg-red-100 hover:bg-red-200 rounded-lg transition-all duration-200 group"
                                                        title="Hapus">
                                                        <svg class="w-5 h-5 text-red-600 group-hover:scale-110 transition-transform"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <i class="fas fa-book text-5xl mb-3 text-gray-300"></i>
                                                <p class="text-lg font-medium">Belum ada Pengajuan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- <!-- Pagination -->
                @if ($logbooks->count() > 0)
                    <div class="mt-6">
                        {{ $logbooks->links() }}
                    </div>
                @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection
