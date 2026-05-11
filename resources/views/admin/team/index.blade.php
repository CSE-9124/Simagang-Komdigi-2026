@extends('layouts.app')

@section('title', 'Kelola Tim- Sistem Manajemen Magang')

@push('styles')
    <style>a
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

        .table-shell {
            min-width: 640px;
        }

        @media (max-width: 640px) {
            .hero-strip {
                border-radius: 16px;
            }

            .hero-title {
                font-size: 1.6rem;
            }

            .cta-mobile {
                width: 100%;
                justify-content: center;
            }

            .table-shell th,
            .table-shell td {
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
                <div class="relative z-10 px-6 py-7 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                    <div>
                        <h1 class="hero-title text-3xl sm:text-4xl font-bold leading-tight mb-2">Kelola Tim Kerja/Bagian</h1>
                        <p class="text-blue-100">Kelola tim kerja/bagian untuk kebutuhan penempatan anak magang.</p>
                    </div>

                    <a href="{{ route('admin.team.create') }}"
                        class="cta-mobile inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white font-semibold py-3 px-6 rounded-xl border border-white/25 transition-all duration-300">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Tim</span>
                    </a>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header px-6 py-4 flex items-center justify-between">
                    <h2 class="text-white text-xl font-bold flex items-center">
                        <i class="fas fa-users mr-3"></i>
                        Daftar Tim Kerja/Bagian
                    </h2>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="table-shell min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-blue-50">
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">
                                        No</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">
                                        Nama</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($teams as $team)
                                    <tr class="hover:bg-gray-50/60">
                                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900">
                                            {{ ($teams->currentPage() - 1) * $teams->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $team->name }}
                                        </td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.team.edit', $team) }}"
                                                class="text-blue-600 hover:text-blue-800 mr-3" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.team.destroy', $team) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Hapus Team ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                                <p class="text-sm">Belum ada data Team.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $teams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection