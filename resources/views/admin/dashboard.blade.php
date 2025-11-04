@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Magang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Anak Magang Aktif</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $activeInterns }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Hadir</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalHadir }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <i class="fas fa-calendar-times text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Izin</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalIzin }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <i class="fas fa-calendar-minus text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Sakit</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalSakit }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gray-500 rounded-md p-3">
                    <i class="fas fa-user-times text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Alfa</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalAlfa }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Mikro Skill</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $microTotal }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Absensi Hari Ini</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto Out</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($todayAttendances as $attendance)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $attendance->intern->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($attendance->status == 'hadir') bg-green-100 text-green-800
                                    @elseif($attendance->status == 'izin') bg-yellow-100 text-yellow-800
                                    @elseif($attendance->status == 'sakit') bg-red-100 text-red-800
                                    @else bg-gray-200 text-gray-800
                                    @endif">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($attendance->photo_path)
                                    <img src="{{ url('storage/' . $attendance->photo_path) }}" alt="Check In" class="w-12 h-12 object-cover rounded border cursor-pointer" onclick="window.open('{{ url('storage/' . $attendance->photo_path) }}', '_blank')" title="Klik untuk melihat full size">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($attendance->photo_checkout)
                                    <img src="{{ url('storage/' . $attendance->photo_checkout) }}" alt="Check Out" class="w-12 h-12 object-cover rounded border cursor-pointer" onclick="window.open('{{ url('storage/' . $attendance->photo_checkout) }}', '_blank')" title="Klik untuk melihat full size">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Belum ada absensi hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Leaderboard Mikro Skill (Top 5)</h2>
        @if($topMicroSkills->count())
            <div class="space-y-3">
                @foreach($topMicroSkills as $index => $row)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold mr-3">{{ $index + 1 }}</span>
                            @if(!empty($row['photo_path']))
                                <img src="{{ url('storage/'.$row['photo_path']) }}" class="w-10 h-10 rounded-full object-cover border mr-3" />
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 mr-3"></div>
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900">{{ $row['name'] }}</div>
                                <div class="text-xs text-gray-500">{{ $row['institution'] }}</div>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold">{{ $row['total'] }} course</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Belum ada data.</p>
        @endif
        <div class="mt-4">
            <a href="{{ route('admin.microskill.leaderboard') }}" class="text-indigo-600 hover:underline">Lihat selengkapnya</a>
        </div>
    </div>
</div>
@endsection
