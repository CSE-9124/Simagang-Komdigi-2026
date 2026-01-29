@extends('layouts.app')

@section('title', 'Anak Magang Bimbingan - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-4xl font-bold text-blue-600 mb-3">
                    Anak Magang Bimbingan
                </class=>
                <p class="text-gray-600 text-lg">Kelola dan pantau perkembangan anak magang Anda</p>
            </div>

            <div
                class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-xl border border-blue-200 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-5">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-search mr-3"></i>
                        Cari Anak Magang
                    </h2>
                </div>
                <div class="p-6">

                    <form method="GET" action="{{ route('mentor.intern.index') }}" class="mb-6">
                        <div class="flex gap-3">
                            <div class="flex-1 relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i
                                        class="fas fa-search text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Cari nama anak magang..."
                                    class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-blue-400">
                            </div>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                <i class="fas fa-search mr-2"></i>
                                Cari
                            </button>
                            @if (request()->filled('search'))
                                <a href="{{ route('mentor.intern.index') }}"
                                    class="inline-flex items-center justify-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold py-3 px-6 rounded-xl transition duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>

                    <div class="overflow-x-auto rounded-xl shadow-inner">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-500 to-indigo-500">
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider rounded-tl-lg">
                                        Foto</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Nama</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Institusi</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Logbook</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Absensi</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider rounded-tr-lg">
                                        Mikro Skill</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($interns as $intern)
                                    <tr
                                        class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($intern->photo_path)
                                                <img src="{{ url('storage/' . $intern->photo_path) }}"
                                                    class="w-14 h-14 rounded-full object-cover border-3 border-blue-300 shadow-lg ring-2 ring-blue-100 hover:ring-blue-400 transition-all"
                                                    alt="{{ $intern->name }}" />
                                            @else
                                                <div
                                                    class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center shadow-lg ring-2 ring-blue-100 hover:ring-blue-400 transition-all">
                                                    <i class="fas fa-user text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a class="text-blue-600 hover:text-indigo-700 font-bold hover:underline transition-colors text-base"
                                                href="{{ route('mentor.intern.show', $intern) }}">
                                                {{ $intern->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700 flex items-center font-medium">
                                                <i class="fas fa-university mr-2 text-blue-500"></i>
                                                {{ $intern->institution }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-2 inline-flex text-sm leading-5 font-bold rounded-full bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 shadow-sm hover:shadow-md transition-all">
                                                <i class="fas fa-book mr-2"></i>
                                                {{ $intern->logbooks_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-2 inline-flex text-sm leading-5 font-bold rounded-full bg-gradient-to-r from-green-100 to-emerald-200 text-green-800 shadow-sm hover:shadow-md transition-all">
                                                <i class="fas fa-calendar-check mr-2"></i>
                                                {{ $intern->attendances_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-2 inline-flex text-sm leading-5 font-bold rounded-full bg-gradient-to-r from-indigo-100 to-blue-200 text-indigo-800 shadow-sm hover:shadow-md transition-all">
                                                <i class="fas fa-graduation-cap mr-2"></i>
                                                {{ $intern->micro_skills_count }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <a href="{{ route('mentor.attendance.index') }}"
                    class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-blue-200 hover:border-blue-400 transform hover:scale-105">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-clipboard-check text-white text-2xl"></i>
                            </div>
                            <div class="transform group-hover:translate-x-2 transition-transform duration-300">
                                <i class="fas fa-arrow-right text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Absensi</h3>
                        <p class="text-sm text-gray-600">Lihat dan kelola data kehadiran anak magang</p>
                    </div>
                    <div class="h-2 bg-gradient-to-r from-blue-500 to-blue-700"></div>
                </a>

                <a href="{{ route('mentor.logbook.index') }}"
                    class="group bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-green-200 hover:border-green-400 transform hover:scale-105">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-book text-white text-2xl"></i>
                            </div>
                            <div class="transform group-hover:translate-x-2 transition-transform duration-300">
                                <i class="fas fa-arrow-right text-green-600 text-2xl"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Logbook</h3>
                        <p class="text-sm text-gray-600">Pantau catatan harian dan aktivitas</p>
                    </div>
                    <div class="h-2 bg-gradient-to-r from-green-500 to-emerald-700"></div>
                </a>

                <a href="{{ route('mentor.report.index') }}"
                    class="group bg-gradient-to-br from-red-50 to-red-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-red-200 hover:border-red-400 transform hover:scale-105">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-700 rounded-2xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-file-alt text-white text-2xl"></i>
                            </div>
                            <div class="transform group-hover:translate-x-2 transition-transform duration-300">
                                <i class="fas fa-arrow-right text-red-600 text-2xl"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Laporan</h3>
                        <p class="text-sm text-gray-600">Lihat dan nilai laporan akhir</p>
                    </div>
                    <div class="h-2 bg-gradient-to-r from-red-500 to-red-700"></div>
                </a>
            </div>

        </div>
    </div>
@endsection
