@extends('layouts.app')

@section('title', 'Dashboard Mentor - Sistem Magang')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    *, body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .mono { font-family: 'DM Mono', monospace; }

    /* ── Page background ── */
    .dash-bg {
        min-height: 100vh;
        background: #f1f5ff;
    }

    /* ── Header strip ── */
    .hero-strip {
        background: linear-gradient(110deg, #0f2878 0%, #2d3ecb 55%, #4f46e5 100%);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .hero-strip::before {
        content: '';
        position: absolute;
        top: -80px; right: -60px;
        width: 260px; height: 260px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-strip::after {
        content: '';
        position: absolute;
        bottom: -100px; left: 25%;
        width: 320px; height: 320px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
        pointer-events: none;
    }

    @keyframes pulse-ring {
        0%   { transform: scale(1); opacity: 1; }
        100% { transform: scale(2.2); opacity: 0; }
    }

    /* ── Stat tiles ── */
    .stat-tile {
        background: #fff;
        border-radius: 18px;
        padding: 18px 20px;
        box-shadow: 0 1px 3px rgba(20,40,120,0.06), 0 4px 16px rgba(20,40,120,0.06);
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: transform .2s ease, box-shadow .2s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-tile::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 0 0 18px 18px;
    }
    .stat-tile:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(20,40,120,0.12); }
    .tile-blue::after   { background: linear-gradient(90deg,#3b82f6,#6366f1); }
    .tile-green::after  { background: linear-gradient(90deg,#22c55e,#10b981); }
    .tile-yellow::after { background: linear-gradient(90deg,#f59e0b,#f97316); }
    .tile-gray::after   { background: linear-gradient(90deg,#64748b,#94a3b8); }
    .tile-indigo::after { background: linear-gradient(90deg,#6366f1,#8b5cf6); }
    .tile-rose::after   { background: linear-gradient(90deg,#f43f5e,#e11d48); }

    .tile-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        color: #fff;
        flex-shrink: 0;
    }

    /* ── Attendance bar ── */
    .att-bar-track {
        height: 8px;
        background: #e8eeff;
        border-radius: 99px;
        overflow: hidden;
        margin-top: 4px;
    }
    .att-bar-fill {
        height: 100%;
        border-radius: 99px;
        width: 0;
        transition: width 1.2s cubic-bezier(.4,0,.2,1);
    }

    /* ── Panel ── */
    .panel {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 1px 3px rgba(20,40,120,0.06), 0 4px 18px rgba(20,40,120,0.06);
        overflow: hidden;
    }
    .panel-header {
        background: linear-gradient(100deg, #1e3a8a 0%, #3b4fd8 100%);
        padding: 16px 22px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .panel-header h2 {
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.01em;
        margin: 0;
    }
    .panel-body { padding: 20px 22px; }
    
    /* ── Scrollable panel body ── */
    .panel-body::-webkit-scrollbar {
        width: 6px;
    }
    .panel-body::-webkit-scrollbar-track {
        background: transparent;
    }
    .panel-body::-webkit-scrollbar-thumb {
        background: #c7d2fe;
        border-radius: 3px;
    }
    .panel-body::-webkit-scrollbar-thumb:hover {
        background: #a5b4fc;
    }

    /* ── Equal height columns ── */
    @media (min-width: 1024px) {
        /* Grid container untuk dua kolom */
        .grid.grid-cols-1.lg\:grid-cols-5 {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1.5rem;
            align-items: stretch;
        }
        
        /* Kolom kiri - spanning 3 columns */
        .grid.grid-cols-1.lg\:grid-cols-5 > .lg\:col-span-3 {
            grid-column: span 3;
            display: flex !important;
            flex-direction: column;
        }
        
        /* Kolom kanan - spanning 2 columns */
        .grid.grid-cols-1.lg\:grid-cols-5 > .lg\:col-span-2 {
            grid-column: span 2;
            display: flex !important;
            flex-direction: column;
        }
        
        /* Panel kiri selalu full height */
        .grid.grid-cols-1.lg\:grid-cols-5 > .lg\:col-span-3 > .panel {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
    }

    /* ── Intern row ── */
    .intern-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 14px;
        background: #f8faff;
        border: 1px solid #e8eeff;
        transition: all .2s ease;
    }
    .intern-row:hover {
        background: #eff2ff;
        border-color: #c7d2fe;
        transform: translateX(4px);
    }

    .avatar-sm {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        flex-shrink: 0;
    }

    /* ── Status badge ── */
    .s-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.02em;
    }
    .s-hadir   { background: #dcfce7; color: #15803d; }
    .s-izin    { background: #fef9c3; color: #92400e; }
    .s-sakit   { background: #ffedd5; color: #c2410c; }
    .s-alfa    { background: #fee2e2; color: #b91c1c; }
    .s-absent  { background: #fee2e2; color: #b91c1c; }

    /* ── Mini pill count ── */
    .mini-pill {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        font-family: 'DM Mono', monospace;
    }

    /* ── Leaderboard podium ── */
    .podium-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 18px;
        border-radius: 16px;
        border: 1.5px solid transparent;
        transition: all .2s ease;
    }
    .podium-item:hover { transform: translateX(5px); }
    .podium-1 { background: linear-gradient(100deg,#fffbeb,#fef3c7); border-color: #fde68a; }
    .podium-2 { background: linear-gradient(100deg,#f8fafc,#f1f5f9); border-color: #e2e8f0; }
    .podium-3 { background: linear-gradient(100deg,#fff7ed,#ffedd5); border-color: #fed7aa; }

    .rank-badge {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800;
        font-size: 14px;
        flex-shrink: 0;
        position: relative;
    }
    .rank-1 { background: linear-gradient(135deg,#fbbf24,#d97706); color:#fff; box-shadow: 0 3px 10px rgba(251,191,36,.4); }
    .rank-2 { background: linear-gradient(135deg,#94a3b8,#64748b); color:#fff; box-shadow: 0 3px 10px rgba(100,116,139,.3); }
    .rank-3 { background: linear-gradient(135deg,#fb923c,#ea580c); color:#fff; box-shadow: 0 3px 10px rgba(251,146,60,.35); }

    /* ── Absensi table rows ── */
    .att-tr { transition: background .15s ease; }
    .att-tr:hover { background: #eff2ff; }
    .att-tr-absent { background: #fff5f5; }

    /* ── Section label ── */
    .sec-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 12px;
    }

    /* ── Tab toggle ── */
    .tab-btn {
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s ease;
        border: none;
        background: transparent;
        color: #64748b;
    }
    .tab-btn.active {
        background: #3b4fd8;
        color: #fff;
        box-shadow: 0 2px 8px rgba(59,79,216,.25);
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; }

    /* ── Fade-in animations ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .a1 { animation: fadeUp .5s ease both; }
    .a2 { animation: fadeUp .5s .08s ease both; }
    .a3 { animation: fadeUp .5s .16s ease both; }
    .a4 { animation: fadeUp .5s .24s ease both; }
    .a5 { animation: fadeUp .5s .32s ease both; }
</style>
@endpush

@section('content')
@php
    // ── Same logic from original, untouched ──
    if (!isset($alumni)) {
        $alumniCollection = $interns->filter(function ($i) {
            $s = strtolower($i->status ?? '');
            return in_array($s, ['tidak aktif', 'inactive', 'pelepasan', 'released', 'alumni']);
        });
    } else {
        $alumniCollection = $alumni;
    }
    $alumniCount = is_countable($alumniCollection) ? $alumniCollection->count() : 0;

    // Derived attendance numbers
    $hadirCount  = $todayAttendances->where('status', 'hadir')->count();
    $izinCount   = $todayAttendances->whereIn('status', ['izin', 'sakit'])->count();
    $alfaCount   = $todayAttendances->where('status', 'alfa')->count() + $todayAbsentInterns->count();
    $internsTotal = $interns->count();
    $hadirPct = $internsTotal ? round($hadirCount / $internsTotal * 100) : 0;
@endphp

<div class="dash-bg py-8">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- ── HERO HEADER ──────────────────────────────── --}}
    <div class="hero-strip shadow-xl a1">
        <div class="relative z-10 px-6 py-8 flex flex-col sm:flex-row items-center sm:items-start gap-5">

            {{-- Avatar --}}
            <div style="background:rgba(255,255,255,0.15);border-radius:50%;padding:3px;flex-shrink:0;">
                <div style="width:72px;height:72px;background:linear-gradient(135deg,#60a5fa,#818cf8);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-chalkboard-teacher text-white text-2xl"></i>
                </div>
            </div>

            {{-- Identity --}}
            <div class="flex-1 text-center sm:text-left">
                <div class="flex flex-wrap items-center gap-2 justify-center sm:justify-start mb-1">
                    <h1 class="text-xl font-bold text-white">{{ $mentor?->name ?? auth()->user()->name }}</h1>
                </div>
                <p class="text-blue-200 text-sm">Ringkasan bimbingan hari ini &mdash; <span class="text-white font-semibold">{{ now()->translatedFormat('l, d F Y') }}</span></p>
            </div>

            {{-- Live attendance meter --}}
            <div class="text-center sm:text-right flex-shrink-0">
                <p class="text-blue-300 text-xs font-semibold uppercase tracking-widest mb-1">Kehadiran Hari Ini</p>
                <p class="text-5xl font-extrabold text-white mono">{{ $hadirPct }}<span class="text-2xl text-blue-300">%</span></p>
                <p class="text-blue-300 text-xs mt-0.5">{{ $hadirCount }} / {{ $internsTotal }} hadir</p>
                <div style="height:5px;background:rgba(255,255,255,0.15);border-radius:99px;margin-top:6px;overflow:hidden;width:120px;margin-left:auto;">
                    <div id="hero-bar" style="height:100%;background:linear-gradient(90deg,#4ade80,#22c55e);border-radius:99px;width:0;transition:width 1.2s ease;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── STAT TILES ROW ────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 a2">

        {{-- Jumlah Magang --}}
        <div class="stat-tile tile-blue col-span-1">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-gray-500 leading-tight">Anak<br>Magang</p>
                <div class="tile-icon" style="background:linear-gradient(135deg,#3b82f6,#6366f1);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mono">{{ $internsTotal }}</p>
        </div>

        {{-- Hadir --}}
        <div class="stat-tile tile-green">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-gray-500 leading-tight">Hadir<br>Hari Ini</p>
                <div class="tile-icon" style="background:linear-gradient(135deg,#22c55e,#10b981);">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mono">{{ $hadirCount }}</p>
            <div class="att-bar-track">
                <div class="att-bar-fill" style="background:#22c55e;" data-w="{{ $hadirPct }}"></div>
            </div>
        </div>

        {{-- Izin/Sakit --}}
        <div class="stat-tile tile-yellow">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-gray-500 leading-tight">Izin /<br>Sakit</p>
                <div class="tile-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                    <i class="fas fa-calendar-times"></i>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mono">{{ $izinCount }}</p>
            <div class="att-bar-track">
                <div class="att-bar-fill" style="background:#f59e0b;" data-w="{{ $internsTotal ? round($izinCount/$internsTotal*100) : 0 }}"></div>
            </div>
        </div>

        {{-- Tidak Hadir --}}
        <div class="stat-tile tile-gray">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-gray-500 leading-tight">Tidak<br>Hadir</p>
                <div class="tile-icon" style="background:linear-gradient(135deg,#64748b,#94a3b8);">
                    <i class="fas fa-user-times"></i>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mono">{{ $alfaCount }}</p>
            <div class="att-bar-track">
                <div class="att-bar-fill" style="background:#94a3b8;" data-w="{{ $internsTotal ? round($alfaCount/$internsTotal*100) : 0 }}"></div>
            </div>
        </div>

        {{-- Mikro Skill --}}
        <div class="stat-tile tile-indigo">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-gray-500 leading-tight">Mikro<br>Skill</p>
                <div class="tile-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mono">{{ $microTotal }}</p>
        </div>

        {{-- Alumni --}}
        <div class="stat-tile tile-rose">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-gray-500 leading-tight">Alumni</p>
                <div class="tile-icon" style="background:linear-gradient(135deg,#f43f5e,#e11d48);">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mono">{{ $alumniCount }}</p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-3 flex flex-col">
            <div class="panel a3 flex flex-col flex-1" style="display:flex;flex-direction:column;height:100%;">
                <div class="panel-header">
                    <i class="fas fa-users-cog text-blue-200 text-base"></i>
                    <h2>Daftar Anak Magang</h2>
                    <span style="margin-left:auto;background:rgba(255,255,255,0.15);color:#fff;font-size:11px;font-weight:700;padding:2px 10px;border-radius:999px;">
                        {{ $internsTotal }} orang
                    </span>
                </div>
                <div class="panel-body" style="flex:1;overflow-y:auto;height:100%;">
                    {{-- Tab buttons --}}
                    <div style="display:flex;gap:6px;background:#f1f5f9;border-radius:12px;padding:4px;margin-bottom:16px;">
                        <button class="tab-btn active" onclick="switchTab('aktif', this)">
                            <i class="fas fa-user-check mr-1"></i> Aktif ({{ $internsTotal }})
                        </button>
                        <button class="tab-btn" onclick="switchTab('alumni', this)">
                            <i class="fas fa-user-graduate mr-1"></i> Alumni ({{ $alumniCount }})
                        </button>
                    </div>

                    <div id="tab-aktif" class="tab-content active">
                        @php
                            $internsList = collect($interns);
                            $internsPerPage = 8;
                            $internsCurrentPage = request('interns_page', 1);
                            $internsSliced = $internsList->slice(($internsCurrentPage - 1) * $internsPerPage, $internsPerPage);
                            $internsTotalPages = ceil($internsList->count() / $internsPerPage);
                        @endphp
                        <div class="space-y-2">
                            @forelse($internsSliced as $intern)
                                <div class="intern-row">
                                    <div class="avatar-sm">
                                        {{ strtoupper(substr($intern->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $intern->name }}</p>
                                        <p class="text-xs text-gray-400 truncate">{{ $intern->institution }}</p>
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <span class="mini-pill" style="background:#dbeafe;color:#1e40af;">
                                            <i class="fas fa-calendar-alt" style="font-size:10px;"></i>
                                            {{ $intern->attendances_count }}
                                        </span>
                                        <span class="mini-pill" style="background:#ede9fe;color:#5b21b6;">
                                            <i class="fas fa-book" style="font-size:10px;"></i>
                                            {{ $intern->micro_skills_count }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align:center;padding:32px;color:#94a3b8;">
                                    <i class="fas fa-user-slash text-4xl mb-3" style="display:block;"></i>
                                    <p class="text-sm">Belum ada anak magang.</p>
                                </div>
                            @endforelse
                        </div>
                        @if($internsList->count() > $internsPerPage)
                            <div style="margin-top:16px;padding-top:16px;border-top:1px solid #e8eeff;display:flex;align-items:center;justify-content:space-between;">
                                <div style="font-size:12px;color:#94a3b8;">
                                    Menampilkan {{ ($internsCurrentPage - 1) * $internsPerPage + 1 }} - {{ min($internsCurrentPage * $internsPerPage, $internsList->count()) }} dari {{ $internsList->count() }}
                                </div>
                                <div style="display:flex;gap:6px;">
                                    @if($internsCurrentPage > 1)
                                        <a href="?interns_page=1" style="display:inline-flex;align-items:center;gap:4px;padding:6px 12px;background:#f1f5f9;border:1px solid #e8eeff;border-radius:8px;font-size:12px;font-weight:600;color:#1e40af;text-decoration:none;transition:all .2s;"
                                           onmouseover="this.style.background='#dbeafe';this.style.borderColor='#bfdbfe';"
                                           onmouseout="this.style.background='#f1f5f9';this.style.borderColor='#e8eeff';">
                                            <i class="fas fa-chevron-left"></i> Awal
                                        </a>
                                    @endif
                                    @for($i = max(1, $internsCurrentPage - 1); $i <= min($internsTotalPages, $internsCurrentPage + 1); $i++)
                                        @if($i === $internsCurrentPage)
                                            <button style="display:inline-flex;align-items:center;padding:6px 12px;background:#3b4fd8;border:1px solid #3b4fd8;border-radius:8px;font-size:12px;font-weight:700;color:#fff;cursor:pointer;">
                                                {{ $i }}
                                            </button>
                                        @else
                                            <a href="?interns_page={{ $i }}" style="display:inline-flex;align-items:center;padding:6px 12px;background:#f1f5f9;border:1px solid #e8eeff;border-radius:8px;font-size:12px;font-weight:600;color:#1e40af;text-decoration:none;transition:all .2s;"
                                               onmouseover="this.style.background='#dbeafe';this.style.borderColor='#bfdbfe';"
                                               onmouseout="this.style.background='#f1f5f9';this.style.borderColor='#e8eeff';">
                                                {{ $i }}
                                            </a>
                                        @endif
                                    @endfor
                                    @if($internsCurrentPage < $internsTotalPages)
                                        <a href="?interns_page={{ $internsTotalPages }}" style="display:inline-flex;align-items:center;gap:4px;padding:6px 12px;background:#f1f5f9;border:1px solid #e8eeff;border-radius:8px;font-size:12px;font-weight:600;color:#1e40af;text-decoration:none;transition:all .2s;"
                                           onmouseover="this.style.background='#dbeafe';this.style.borderColor='#bfdbfe';"
                                           onmouseout="this.style.background='#f1f5f9';this.style.borderColor='#e8eeff';">
                                            Akhir <i class="fas fa-chevron-right"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Alumni tab --}}
                    <div id="tab-alumni" class="tab-content">
                        @php
                            $alumniList = collect($alumniCollection);
                            $alumniPerPage = 8;
                            $alumniCurrentPage = request('alumni_page', 1);
                            $alumniSliced = $alumniList->slice(($alumniCurrentPage - 1) * $alumniPerPage, $alumniPerPage);
                            $alumniTotalPages = ceil($alumniList->count() / $alumniPerPage);
                        @endphp
                        <div class="space-y-2">
                            @forelse($alumniSliced as $a)
                                <div class="intern-row" style="background:#fff5f5;border-color:#fecdd3;">
                                    <div class="avatar-sm" style="background:linear-gradient(135deg,#f43f5e,#be185d);">
                                        {{ strtoupper(substr($a->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $a->name }}</p>
                                        <p class="text-xs text-gray-400 truncate">{{ $a->institution }}</p>
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <span class="mini-pill" style="background:#dbeafe;color:#1e40af;">
                                            <i class="fas fa-calendar-alt" style="font-size:10px;"></i>
                                            {{ $a->attendances_count ?? 0 }}
                                        </span>
                                        <span class="mini-pill" style="background:#ede9fe;color:#5b21b6;">
                                            <i class="fas fa-book" style="font-size:10px;"></i>
                                            {{ $a->micro_skills_count ?? 0 }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align:center;padding:32px;color:#94a3b8;">
                                    <i class="fas fa-inbox text-4xl mb-3" style="display:block;"></i>
                                    <p class="text-sm">Belum ada data alumni.</p>
                                </div>
                            @endforelse
                        </div>
                        @if($alumniList->count() > $alumniPerPage)
                            <div style="margin-top:16px;padding-top:16px;border-top:1px solid #e8eeff;display:flex;align-items:center;justify-content:space-between;">
                                <div style="font-size:12px;color:#94a3b8;">
                                    Menampilkan {{ ($alumniCurrentPage - 1) * $alumniPerPage + 1 }} - {{ min($alumniCurrentPage * $alumniPerPage, $alumniList->count()) }} dari {{ $alumniList->count() }}
                                </div>
                                <div style="display:flex;gap:6px;">
                                    @if($alumniCurrentPage > 1)
                                        <a href="?alumni_page=1" style="display:inline-flex;align-items:center;gap:4px;padding:6px 12px;background:#f1f5f9;border:1px solid #e8eeff;border-radius:8px;font-size:12px;font-weight:600;color:#1e40af;text-decoration:none;transition:all .2s;"
                                           onmouseover="this.style.background='#dbeafe';this.style.borderColor='#bfdbfe';"
                                           onmouseout="this.style.background='#f1f5f9';this.style.borderColor='#e8eeff';">
                                            <i class="fas fa-chevron-left"></i> Awal
                                        </a>
                                    @endif
                                    @for($i = max(1, $alumniCurrentPage - 1); $i <= min($alumniTotalPages, $alumniCurrentPage + 1); $i++)
                                        @if($i === $alumniCurrentPage)
                                            <button style="display:inline-flex;align-items:center;padding:6px 12px;background:#3b4fd8;border:1px solid #3b4fd8;border-radius:8px;font-size:12px;font-weight:700;color:#fff;cursor:pointer;">
                                                {{ $i }}
                                            </button>
                                        @else
                                            <a href="?alumni_page={{ $i }}" style="display:inline-flex;align-items:center;padding:6px 12px;background:#f1f5f9;border:1px solid #e8eeff;border-radius:8px;font-size:12px;font-weight:600;color:#1e40af;text-decoration:none;transition:all .2s;"
                                               onmouseover="this.style.background='#dbeafe';this.style.borderColor='#bfdbfe';"
                                               onmouseout="this.style.background='#f1f5f9';this.style.borderColor='#e8eeff';">
                                                {{ $i }}
                                            </a>
                                        @endif
                                    @endfor
                                    @if($alumniCurrentPage < $alumniTotalPages)
                                        <a href="?alumni_page={{ $alumniTotalPages }}" style="display:inline-flex;align-items:center;gap:4px;padding:6px 12px;background:#f1f5f9;border:1px solid #e8eeff;border-radius:8px;font-size:12px;font-weight:600;color:#1e40af;text-decoration:none;transition:all .2s;"
                                           onmouseover="this.style.background='#dbeafe';this.style.borderColor='#bfdbfe';"
                                           onmouseout="this.style.background='#f1f5f9';this.style.borderColor='#e8eeff';">
                                            Akhir <i class="fas fa-chevron-right"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT (2/5): Leaderboard ── --}}
        <div class="lg:col-span-2 flex flex-col gap-5">

            {{-- Leaderboard --}}
            <div class="panel a3">
                <div class="panel-header">
                    <i class="fas fa-trophy text-yellow-300 text-base"></i>
                    <h2>Top Mikro Skill</h2>
                </div>
                <div class="panel-body">
                    <p class="sec-label">Top 3 Bimbingan</p>

                    @if(isset($topMicroSkills) && count($topMicroSkills))
                        <div class="space-y-3">
                            @foreach($topMicroSkills->take(3) as $index => $row)
                                <div class="podium-item podium-{{ $index + 1 }}">
                                    {{-- Rank badge --}}
                                    <div class="rank-badge rank-{{ $index + 1 }}">
                                        {{ $index + 1 }}
                                    </div>

                                    {{-- Photo or avatar --}}
                                    @if(!empty($row['photo_path']))
                                        <img src="{{ url('storage/' . $row['photo_path']) }}"
                                            style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.1);flex-shrink:0;"
                                            alt="{{ $row['name'] }}">
                                    @else
                                        <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#6366f1);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;flex-shrink:0;">
                                            {{ strtoupper(substr($row['name'], 0, 1)) }}
                                        </div>
                                    @endif

                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-gray-900 text-sm truncate">{{ $row['name'] }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $row['institution'] }}</p>
                                    </div>

                                    {{-- Score --}}
                                    <div style="flex-shrink:0;text-align:right;">
                                        <span style="display:inline-flex;align-items:center;gap:4px;background:#e0e7ff;color:#3730a3;padding:4px 12px;border-radius:999px;font-size:12px;font-weight:800;font-family:'DM Mono',monospace;">
                                            <i class="fas fa-star" style="font-size:10px;color:#6366f1;"></i>
                                            {{ $row['total'] }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align:center;padding:24px;color:#94a3b8;">
                            <i class="fas fa-chart-line text-4xl mb-3" style="display:block;"></i>
                            <p class="text-sm">Belum ada data.</p>
                        </div>
                    @endif

                    <div style="margin-top:20px;text-align:center;">
                        <a href="{{ route('mentor.microskill.leaderboard') }}"
                           style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(100deg,#1e3a8a,#3b4fd8);color:#fff;font-size:13px;font-weight:700;padding:10px 22px;border-radius:12px;text-decoration:none;transition:all .2s ease;box-shadow:0 3px 12px rgba(59,79,216,.25);"
                           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 18px rgba(59,79,216,.35)';"
                           onmouseout="this.style.transform='none';this.style.boxShadow='0 3px 12px rgba(59,79,216,.25)';">
                            Lihat Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Attendance donut ── --}}
            @php
                $circ = 226.2; // 2π × 36
                $hadirDash   = $internsTotal ? ($hadirCount / $internsTotal * $circ) : 0;
                $izinDash    = $internsTotal ? ($izinCount  / $internsTotal * $circ) : 0;
                $alfaDash    = $internsTotal ? ($alfaCount  / $internsTotal * $circ) : 0;
            @endphp
            <div class="panel a4">
                <div class="panel-header">
                    <i class="fas fa-chart-pie text-blue-200 text-base"></i>
                    <h2>Distribusi Kehadiran</h2>
                </div>
                <div class="panel-body" style="display:flex;flex-direction:column;align-items:center;">

                    <div style="position:relative;width:140px;height:140px;margin-bottom:18px;">
                        <svg width="140" height="140" viewBox="0 0 80 80" style="transform:rotate(-90deg);">
                            <circle cx="40" cy="40" r="36" fill="none" stroke="#e8eeff" stroke-width="10"/>
                            {{-- Hadir --}}
                            <circle id="d-hadir" cx="40" cy="40" r="36" fill="none" stroke="#22c55e" stroke-width="10"
                                stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $circ }}"
                                style="transition:stroke-dashoffset 1.2s ease;"
                                data-dash="{{ $hadirDash }}" data-start="0"/>
                            {{-- Izin --}}
                            <circle id="d-izin" cx="40" cy="40" r="36" fill="none" stroke="#f59e0b" stroke-width="10"
                                stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $circ }}"
                                style="transition:stroke-dashoffset 1.2s ease .15s;"
                                data-dash="{{ $izinDash }}" data-start="{{ $hadirDash }}"/>
                            {{-- Alfa --}}
                            <circle id="d-alfa" cx="40" cy="40" r="36" fill="none" stroke="#ef4444" stroke-width="10"
                                stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $circ }}"
                                style="transition:stroke-dashoffset 1.2s ease .3s;"
                                data-dash="{{ $alfaDash }}" data-start="{{ $hadirDash + $izinDash }}"/>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                            <span class="mono" style="font-size:24px;font-weight:800;color:#1e3a8a;">{{ $hadirPct }}%</span>
                            <span style="font-size:9px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.08em;">Hadir</span>
                        </div>
                    </div>

                    <div style="width:100%;display:flex;flex-direction:column;gap:8px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div style="display:flex;align-items:center;gap:7px;">
                                <span style="width:10px;height:10px;background:#22c55e;border-radius:3px;display:inline-block;"></span>
                                <span style="font-size:13px;color:#374151;font-weight:500;">Hadir</span>
                            </div>
                            <span class="mono" style="font-size:13px;font-weight:700;color:#374151;">{{ $hadirCount }}</span>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div style="display:flex;align-items:center;gap:7px;">
                                <span style="width:10px;height:10px;background:#f59e0b;border-radius:3px;display:inline-block;"></span>
                                <span style="font-size:13px;color:#374151;font-weight:500;">Izin/Sakit</span>
                            </div>
                            <span class="mono" style="font-size:13px;font-weight:700;color:#374151;">{{ $izinCount }}</span>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div style="display:flex;align-items:center;gap:7px;">
                                <span style="width:10px;height:10px;background:#ef4444;border-radius:3px;display:inline-block;"></span>
                                <span style="font-size:13px;color:#374151;font-weight:500;">Tidak Hadir</span>
                            </div>
                            <span class="mono" style="font-size:13px;font-weight:700;color:#374151;">{{ $alfaCount }}</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- ── ABSENSI HARI INI (full width table) ──────── --}}
    <div class="panel a5 mb-2">
        <div class="panel-header">
            <i class="fas fa-clipboard-check text-blue-200 text-base"></i>
            <h2>Absensi Hari Ini</h2>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f0f4ff;">
                        <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:700;color:#3b4fd8;text-transform:uppercase;letter-spacing:.07em;">Nama</th>
                        <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:700;color:#3b4fd8;text-transform:uppercase;letter-spacing:.07em;">Status</th>
                        <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:700;color:#3b4fd8;text-transform:uppercase;letter-spacing:.07em;">Check In</th>
                        <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:700;color:#3b4fd8;text-transform:uppercase;letter-spacing:.07em;">Foto In</th>
                        <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:700;color:#3b4fd8;text-transform:uppercase;letter-spacing:.07em;">Check Out</th>
                        <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:700;color:#3b4fd8;text-transform:uppercase;letter-spacing:.07em;">Foto Out</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Hadir (top) --}}
                    @php $hadirExists = false; @endphp
                    @forelse($todayAttendances->where('status', 'hadir') as $attendance)
                        @php $hadirExists = true; @endphp
                        <tr class="att-tr" style="border-top:1px solid #f1f5f9;">
                            <td style="padding:12px 18px;">
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div class="avatar-sm" style="width:30px;height:30px;font-size:12px;">
                                        {{ strtoupper(substr($attendance->intern->name, 0, 1)) }}
                                    </div>
                                    <span style="font-size:13px;font-weight:600;color:#374151;">{{ $attendance->intern->name }}</span>
                                </div>
                            </td>
                            <td style="padding:12px 18px;">
                                <span class="s-badge s-hadir">
                                    <i class="fas fa-check-circle" style="font-size:10px;"></i> Hadir
                                </span>
                            </td>
                            <td style="padding:12px 18px;font-size:13px;font-weight:600;color:#374151;font-family:'DM Mono',monospace;">
                                {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '—' }}
                            </td>
                            <td style="padding:12px 18px;">
                                @if($attendance->photo_path)
                                    <img src="{{ url('storage/' . $attendance->photo_path) }}" alt="In"
                                        style="width:40px;height:40px;object-fit:cover;border-radius:10px;border:2px solid #dbeafe;cursor:pointer;transition:all .2s ease;"
                                        onclick="window.open('{{ url('storage/' . $attendance->photo_path) }}', '_blank')"
                                        onmouseover="this.style.borderColor='#3b82f6';this.style.transform='scale(1.1)';"
                                        onmouseout="this.style.borderColor='#dbeafe';this.style.transform='none';"
                                        title="Klik untuk lihat penuh">
                                @else
                                    <span style="color:#d1d5db;font-size:12px;">—</span>
                                @endif
                            </td>
                            <td style="padding:12px 18px;font-size:13px;font-weight:600;color:#374151;font-family:'DM Mono',monospace;">
                                {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '—' }}
                            </td>
                            <td style="padding:12px 18px;">
                                @if($attendance->photo_checkout)
                                    <img src="{{ url('storage/' . $attendance->photo_checkout) }}" alt="Out"
                                        style="width:40px;height:40px;object-fit:cover;border-radius:10px;border:2px solid #dbeafe;cursor:pointer;transition:all .2s ease;"
                                        onclick="window.open('{{ url('storage/' . $attendance->photo_checkout) }}', '_blank')"
                                        onmouseover="this.style.borderColor='#3b82f6';this.style.transform='scale(1.1)';"
                                        onmouseout="this.style.borderColor='#dbeafe';this.style.transform='none';"
                                        title="Klik untuk lihat penuh">
                                @else
                                    <span style="color:#d1d5db;font-size:12px;">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse

                    {{-- Izin/Sakit/Alfa --}}
                    @forelse($todayAttendances->whereIn('status', ['izin', 'sakit', 'alfa']) as $attendance)
                        <tr class="att-tr" style="border-top:1px solid #f1f5f9;">
                            <td style="padding:12px 18px;">
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div class="avatar-sm" style="width:30px;height:30px;font-size:12px;">
                                        {{ strtoupper(substr($attendance->intern->name, 0, 1)) }}
                                    </div>
                                    <span style="font-size:13px;font-weight:600;color:#374151;">{{ $attendance->intern->name }}</span>
                                </div>
                            </td>
                            <td style="padding:12px 18px;">
                                <span class="s-badge
                                    @if($attendance->status == 'izin')  s-izin
                                    @elseif($attendance->status == 'sakit') s-sakit
                                    @else s-alfa @endif">
                                    @if(in_array($attendance->status, ['izin','sakit']))
                                        <i class="fas fa-notes-medical" style="font-size:10px;"></i>
                                    @else
                                        <i class="fas fa-times-circle" style="font-size:10px;"></i>
                                    @endif
                                    @if($attendance->status == 'alfa') Tidak Hadir
                                    @else {{ ucfirst($attendance->status) }}
                                    @endif
                                </span>
                            </td>
                            <td style="padding:12px 18px;font-size:13px;font-weight:600;color:#374151;font-family:'DM Mono',monospace;">
                                {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '—' }}
                            </td>
                            <td style="padding:12px 18px;">
                                @if($attendance->photo_path)
                                    <img src="{{ url('storage/' . $attendance->photo_path) }}" alt="In"
                                        style="width:40px;height:40px;object-fit:cover;border-radius:10px;border:2px solid #dbeafe;cursor:pointer;transition:all .2s ease;"
                                        onclick="window.open('{{ url('storage/' . $attendance->photo_path) }}', '_blank')"
                                        onmouseover="this.style.borderColor='#3b82f6';this.style.transform='scale(1.1)';"
                                        onmouseout="this.style.borderColor='#dbeafe';this.style.transform='none';"
                                        title="Klik untuk lihat penuh">
                                @else
                                    <span style="color:#d1d5db;font-size:12px;">—</span>
                                @endif
                            </td>
                            <td style="padding:12px 18px;font-size:13px;font-weight:600;color:#374151;font-family:'DM Mono',monospace;">
                                {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '—' }}
                            </td>
                            <td style="padding:12px 18px;">
                                @if($attendance->photo_checkout)
                                    <img src="{{ url('storage/' . $attendance->photo_checkout) }}" alt="Out"
                                        style="width:40px;height:40px;object-fit:cover;border-radius:10px;border:2px solid #dbeafe;cursor:pointer;transition:all .2s ease;"
                                        onclick="window.open('{{ url('storage/' . $attendance->photo_checkout) }}', '_blank')"
                                        onmouseover="this.style.borderColor='#3b82f6';this.style.transform='scale(1.1)';"
                                        onmouseout="this.style.borderColor='#dbeafe';this.style.transform='none';"
                                        title="Klik untuk lihat penuh">
                                @else
                                    <span style="color:#d1d5db;font-size:12px;">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse

                    {{-- Belum Absen (bottom) --}}
                    @forelse($todayAbsentInterns as $absentIntern)
                        <tr class="att-tr att-tr-absent" style="border-top:1px solid #fecdd3;">
                            <td style="padding:12px 18px;">
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div class="avatar-sm" style="width:30px;height:30px;font-size:12px;background:linear-gradient(135deg,#ef4444,#dc2626);">
                                        {{ strtoupper(substr($absentIntern->name, 0, 1)) }}
                                    </div>
                                    <span style="font-size:13px;font-weight:600;color:#374151;">{{ $absentIntern->name }}</span>
                                </div>
                            </td>
                            <td style="padding:12px 18px;">
                                <span class="s-badge s-absent">
                                    <i class="fas fa-times-circle" style="font-size:10px;"></i> Belum Absen
                                </span>
                            </td>
                            <td colspan="4" style="padding:12px 18px;font-size:12px;color:#94a3b8;font-style:italic;">
                                Belum melakukan absensi hari ini
                            </td>
                        </tr>
                    @empty
                        @if(!$hadirExists)
                            <tr>
                                <td colspan="6" style="padding:40px;text-align:center;color:#94a3b8;">
                                    <i class="fas fa-inbox" style="font-size:36px;display:block;margin-bottom:10px;"></i>
                                    <p style="font-size:13px;">Belum ada data absensi hari ini.</p>
                                </td>
                            </tr>
                        @endif
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Progress bars ──
    setTimeout(() => {
        document.querySelectorAll('.att-bar-fill').forEach(el => {
            el.style.width = (el.dataset.w || 0) + '%';
        });
        // Hero bar
        const heroBar = document.getElementById('hero-bar');
        if (heroBar) heroBar.style.width = '{{ $hadirPct }}%';
    }, 300);

    // ── Donut chart ──
    const circ = 226.2;
    const segments = [
        { id: 'donut-hadir',  el: document.getElementById('d-hadir')  },
        { id: 'donut-izin',   el: document.getElementById('d-izin')   },
        { id: 'donut-alfa',   el: document.getElementById('d-alfa')   },
    ];
    setTimeout(() => {
        segments.forEach(seg => {
            if (!seg.el) return;
            const dash  = parseFloat(seg.el.dataset.dash  || 0);
            const start = parseFloat(seg.el.dataset.start || 0);
            seg.el.style.strokeDasharray  = `${dash} ${circ - dash}`;
            seg.el.style.strokeDashoffset = -start;
        });
    }, 400);
});

// ── Tab switcher ──
function switchTab(name, btn) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
</script>
@endpush
@endsection