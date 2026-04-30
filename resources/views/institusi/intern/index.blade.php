@extends('layouts.app')

@section('title', 'Anak Magang - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-blue-600 mb-3">
                    MonitoringAnak Magang
                </h1>
                <p class="text-sm sm:text-base text-gray-600">Kelola dan pantau perkembangan anak magang Anda</p>
            </div>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mt-8">
    
    {{-- Absensi --}}
    <a href="{{ route('institusi.attendance.index') }}"
        class="group flex flex-col bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-blue-200 hover:border-blue-400 transform hover:scale-105">
        <div class="p-5 sm:p-6 flex-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-clipboard-check text-white text-xl sm:text-2xl"></i>
                </div>
                <div class="transform group-hover:translate-x-2 transition-transform duration-300">
                    <i class="fas fa-arrow-right text-blue-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Absensi</h3>
            <p class="text-xs sm:text-sm text-gray-600">Lihat dan kelola data kehadiran anak magang</p>
        </div>
        <div class="h-2 bg-gradient-to-r from-blue-500 to-blue-700 mt-auto"></div>
    </a>

    {{-- Logbook --}}
    <a href="{{ route('institusi.logbook.index') }}"
        class="group flex flex-col bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-green-200 hover:border-green-400 transform hover:scale-105">
        <div class="p-5 sm:p-6 flex-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-green-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-book text-white text-xl sm:text-2xl"></i>
                </div>
                <div class="transform group-hover:translate-x-2 transition-transform duration-300">
                    <i class="fas fa-arrow-right text-green-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Logbook</h3>
            <p class="text-xs sm:text-sm text-gray-600">Pantau catatan harian dan aktivitas</p>
        </div>
        <div class="h-2 bg-gradient-to-r from-green-500 to-emerald-700 mt-auto"></div>
    </a>

    {{-- Nilai --}}
    <a href="{{ route('institusi.certificate.index') }}"
        class="group flex flex-col bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-purple-200 hover:border-purple-400 transform hover:scale-105 sm:col-span-2 md:col-span-1">
        <div class="p-5 sm:p-6 flex-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-purple-500 to-fuchsia-700 rounded-2xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-certificate text-white text-xl sm:text-2xl"></i>
                </div>
                <div class="transform group-hover:translate-x-2 transition-transform duration-300">
                    <i class="fas fa-arrow-right text-purple-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Nilai</h3>
            <p class="text-xs sm:text-sm text-gray-600">Lihat nilai laporan dan sertifikat anak magang Anda.</p>
        </div>
        <div class="h-2 bg-gradient-to-r from-purple-500 to-fuchsia-700 mt-auto"></div>
    </a>

</div>

            <div
                class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-xl border border-blue-200 overflow-hidden mb-6 mt-5">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 sm:px-6 py-3 sm:py-5">
                    <h2 class="text-lg sm:text-xl font-bold text-white">
                        Cari Anak Magang
                    </h2>
                </div>
                <div class="p-3 sm:p-6">

                    <form method="GET" action="{{ route('institusi.intern.index') }}" class="mb-4 sm:mb-6">
                        <div class="flex gap-2">
                            <div class="flex-1 relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i
                                        class="fas fa-search text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Cari nama anak magang..."
                                    class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-blue-400 text-sm">
                            </div>
                            <div class="relative group w-40 sm:w-44">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-filter text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <select name="status" id="status"
                                    class="block w-full pl-10 pr-10 py-3 appearance-none border-2 border-gray-300 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-blue-400 text-sm">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="alumni" {{ request('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                                </select>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300 flex-shrink-0 whitespace-nowrap">
                                <i class="fas fa-search mr-2"></i>
                                Cari
                            </button>
                            @if (request()->filled('search') || request()->filled('status'))
                                <a href="{{ route('institusi.intern.index') }}"
                                    class="inline-flex items-center justify-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold py-3 px-4 rounded-xl transition duration-200 shadow-md hover:shadow-lg flex-shrink-0">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>

                    <div class="overflow-x-auto rounded-xl shadow-inner">
                        <table class="w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-500 to-indigo-500">
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Foto</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider hidden sm:table-cell">
                                        Prodi</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Logbook</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Absensi</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Mikroskill</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($interns as $intern)
                                    <tr
                                        class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            @if ($intern->photo_path)
                                                <div
                                                    class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0 rounded-full overflow-hidden border-3 border-blue-300 shadow-lg ring-2 ring-blue-100 hover:ring-blue-400 transition-all aspect-square flex items-center justify-center">
                                                    <img src="{{ url('storage/' . $intern->photo_path) }}"
                                                        class="w-full h-full object-cover object-center"
                                                        alt="{{ $intern->name }}" />
                                                </div>
                                            @else
                                                <div
                                                    class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center shadow-lg ring-2 ring-blue-100 hover:ring-blue-400 transition-all flex-shrink-0 aspect-square">
                                                    <i class="fas fa-user text-white text-lg sm:text-xl"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <a class="text-blue-600 hover:text-indigo-700 font-bold hover:underline transition-colors text-xs sm:text-sm md:text-base">
                                                {{ $intern->name }}
                                            </a>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            @if ($intern->is_active)
                                                <span
                                                    class="px-2.5 sm:px-3 py-1.5 sm:py-2 inline-flex items-center justify-center text-xs sm:text-sm leading-5 font-bold rounded-full bg-green-100 text-green-800 shadow-sm">
                                                    Aktif
                                                </span>
                                            @else
                                                <span
                                                    class="px-2.5 sm:px-3 py-1.5 sm:py-2 inline-flex items-center justify-center text-xs sm:text-sm leading-5 font-bold rounded-full bg-gray-100 text-gray-800 shadow-sm">
                                                    Alumni
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                            <div class="text-xs sm:text-sm text-gray-700 flex items-center font-medium">
                                                {{ $intern->major }}
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 sm:px-3 py-1.5 sm:py-2 inline-flex items-center justify-center text-xs sm:text-sm leading-5 font-bold rounded-full bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 shadow-sm hover:shadow-md transition-all">
                                                <i class="fas fa-book mr-1.5 sm:mr-2"></i>
                                                {{ $intern->logbooks_count }}
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 sm:px-3 py-1.5 sm:py-2 inline-flex items-center justify-center text-xs sm:text-sm leading-5 font-bold rounded-full bg-gradient-to-r from-green-100 to-green-200 text-green-800 shadow-sm hover:shadow-md transition-all">
                                                <i class="fas fa-check-circle mr-1.5 sm:mr-2"></i>
                                                {{ $intern->attendances_count }}
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 sm:px-3 py-1.5 sm:py-2 inline-flex items-center justify-center text-xs sm:text-sm leading-5 font-bold rounded-full bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 shadow-sm hover:shadow-md transition-all">
                                                <i class="fas fa-graduation-cap mr-1.5 sm:mr-2"></i>
                                                {{ $intern->micro_skills_count }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <div
                                                    class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                                    <i class="fas fa-user-slash text-5xl text-gray-300"></i>
                                                </div>
                                                <p class="text-lg font-bold text-gray-700 mb-2">Belum ada anak magang</p>
                                                <p class="text-sm text-gray-400">Data anak magang akan muncul di sini
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (method_exists($interns, 'links'))
                        <div class="mt-6">
                            {{ $interns->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
