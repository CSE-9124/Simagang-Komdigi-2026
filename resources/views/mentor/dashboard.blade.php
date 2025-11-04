@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Dashboard Mentor</h1>
            <p class="mb-6">Halo, {{ $mentor?->name ?? auth()->user()->name }}. Berikut ringkasan anak magang Anda.</p>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="p-4 bg-blue-50 rounded">
                    <div class="text-sm text-gray-600">Jumlah Anak Magang</div>
                    <div class="text-2xl font-bold">{{ $interns->count() }}</div>
                </div>
                <div class="p-4 bg-green-50 rounded">
                    <div class="text-sm text-gray-600">Hadir Hari Ini</div>
                    <div class="text-2xl font-bold">{{ $todayAttendances->where('status','hadir')->count() }}</div>
                </div>
                <div class="p-4 bg-yellow-50 rounded">
                    <div class="text-sm text-gray-600">Izin/Sakit Hari Ini</div>
                    <div class="text-2xl font-bold">{{ $todayAttendances->whereIn('status',[ 'izin','sakit'])->count() }}</div>
                </div>
                <div class="p-4 bg-gray-100 rounded">
                    <div class="text-sm text-gray-600">Alfa Hari Ini</div>
                    <div class="text-2xl font-bold">{{ $todayAttendances->where('status','alfa')->count() }}</div>
                </div>
                <div class="p-4 bg-indigo-50 rounded">
                    <div class="text-sm text-gray-600">Mikro Skill (Pending)</div>
                    <div class="text-2xl font-bold">{{ $microPending }} / {{ $microTotal }}</div>
                </div>
            </div>

            <h2 class="text-xl font-semibold mb-3">Daftar Anak Magang</h2>
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Institusi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Absensi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Mikro Skill</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($interns as $intern)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $intern->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $intern->institution }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $intern->attendances_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $intern->micro_skills_count }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada anak magang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <h2 class="text-xl font-semibold mb-3">Absensi Hari Ini</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto Out</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($todayAttendances as $attendance)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->intern->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $attendance->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($attendance->photo_path)
                                    <img src="{{ url('storage/' . $attendance->photo_path) }}" alt="Check In" class="w-12 h-12 object-cover rounded border cursor-pointer" onclick="window.open('{{ url('storage/' . $attendance->photo_path) }}', '_blank')">
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($attendance->photo_checkout)
                                    <img src="{{ url('storage/' . $attendance->photo_checkout) }}" alt="Check Out" class="w-12 h-12 object-cover rounded border cursor-pointer" onclick="window.open('{{ url('storage/' . $attendance->photo_checkout) }}', '_blank')">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data absensi hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-xl font-semibold mb-3">Leaderboard Mikro Skill (Top 10 Bimbingan)</h2>
            @if(isset($topMicroSkills) && count($topMicroSkills))
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
                <a href="{{ route('mentor.microskill.leaderboard') }}" class="text-indigo-600 hover:underline">Lihat selengkapnya</a>
            </div>
        </div>
    </div>
</div>
@endsection


