@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Magang')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .mono {
            font-family: 'DM Mono', monospace;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f4ff;
        }

        .dash-bg {
            background: linear-gradient(135deg, #e8eeff 0%, #f0f4ff 40%, #e4ecff 100%);
        }

        .hero-strip {
            position: relative;
            background: linear-gradient(100deg, #1e3a8a 0%, #3b4fd8 50%, #4f46e5 100%);
            padding: 2.5rem 2rem;
            border-radius: 1.25rem;
            color: white;
            overflow: hidden;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(20, 40, 120, 0.16);
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

        .hero-strip h1 {
            position: relative;
            z-index: 1;
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .hero-strip p {
            position: relative;
            z-index: 1;
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0.5rem 0 0 0;
        }

        .stat-tile {
            background: white;
            border-radius: 1.25rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(30, 58, 138, 0.06), 0 4px 20px rgba(30, 58, 138, 0.06);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-tile:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(59, 79, 216, 0.16);
        }

        .stat-tile::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--stat-color, #3b82f6);
        }

        .stat-tile .stat-value {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0.5rem 0 0 0;
            font-family: 'DM Mono', monospace;
        }

        .stat-tile .stat-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .panel {
            background: white;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(30, 58, 138, 0.06), 0 4px 20px rgba(30, 58, 138, 0.06);
            margin-bottom: 1.5rem;
        }

        .panel-header {
            background: linear-gradient(110deg, #1e3a8a 0%, #3b4fd8 100%);
            padding: 1rem 1.5rem;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .panel-header i {
            font-size: 1.25rem;
        }

        .panel-body {
            padding: 2rem;
        }

        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 14px;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .attendance-table {
            min-width: 780px;
        }

        .leaderboard-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .leaderboard-main {
            min-width: 0;
        }

        .leaderboard-name {
            word-break: break-word;
        }

        .leaderboard-score {
            flex-shrink: 0;
        }

        .cta-btn {
            justify-content: center;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim-1 {
            animation: fadeSlideUp 0.5s ease both;
        }

        .anim-2 {
            animation: fadeSlideUp 0.5s ease 0.1s both;
        }

        .anim-3 {
            animation: fadeSlideUp 0.5s ease 0.2s both;
        }

        @media (max-width: 640px) {
            .hero-strip {
                padding: 1.5rem 1rem;
            }

            .hero-strip h1 {
                font-size: 1.5rem;
            }

            .panel-body {
                padding: 1.25rem;
            }

            .stat-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .hero-strip h1 i {
                font-size: 1.3rem !important;
            }

            .stat-tile {
                padding: 1rem;
            }

            .stat-tile .stat-value {
                font-size: 1.5rem;
            }

            .stat-icon {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 1.2rem;
            }

            .panel-header {
                padding: 0.85rem 1rem;
                font-size: 1rem;
            }

            .attendance-table th,
            .attendance-table td {
                padding: 0.7rem 0.65rem;
                font-size: 0.75rem;
            }

            .attendance-name {
                min-width: 140px;
                white-space: normal !important;
                text-align: left;
            }

            .attendance-name .text-sm {
                line-height: 1.35;
            }

            .attendance-table img {
                width: 2.5rem;
                height: 2.5rem;
            }

            .leaderboard-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .leaderboard-main {
                width: 100%;
            }

            .leaderboard-main .w-12,
            .leaderboard-main img.w-12 {
                width: 2.5rem;
                height: 2.5rem;
            }

            .leaderboard-main .w-10 {
                width: 2rem;
                height: 2rem;
                font-size: 0.75rem;
                margin-right: 0.65rem;
            }

            .leaderboard-name {
                font-size: 0.95rem;
                line-height: 1.35;
            }

            .leaderboard-score {
                align-self: flex-end;
            }

            .cta-btn {
                width: 100%;
            }
        }

        @media (max-width: 420px) {
            .hero-strip h1 {
                font-size: 1.25rem;
                line-height: 1.3;
            }

            .hero-strip p {
                font-size: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dash-bg min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Strip -->
            <div class="hero-strip anim-1">
                <h1><i class="fas fa-tachometer-alt mr-3" style="font-size: 2rem;"></i>Dashboard Admin</h1>
                <p>Sistem Manajemen Magang BBPSDMP Komdigi Makassar</p>
            </div>

            <!-- Stats Cards -->
            <div class="stat-grid anim-2">
                <!-- Active Interns -->
                <div class="stat-tile" style="--stat-color: #3b82f6;">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="stat-label">Anak Magang Aktif</p>
                            <p class="stat-value">{{ $activeInterns }}</p>
                        </div>
                        <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Present -->
                <div class="stat-tile" style="--stat-color: #22c55e;">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="stat-label">Total Hadir</p>
                            <p class="stat-value">{{ $totalHadir }}</p>
                        </div>
                        <div class="stat-icon" style="background: linear-gradient(135deg, #22c55e, #16a34a);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Permission -->
                <div class="stat-tile" style="--stat-color: #f59e0b;">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="stat-label">Total Izin</p>
                            <p class="stat-value">{{ $totalIzin }}</p>
                        </div>
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Sick -->
                <div class="stat-tile" style="--stat-color: #ef5350;">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="stat-label">Total Sakit</p>
                            <p class="stat-value">{{ $totalSakit }}</p>
                        </div>
                        <div class="stat-icon" style="background: linear-gradient(135deg, #ef5350, #e53935);">
                            <i class="fas fa-calendar-minus"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Absent -->
                <div class="stat-tile" style="--stat-color: #6b7280;">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="stat-label">Total Tidak Hadir</p>
                            <p class="stat-value">{{ $totalAlfa }}</p>
                        </div>
                        <div class="stat-icon" style="background: linear-gradient(135deg, #6b7280, #4b5563);">
                            <i class="fas fa-user-times"></i>
                        </div>
                    </div>
                </div>

                <!-- Micro Skills -->
                <div class="stat-tile" style="--stat-color: #8b5cf6;">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="stat-label">Mikro Skill</p>
                            <p class="stat-value">{{ $microTotal }}</p>
                        </div>
                        <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absensi Hari Ini -->
            <div class="panel anim-2">
                <div class="panel-header">
                    <i class="fas fa-clipboard-check"></i>Absensi Hari Ini
                </div>
                <div class="panel-body">
                    <p class="section-label">Monitoring Kehadiran Harian</p>
                    <div class="overflow-x-auto">
                        <table class="attendance-table min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-[#f0f4ff]">
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">
                                        Nama</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Check In</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Foto Check In</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Check Out</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">
                                        Foto Check Out</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">

                                {{-- Yang Hadir --}}
                                @php $hadirCount = 0; @endphp
                                @forelse($todayAttendances->where('status', 'hadir') as $attendance)
                                    @php
                                        $hadirCount++;
                                        $photoInUrl = $attendance->photo_path
                                            ? route('admin.attendance.photo', [
                                                'filename' => basename($attendance->photo_path),
                                            ])
                                            : null;
                                        $photoOutUrl = $attendance->photo_checkout
                                            ? route('admin.attendance.photo', [
                                                'filename' => basename($attendance->photo_checkout),
                                            ])
                                            : null;
                                    @endphp
                                    <tr class="hover:bg-[#eefaf2] transition-colors duration-150">
                                        <td class="attendance-name px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm font-medium text-gray-900">{{ $attendance->intern->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Hadir
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                                            @if ($photoInUrl)
                                                <img src="{{ $photoInUrl }}" alt="Check In"
                                                    class="w-12 h-12 object-cover rounded-lg border-2 border-green-200 cursor-pointer hover:border-green-400 transition-all"
                                                    onclick="window.open('{{ $photoInUrl }}', '_blank')"
                                                    title="Klik untuk melihat full size">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                                            @if ($photoOutUrl)
                                                <img src="{{ $photoOutUrl }}" alt="Check Out"
                                                    class="w-12 h-12 object-cover rounded-lg border-2 border-green-200 cursor-pointer hover:border-green-400 transition-all"
                                                    onclick="window.open('{{ $photoOutUrl }}', '_blank')"
                                                    title="Klik untuk melihat full size">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                                {{-- Yang Izin/Sakit/Alfa --}}
                                @forelse($todayAttendances->whereIn('status', ['izin', 'sakit', 'alfa']) as $attendance)
                                    @php
                                        $photoInUrl = $attendance->photo_path
                                            ? route('admin.attendance.photo', [
                                                'filename' => basename($attendance->photo_path),
                                            ])
                                            : null;
                                        $photoOutUrl = $attendance->photo_checkout
                                            ? route('admin.attendance.photo', [
                                                'filename' => basename($attendance->photo_checkout),
                                            ])
                                            : null;
                                    @endphp
                                    <tr class="hover:bg-[#fff9eb] transition-colors duration-150">
                                        <td class="attendance-name px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm font-medium text-gray-900">{{ $attendance->intern->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full
                                            @if ($attendance->status == 'izin') bg-yellow-100 text-yellow-800
                                            @elseif($attendance->status == 'sakit') bg-orange-100 text-orange-800
                                            @else bg-red-100 text-red-800 @endif">
                                                @if ($attendance->status == 'alfa')
                                                    Tidak Hadir
                                                @elseif($attendance->status == 'izin')
                                                    <i class="fas fa-clipboard mr-1"></i> Izin
                                                @elseif($attendance->status == 'sakit')
                                                    <i class="fas fa-heartbeat mr-1"></i> Sakit
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                                            @if ($photoInUrl)
                                                <img src="{{ $photoInUrl }}" alt="Check In"
                                                    class="w-12 h-12 object-cover rounded-lg border-2 border-yellow-200 cursor-pointer hover:border-yellow-400 transition-all"
                                                    onclick="window.open('{{ $photoInUrl }}', '_blank')"
                                                    title="Klik untuk melihat full size">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                                            @if ($photoOutUrl)
                                                <img src="{{ $photoOutUrl }}" alt="Check Out"
                                                    class="w-12 h-12 object-cover rounded-lg border-2 border-yellow-200 cursor-pointer hover:border-yellow-400 transition-all"
                                                    onclick="window.open('{{ $photoOutUrl }}', '_blank')"
                                                    title="Klik untuk melihat full size">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                                @forelse($todayAbsentInterns as $absentIntern)
                                    <tr class="bg-[#fff1f2]">
                                        <td class="attendance-name px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm font-medium text-gray-900">{{ $absentIntern->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-circle mr-1"></i> Belum Absen
                                            </span>
                                        </td>
                                        <td colspan="4" class="px-6 py-4 text-sm text-gray-400 italic text-center">
                                            Belum melakukan absensi hari ini
                                        </td>
                                    </tr>
                                @empty
                                    @if ($hadirCount == 0)
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center">
                                                <div class="flex flex-col items-center justify-center text-gray-500">
                                                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                                    <p class="text-sm">Belum ada absensi hari ini.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Mikro Skill -->
            <div class="panel anim-3">
                <div class="panel-header">
                    <i class="fas fa-trophy"></i>Leaderboard Mikro Skill (Top 3)
                </div>
                <div class="panel-body">
                    <p class="section-label">Performa Mikro Skill</p>
                    @if ($topMicroSkills->count())
                        <div class="space-y-3">
                            @foreach ($topMicroSkills->take(3) as $index => $row)
                                <div
                                    class="leaderboard-item p-3 bg-[#f0f4ff] rounded-xl hover:shadow-md transition-all duration-300 border border-[#e0e7ff]">
                                    <div class="leaderboard-main flex items-center">
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

                                        <div class="min-w-0">
                                            <div class="leaderboard-name font-bold text-gray-900 text-lg">
                                                {{ $row['name'] }}</div>
                                            <div class="text-xs text-gray-600 flex items-center">
                                                {{ $row['institution'] }}
                                            </div>
                                        </div>
                                    </div>

                                    <span
                                        class="leaderboard-score px-3 py-1 bg-[#e0e7ff] text-center text-[#3730a3] rounded-full text-xs font-semibold mono">
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
                        <a href="{{ route('admin.microskill.leaderboard') }}"
                            class="cta-btn inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-300">
                            <span>Lihat Selengkapnya</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
