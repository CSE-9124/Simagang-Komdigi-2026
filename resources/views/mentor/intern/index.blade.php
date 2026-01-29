@extends('layouts.app')

@section('title', 'Anak Magang Bimbingan - Sistem Magang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-blue-600 mb-3">    Anak Magang Bimbingan
            </h1>
            <p class="text-gray-600">Kelola dan pantau perkembangan anak magang Anda</p>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden mb-6">
            <div class="p-6">
                <!-- Search Section -->
                <form method="GET" action="{{ route('mentor.intern.index') }}" class="mb-6">
                    <div class="flex gap-3">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari nama anak magang..." 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        </div>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                        @if(request()->filled('search'))
                            <a href="{{ route('mentor.intern.index') }}" 
                               class="inline-flex items-center px-4 py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 shadow-md hover:shadow-lg transition-all duration-300">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-blue-50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">Foto</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">Institusi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">Logbook</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">Absensi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">Mikro Skill</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($interns as $intern)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($intern->photo_path)
                                            <img src="{{ url('storage/'.$intern->photo_path) }}" 
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-blue-200 shadow-sm" 
                                                 alt="{{ $intern->name }}" />
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center shadow-sm">
                                                <i class="fas fa-user text-white text-lg"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a class="text-blue-600 hover:text-blue-800 font-semibold hover:underline transition-colors" 
                                           href="{{ route('mentor.intern.show', $intern) }}">
                                            {{ $intern->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-university mr-2 text-gray-400"></i>
                                            {{ $intern->institution }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            <i class="fas fa-book mr-1"></i>
                                            {{ $intern->logbooks_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-calendar-check mr-1"></i>
                                            {{ $intern->attendances_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            <i class="fas fa-graduation-cap mr-1"></i>
                                            {{ $intern->micro_skills_count }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fas fa-user-slash text-5xl mb-3 text-gray-300"></i>
                                            <p class="text-sm font-medium">Belum ada anak magang.</p>
                                            <p class="text-xs text-gray-400 mt-1">Data anak magang akan muncul di sini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(method_exists($interns, 'links'))
                    <div class="mt-6">
                        {{ $interns->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('mentor.attendance.index') }}" 
               class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-blue-100">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-clipboard-check text-white text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Absensi</h3>
                            </div>
                            <p class="text-sm text-gray-600">Lihat data absensi lengkap</p>
                        </div>
                        <div class="transform group-hover:translate-x-1 transition-transform duration-300">
                            <i class="fas fa-arrow-right text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
            </a>

            <a href="{{ route('mentor.logbook.index') }}" 
               class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-green-100">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-book text-white text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Logbook</h3>
                            </div>
                            <p class="text-sm text-gray-600">Pantau catatan harian</p>
                        </div>
                        <div class="transform group-hover:translate-x-1 transition-transform duration-300">
                            <i class="fas fa-arrow-right text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-green-500 to-emerald-600"></div>
            </a>

            <a href="{{ route('mentor.report.index') }}" 
               class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-purple-100">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-file-alt text-white text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Laporan</h3>
                            </div>
                            <p class="text-sm text-gray-600">Lihat laporan keseluruhan</p>
                        </div>
                        <div class="transform group-hover:translate-x-1 transition-transform duration-300">
                            <i class="fas fa-arrow-right text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-red-500 to-red-600"></div>
            </a>
        </div>

    </div>
</div>
@endsection