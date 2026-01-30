@extends('layouts.app')

@section('title', 'Logbook - Sistem Magang')

@section('content')
<div class="min-h-screen bg-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <div>
                    <h1 class="text-4xl font-bold leading-tight bg-blue-600 bg-clip-text text-transparent mb-2 pb-2">
                        Logbook Harian
                    </h1>
                    <p class="text-gray-600">Catat dan kelola aktivitas harian Anda</p>
                </div>
                <a href="{{ route('intern.logbook.create') }}" 
                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-plus mr-2"></i>Tambah Logbook
                </a>
            </div>
        </div>

        <!-- Statistics Cards (Optional - untuk informasi tambahan) -->
        @if($logbooks->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Logbook -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Logbook</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $logbooks->total() }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-book text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-blue-500"></div>
                </div>

                <!-- Dengan Foto -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Dengan Foto</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $logbooks->where('photo_path', '!=', null)->count() }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-image text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-green-500"></div>
                </div>

                <!-- Bulan Ini -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Bulan Ini</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $logbooks->where('date', '>=', now()->startOfMonth())->count() }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-calendar-alt text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-purple-500"></div>
                </div>
            </div>
        @endif

        <!-- Logbook Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-list mr-3"></i>
                    Data Logbook
                </h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto overflow-y-auto max-h-[500px]">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-blue-50">
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">Tanggal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Aktivitas</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Foto</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($logbooks as $logbook)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ $logbook->date->format('d F Y') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-left">
                                        <div class="text-sm text-gray-900 max-w-md">
                                            {{ Str::limit($logbook->activity, 150) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($logbook->photo_path)
                                            <img src="{{ url('storage/' . $logbook->photo_path) }}" 
                                                alt="Logbook photo" 
                                                class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all shadow-sm mx-auto" 
                                                onclick="window.open('{{ url('storage/' . $logbook->photo_path) }}', '_blank')"
                                                title="Klik untuk melihat full size">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex gap-2 justify-center">
                                            <a href="{{ route('intern.logbook.edit', $logbook) }}" 
                                               class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 hover:bg-blue-200 rounded-lg transition-all duration-200 group"
                                               title="Edit">
                                                <svg class="w-5 h-5 text-blue-600 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('intern.logbook.destroy', $logbook) }}" method="POST" class="inline" 
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus logbook ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center justify-center w-10 h-10 bg-red-100 hover:bg-red-200 rounded-lg transition-all duration-200 group"
                                                        title="Hapus">
                                                    <svg class="w-5 h-5 text-red-600 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fas fa-book text-5xl mb-3 text-gray-300"></i>
                                            <p class="text-lg font-medium">Belum ada logbook.</p>
                                            <p class="text-sm mt-2">Mulai dengan membuat logbook pertama Anda.</p>
                                            <a href="{{ route('intern.logbook.create') }}" 
                                                class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300">
                                                <i class="fas fa-plus mr-2"></i>Tambah Logbook
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($logbooks->count() > 0)
                    <div class="mt-6">
                        {{ $logbooks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection