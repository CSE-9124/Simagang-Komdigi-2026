@extends('layouts.app')

@section('title', 'Absensi - Sistem Magang')

@section('content')
<div class="min-h-screen bg-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
                <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <div>
                    <h1 class="text-4xl font-bold leading-tight text-blue-600 mb-2 pb-2">Riwayat Absensi</h1>
                    <p class="text-gray-600">Pantau dan kelola absensi harian Anda</p>
                </div>
                <a href="{{ route('intern.attendance.create') }}" 
                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-plus mr-2"></i>Absensi Baru
                </a>
            </div>
        </div>
<!-- Statistics Cards (Optional - untuk informasi tambahan) -->
        @if($attendances->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                <!-- Total Hadir -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Hadir</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $attendances->where('status', 'hadir')->count() }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-calendar-check text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-green-500"></div>
                </div>

                <!-- Total Izin -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Izin</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $attendances->where('status', 'izin')->count() }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-yellow-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-calendar-times text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-yellow-500"></div>
                </div>

                <!-- Total Sakit -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Sakit</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $attendances->where('status', 'sakit')->count() }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-red-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-calendar-minus text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-red-500"></div>
                </div>

                <!-- Total Records -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Absensi</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $attendances->total() }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-clipboard-list text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-blue-500"></div>
                </div>
            </div>
        @endif

        <!-- Attendance Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden mt-8">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-clipboard-list mr-3"></i>
                    Data Absensi
                </h2>
            </div>
                <div class="p-6">
                <div class="overflow-x-auto overflow-y-auto max-h-[500px] scrollbar-thin scrollbar-thumb-blue-400 scrollbar-track-blue-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-blue-50">
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">Tanggal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Check In</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Foto Check In</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Check Out</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Foto Check Out</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">Status Dokumen</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($attendances as $attendance)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $attendance->date->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($attendance->status == 'hadir') bg-green-100 text-green-800
                                            @elseif($attendance->status == 'izin') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                        @if($attendance->check_in)
                                            <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}</div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($attendance->photo_path)
                                            <img src="{{ url('storage/' . $attendance->photo_path) }}" 
                                                alt="Check In" 
                                                class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all shadow-sm mx-auto" 
                                                onclick="window.open('{{ url('storage/' . $attendance->photo_path) }}', '_blank')"
                                                title="Klik untuk melihat full size">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                        @if($attendance->check_out)
                                            <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}</div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($attendance->photo_checkout)
                                            <img src="{{ url('storage/' . $attendance->photo_checkout) }}" 
                                                alt="Check Out" 
                                                class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all shadow-sm mx-auto" 
                                                onclick="window.open('{{ url('storage/' . $attendance->photo_checkout) }}', '_blank')"
                                                title="Klik untuk melihat full size">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 text-center">
                                        @if($attendance->note)
                                            <div class="max-w-xs truncate mx-auto text-center" title="{{ $attendance->note }}">
                                                {{ $attendance->note }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($attendance->document_status)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($attendance->document_status == 'approved') bg-green-100 text-green-800
                                                @elseif($attendance->document_status == 'rejected') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                @if($attendance->document_status == 'approved')
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                @elseif($attendance->document_status == 'rejected')
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                @else
                                                    <i class="fas fa-clock mr-1"></i>
                                                @endif
                                                {{ ucfirst($attendance->document_status) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fas fa-inbox text-5xl mb-3 text-gray-300"></i>
                                            <p class="text-lg font-medium">Belum ada data absensi.</p>
                                            <p class="text-sm mt-2">Mulai dengan membuat absensi baru.</p>
                                            <a href="{{ route('intern.attendance.create') }}" 
                                                class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300">
                                                <i class="fas fa-plus mr-2"></i>Buat Absensi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($attendances->count() > 0)
                    <div class="mt-6">
                        {{ $attendances->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection