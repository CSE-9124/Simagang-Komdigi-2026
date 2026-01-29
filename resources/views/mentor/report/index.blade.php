@extends('layouts.app')

@section('title', 'Laporan Akhir Anak Bimbingan - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-4xl font-bold text-blue-600 mb-3">Laporan Akhir Anak Bimbingan
                </h1>
                <p class="text-gray-600">Kelola dan nilai laporan akhir serta sertifikat anak magang</p>
            </div>

            <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Approved</p>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    {{ $reports->where('status', 'approved')->count() }}</h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-circle text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Pending</p>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    {{ $reports->where('status', 'pending')->count() }}</h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-clock text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-yellow-500 to-yellow-600"></div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Rejected</p>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    {{ $reports->where('status', 'rejected')->count() }}</h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-times-circle text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-red-500 to-red-600"></div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Perlu Revisi</p>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    {{ $reports->where('needs_revision', true)->count() }}</h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-orange-500 to-orange-600"></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden mb-6">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-filter mr-3"></i>
                        Filter Data
                    </h2>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('mentor.report.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user mr-1 text-blue-500"></i>
                                    Anak Magang
                                </label>
                                <select name="intern_id"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <option value="">Semua</option>
                                    @foreach ($interns as $intern)
                                        <option value="{{ $intern->id }}" @selected(request('intern_id') == $intern->id)>{{ $intern->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                    Status
                                </label>
                                <select name="status"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <option value="">Semua</option>
                                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                    <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                                    <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-exclamation-triangle mr-1 text-orange-500"></i>
                                    Perlu Revisi?
                                </label>
                                <select name="needs_revision"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <option value="">Semua</option>
                                    <option value="1" @selected(request('needs_revision') === '1')>Ya</option>
                                    <option value="0" @selected(request('needs_revision') === '0')>Tidak</option>
                                </select>
                            </div>

                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300">
                                    <i class="fas fa-search mr-2"></i>
                                    Filter
                                </button>
                                @if (request()->anyFilled(['intern_id', 'status', 'needs_revision']))
                                    <a href="{{ route('mentor.report.index') }}"
                                        class="inline-flex items-center justify-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold py-3 px-6 rounded-xl transition duration-200">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-file-alt mr-3"></i>
                        Data Laporan Akhir
                    </h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-blue-50">
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">
                                        Nama</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        File</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Nilai</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Revisi</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Dikirim</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($reports as $r)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if ($r->intern->photo_path)
                                                    <img src="{{ url('storage/' . $r->intern->photo_path) }}"
                                                        class="w-8 h-8 rounded-full object-cover border-2 border-blue-200 mr-3"
                                                        alt="{{ $r->intern->name }}" />
                                                @else
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center mr-3">
                                                        <i class="fas fa-user text-white text-xs"></i>
                                                    </div>
                                                @endif
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ $r->intern->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('download', ['path' => $r->file_path]) }}" target="_blank"
                                                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm hover:underline">
                                                <i class="fas fa-file-pdf mr-2 text-red-500"></i>
                                                {{ $r?->file_name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                            @if ($r->status == 'approved') bg-green-100 text-green-800
                                            @elseif($r->status == 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                                @if ($r->status == 'approved')
                                                    ✓ Approved
                                                @elseif($r->status == 'rejected')
                                                    ✗ Rejected
                                                @else
                                                    ⏳ Pending
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if ($r->grade)
                                                <div
                                                    class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-sm">
                                                    <span class="font-bold text-white text-lg">{{ $r->grade }}</span>
                                                    @if ($r->score)
                                                        <span
                                                            class="text-blue-100 text-xs ml-1">({{ $r->score }})</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">Belum dinilai</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if ($r->needs_revision) bg-orange-100 text-orange-800
                                            @else bg-green-100 text-green-800 @endif">
                                                {{ $r->needs_revision ? '⚠️ Ya' : '✓ Tidak' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center text-sm text-gray-600">
                                                <i class="fas fa-clock text-blue-500 mr-2"></i>
                                                {{ $r->submitted_at ? \Carbon\Carbon::parse($r->submitted_at)->format('d M Y H:i') : '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col items-center space-y-2">
                                                {{-- Aksi Laporan --}}
                                                @if (!$r->grade)
                                                    <a href="{{ route('mentor.report.show', $r) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 shadow-sm hover:shadow-md transition-all duration-300 w-full justify-center">
                                                        <i class="fas fa-star mr-1"></i>
                                                        Beri Nilai
                                                    </a>
                                                @else
                                                    <a href="{{ route('mentor.report.show', $r) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700 shadow-sm hover:shadow-md transition-all duration-300 w-full justify-center">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        Lihat Nilai
                                                    </a>
                                                @endif

                                                <a href="{{ route('mentor.certificates.create', ['intern_id' => $r->intern->id]) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700 shadow-sm hover:shadow-md transition-all duration-300 w-full justify-center">
                                                    <i class="fas fa-certificate mr-1"></i>
                                                    Sertifikat
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <i class="fas fa-file-excel text-5xl mb-3 text-gray-300"></i>
                                                <p class="text-sm font-medium">Tidak ada data laporan akhir.</p>
                                                <p class="text-xs text-gray-400 mt-1">Data akan muncul ketika anak magang
                                                    submit laporan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
