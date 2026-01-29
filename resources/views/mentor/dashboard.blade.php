@extends('layouts.app')

@section('title', 'Dashboard Mentor - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1
                    class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                    Dashboard Mentor
                </h1>
                <p class="text-gray-600">Halo, <span
                        class="font-semibold text-gray-800">{{ $mentor?->name ?? auth()->user()->name }}</span>. Berikut
                    ringkasan anak magang Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">

                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Jumlah Anak Magang</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $interns->count() }}</h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-users text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Hadir Hari Ini</p>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    {{ $todayAttendances->where('status', 'hadir')->count() }}</h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-calendar-check text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-green-500 to-emerald-600"></div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Izin/Sakit</p>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    {{ $todayAttendances->whereIn('status', ['izin', 'sakit'])->count() }}</h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-calendar-times text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-yellow-500 to-orange-500"></div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Alfa Hari Ini</p>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    {{ $todayAttendances->where('status', 'alfa')->count() }}</h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl flex items-center justify-center flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user-times text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-gray-500 to-gray-600"></div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Mikro Skill</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $microTotal }}</h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-graduation-cap text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-blue-100 overflow-hidden mb-8">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-users-cog mr-3"></i>
                        Daftar Anak Magang
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
                                        Institusi</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Total Absensi</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">
                                        Total Mikro Skill</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($interns as $intern)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $intern->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600">{{ $intern->institution }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ $intern->attendances_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                <i class="fas fa-book mr-1"></i>
                                                {{ $intern->micro_skills_count }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <i class="fas fa-user-slash text-4xl mb-3 text-gray-300"></i>
                                                <p class="text-sm">Belum ada anak magang.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-blue-100 overflow-hidden mb-8">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clipboard-check mr-3"></i>
                        Absensi Hari Ini
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
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Check In</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Foto</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Check Out</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">
                                        Foto Out</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($todayAttendances as $attendance)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $attendance->intern->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                            @if ($attendance->status == 'hadir') bg-green-100 text-green-800
                                            @elseif($attendance->status == 'izin') bg-yellow-100 text-yellow-800
                                            @elseif($attendance->status == 'sakit') bg-red-100 text-red-800
                                            @else bg-gray-200 text-gray-800 @endif">
                                                {{ $attendance->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($attendance->photo_path)
                                                <img src="{{ url('storage/' . $attendance->photo_path) }}" alt="Check In"
                                                    class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all"
                                                    onclick="window.open('{{ url('storage/' . $attendance->photo_path) }}', '_blank')"
                                                    title="Klik untuk melihat full size">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($attendance->photo_checkout)
                                                <img src="{{ url('storage/' . $attendance->photo_checkout) }}"
                                                    alt="Check Out"
                                                    class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all"
                                                    onclick="window.open('{{ url('storage/' . $attendance->photo_checkout) }}', '_blank')"
                                                    title="Klik untuk melihat full size">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                                <p class="text-sm">Belum ada data absensi hari ini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-trophy mr-3"></i>
                        Leaderboard Mikro Skill (Top 3 Bimbingan)
                    </h2>
                </div>
                <div class="p-6">
                    @if (isset($topMicroSkills) && count($topMicroSkills))
                        <div class="space-y-3">
                            @foreach ($topMicroSkills->take(3) as $index => $row)
                                <div
                                    class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:shadow-md transition-all duration-300 border border-blue-100">
                                    <div class="flex items-center">

                                        <div class="relative">
                                            <span
                                                class="w-10 h-10 rounded-full bg-gradient-to-br 
                                            @if ($index == 0) from-yellow-400 to-yellow-600
                                            @elseif($index == 1) from-gray-300 to-gray-500
                                            @elseif($index == 2) from-orange-400 to-orange-600
                                            @else from-blue-500 to-indigo-600 @endif
                                            text-white flex items-center justify-center font-bold text-lg shadow-lg mr-4">
                                                {{ $index + 1 }}
                                            </span>
                                            @if ($index < 3)
                                                <i
                                                    class="fas fa-crown absolute -top-2 -right-1 text-yellow-500 text-xs"></i>
                                            @endif
                                        </div>

                                        @if (!empty($row['photo_path']))
                                            <img src="{{ url('storage/' . $row['photo_path']) }}"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md mr-4" />
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center mr-4 shadow-md">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <div class="font-bold text-gray-900 text-lg">{{ $row['name'] }}</div>
                                            <div class="text-xs text-gray-600 flex items-center">
                                                <i class="fas fa-university mr-1"></i>
                                                {{ $row['institution'] }}
                                            </div>
                                        </div>
                                    </div>

                                    <span
                                        class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-semibold">
                                        <i class="fas fa-star mr-1"></i>
                                        {{ $row['total'] }} course
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                            <i class="fas fa-chart-line text-5xl mb-3 text-gray-300"></i>
                            <p class="text-sm">Belum ada data.</p>
                        </div>
                    @endif

                    <div class="mt-6 text-center">
                        <a href="{{ route('mentor.microskill.leaderboard') }}"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all duration-300">
                            <span>Lihat Selengkapnya</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
