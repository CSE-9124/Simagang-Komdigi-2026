@extends('layouts.app')

@section('title', 'Dashboard - Sistem Magang')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    * { font-family: 'Plus Jakarta Sans', sans-serif; }

    .mono { font-family: 'DM Mono', monospace; }

    body { background: #f0f4ff; }

    /* Animated gradient background */
    .dash-bg {
        background: linear-gradient(135deg, #e8eeff 0%, #f0f4ff 40%, #e4ecff 100%);
        min-height: 100vh;
    }

    /* Profile strip */
    .profile-strip {
        background: linear-gradient(100deg, #1e3a8a 0%, #3b4fd8 50%, #4f46e5 100%);
        position: relative;
        overflow: hidden;
    }
    .profile-strip::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }
    .profile-strip::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 30%;
        width: 300px; height: 300px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }

    /* Avatar ring */
    .avatar-ring {
        background: linear-gradient(135deg, #60a5fa, #818cf8);
        padding: 3px;
        border-radius: 9999px;
        display: inline-flex;
    }
    .avatar-inner {
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        border-radius: 9999px;
        width: 80px; height: 80px;
        display: flex; align-items: center; justify-content: center;
    }

    /* Badge pill */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.03em;
    }
    .badge-active {
        background: rgba(34,197,94,0.18);
        color: #16a34a;
        border: 1px solid rgba(34,197,94,0.3);
    }

    /* Stat row item */
    .stat-row {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .stat-bar-track {
        height: 6px;
        background: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
    }
    .stat-bar-fill {
        height: 100%;
        border-radius: 999px;
        transition: width 1.2s cubic-bezier(.4,0,.2,1);
        width: 0;
    }

    /* Donut chart */
    .donut-svg circle {
        transition: stroke-dashoffset 1.4s cubic-bezier(.4,0,.2,1);
    }

    /* Status list items */
    .status-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        border-radius: 14px;
        background: #f8faff;
        border: 1px solid #e8eeff;
        transition: all 0.2s ease;
        cursor: default;
    }
    .status-item:hover {
        background: #eff2ff;
        border-color: #c7d2fe;
        transform: translateX(4px);
    }

    /* .dot-pulse {
        width: 10px; height: 10px;
        border-radius: 50%;
        position: relative;
        display: inline-block;
    }
    .dot-pulse::after {
        content: '';
        position: absolute;
        top: -3px; left: -3px;
        width: 16px; height: 16px;
        border-radius: 50%;
        animation: pulse-ring 1.8s ease-out infinite;
    }
    .dot-yellow { background: #f59e0b; }
    .dot-yellow::after { border: 2px solid #f59e0b; }
    .dot-green  { background: #22c55e; }
    .dot-green::after  { border: 2px solid #22c55e; }
    .dot-red    { background: #ef4444; }
    .dot-red::after    { border: 2px solid #ef4444; }
    .dot-blue   { background: #3b82f6; }
    .dot-blue::after   { border: 2px solid #3b82f6; }

    @keyframes pulse-ring {
        0%   { transform: scale(1); opacity: 1; }
        100% { transform: scale(2.2); opacity: 0; }
    } */

    /* Pill count badge */
    .count-pill {
        font-family: 'DM Mono', monospace;
        font-size: 13px;
        font-weight: 500;
        padding: 3px 12px;
        border-radius: 999px;
        min-width: 42px;
        text-align: center;
    }

    /* Section header */
    .section-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 14px;
    }

    /* Panel */
    .panel {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(30,58,138,0.06), 0 4px 20px rgba(30,58,138,0.06);
    }

    /* Quick action btn */
    .action-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 18px;
        border-radius: 14px;
        background: #f0f4ff;
        border: 1.5px solid #e0e7ff;
        color: #3b4fd8;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
        width: 100%;
    }
    .action-btn:hover {
        background: #e8eeff;
        border-color: #a5b4fc;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99,102,241,0.15);
        color: #3b4fd8;
        text-decoration: none;
    }
    .action-btn i { font-size: 16px; }

    /* Animated number */
    .count-animate { transition: all 0.3s ease; }

    /* Divider */
    .divider { height: 1px; background: #f1f5f9; margin: 4px 0; }

    /* Fade in animation */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-1 { animation: fadeSlideUp 0.5s ease both; }
    .anim-2 { animation: fadeSlideUp 0.5s ease 0.1s both; }
    .anim-3 { animation: fadeSlideUp 0.5s ease 0.2s both; }
    .anim-4 { animation: fadeSlideUp 0.5s ease 0.3s both; }
</style>
@endpush

@section('content')
@php
    $total    = $totalPengajuan ?: 1; // avoid division by zero
    $pctApproved = $totalPengajuan ? round(($pengajuanApproved / $totalPengajuan) * 100) : 0;
    $pctPending  = $totalPengajuan ? round(($pengajuanPending  / $totalPengajuan) * 100) : 0;
    $pctRejected = $totalPengajuan ? round(($pengajuanRejected / $totalPengajuan) * 100) : 0;

    // Donut circumference (r=42) = 2π×42 ≈ 263.9
    $circ = 263.9;
    $approvedDash = $pctApproved / 100 * $circ;
    $pendingDash  = $pctPending  / 100 * $circ;
    $rejectedDash = $pctRejected / 100 * $circ;

    $approvedOffset = $circ; // starts hidden, JS will animate
    $pendingOffset  = $circ;
    $rejectedOffset = $circ;

    $approvedStart = 0;
    $pendingStart  = $approvedDash;
    $rejectedStart = $approvedDash + $pendingDash;
@endphp

<div class="dash-bg py-8">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- ── PROFILE HEADER ────────────────────────── --}}
    <div class="profile-strip rounded-2xl shadow-xl anim-1">
        <div class="px-6 py-7 flex flex-col sm:flex-row items-center sm:items-start gap-5 relative z-10">

            {{-- Avatar --}}
            <div class="avatar-ring flex-shrink-0">
                <div class="avatar-inner">
                    <i class="fas fa-building text-2xl text-white"></i>
                </div>
            </div>

            {{-- Identity --}}
            <div class="flex-1 text-center sm:text-left">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-1">
                    <h1 class="text-xl font-bold text-white">{{ $institusi->user->name }}</h1>
                    {{-- <span class="status-badge badge-active self-center">
                        <span class="dot-pulse dot-green" style="width:7px;height:7px;"></span>
                        Aktif
                    </span> --}}
                </div>
                <p class="text-blue-200 font-semibold text-base">{{ $institusi->nama_institusi }}</p>
                @if ($institusi->jenis_institusi === 'kampus')
                    <p class="text-blue-300 text-sm mt-1">
                        <i class="fas fa-graduation-cap mr-1"></i>
                        {{ $institusi->fakultas }} &mdash; {{ $institusi->departemen }}
                    </p>
                @else
                    <p class="text-blue-300 text-sm mt-1">
                        <i class="fas fa-briefcase mr-1"></i>
                        {{ ucfirst($institusi->jenis_institusi) }}
                    </p>
                @endif
            </div>

            {{-- Summary right --}}
            <div class="flex-shrink-0 text-center sm:text-right">
                <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Total Pengajuan</p>
                <p class="text-5xl font-extrabold text-white mono">{{ $totalPengajuan }}</p>
                <p class="text-blue-300 text-xs mt-1">Keseluruhan data</p>
            </div>
        </div>
    </div>

    {{-- ── MAIN GRID ──────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Status Breakdown ─── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Status List Panel --}}
            <div class="panel anim-2">
                <p class="section-label">Rincian Status Pengajuan</p>

                <div class="space-y-2">

                    {{-- Total --}}
                    <div class="status-item" style="background:#f0f4ff; border-color:#c7d2fe;">
                        <div class="flex items-center gap-3">
                            <div style="width:36px;height:36px;background:#3b4fd8;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-layer-group text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Total Pengajuan</p>
                                <p class="text-xs text-gray-400">Semua status termasuk</p>
                            </div>
                        </div>
                        <span class="count-pill" style="background:#e0e7ff;color:#3730a3;">{{ $totalPengajuan }}</span>
                    </div>

                    <div class="divider"></div>

                    {{-- Approved --}}
                    <div class="status-item">
                        <div class="flex items-center gap-3">
                            <div style="width:36px;height:36px;background:#dcfce7;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-check-circle" style="color:#16a34a;"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Disetujui</p>
                                <div class="stat-row mt-1" style="width: 160px;">
                                    <div class="stat-bar-track">
                                        <div class="stat-bar-fill" style="background:#22c55e;" data-width="{{ $pctApproved }}"></div>
                                    </div>
                                    <p class="text-xs text-gray-400">{{ $pctApproved }}% dari total</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            {{-- <span class="dot-pulse dot-green"></span> --}}
                            <span class="count-pill" style="background:#dcfce7;color:#15803d;">{{ $pengajuanApproved }}</span>
                        </div>
                    </div>

                    {{-- Pending --}}
                    <div class="status-item">
                        <div class="flex items-center gap-3">
                            <div style="width:36px;height:36px;background:#fef9c3;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-clock" style="color:#d97706;"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Menunggu Approval</p>
                                <div class="stat-row mt-1" style="width: 160px;">
                                    <div class="stat-bar-track">
                                        <div class="stat-bar-fill" style="background:#f59e0b;" data-width="{{ $pctPending }}"></div>
                                    </div>
                                    <p class="text-xs text-gray-400">{{ $pctPending }}% dari total</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            {{-- <span class="dot-pulse dot-yellow"></span> --}}
                            <span class="count-pill" style="background:#fef9c3;color:#b45309;">{{ $pengajuanPending }}</span>
                        </div>
                    </div>

                    {{-- Rejected --}}
                    <div class="status-item">
                        <div class="flex items-center gap-3">
                            <div style="width:36px;height:36px;background:#fee2e2;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-times-circle" style="color:#dc2626;"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Ditolak</p>
                                <div class="stat-row mt-1" style="width: 160px;">
                                    <div class="stat-bar-track">
                                        <div class="stat-bar-fill" style="background:#ef4444;" data-width="{{ $pctRejected }}"></div>
                                    </div>
                                    <p class="text-xs text-gray-400">{{ $pctRejected }}% dari total</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            {{-- <span class="dot-pulse dot-red"></span> --}}
                            <span class="count-pill" style="background:#fee2e2;color:#b91c1c;">{{ $pengajuanRejected }}</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="panel anim-3">
                <p class="section-label">Aksi Cepat</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('institusi.pengajuan.create') }}" class="action-btn">
                        <i class="fas fa-plus-circle"></i>
                        Buat Pengajuan Baru
                    </a>
                    <a href="{{ route('institusi.pengajuan.index') }}" class="action-btn">
                        <i class="fas fa-list-ul"></i>
                        Lihat Semua Pengajuan
                    </a>
                    <a href="{{ route('institusi.profile.edit') }}" class="action-btn">
                        <i class="fas fa-user-edit"></i>
                        Edit Profil Institusi
                    </a>
                    <a href="{{ route('institusi.pengajuan.index', ['status' => 'pending']) }}" class="action-btn">
                        <i class="fas fa-hourglass-half"></i>
                        Pengajuan Pending
                        @if ($pengajuanPending > 0)
                            <span style="margin-left:auto;background:#fef08a;color:#854d0e;border-radius:999px;padding:1px 8px;font-size:11px;font-weight:700;">
                                {{ $pengajuanPending }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>

        </div>

        {{-- RIGHT: Donut + Info ─── --}}
        <div class="space-y-5">

            {{-- Donut Chart --}}
            <div class="panel anim-2 flex flex-col items-center">
                <p class="section-label w-full">Distribusi Status</p>

                <div class="relative" style="width:160px;height:160px;">
                    <svg width="160" height="160" viewBox="0 0 100 100" class="donut-svg" style="transform:rotate(-90deg);">
                        {{-- Track --}}
                        <circle cx="50" cy="50" r="42" fill="none" stroke="#e2e8f0" stroke-width="12"/>
                        {{-- Approved --}}
                        <circle id="donut-approved" cx="50" cy="50" r="42" fill="none"
                            stroke="#22c55e" stroke-width="12"
                            stroke-dasharray="{{ $circ }}"
                            stroke-dashoffset="{{ $circ }}"
                            stroke-linecap="butt"
                            style="transition: stroke-dashoffset 1.2s ease;"
                            data-dash="{{ $approvedDash }}"
                            data-offset="0"/>
                        {{-- Pending --}}
                        <circle id="donut-pending" cx="50" cy="50" r="42" fill="none"
                            stroke="#f59e0b" stroke-width="12"
                            stroke-dasharray="{{ $circ }}"
                            stroke-dashoffset="{{ $circ }}"
                            stroke-linecap="butt"
                            style="transition: stroke-dashoffset 1.2s ease 0.2s;"
                            data-dash="{{ $pendingDash }}"
                            data-start="{{ $approvedDash }}"/>
                        {{-- Rejected --}}
                        <circle id="donut-rejected" cx="50" cy="50" r="42" fill="none"
                            stroke="#ef4444" stroke-width="12"
                            stroke-dasharray="{{ $circ }}"
                            stroke-dashoffset="{{ $circ }}"
                            stroke-linecap="butt"
                            style="transition: stroke-dashoffset 1.2s ease 0.4s;"
                            data-dash="{{ $rejectedDash }}"
                            data-start="{{ $approvedDash + $pendingDash }}"/>
                    </svg>
                    {{-- Center label --}}
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                        <span class="mono" style="font-size:26px;font-weight:800;color:#1e3a8a;">{{ $totalPengajuan }}</span>
                        <span style="font-size:10px;color:#94a3b8;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;">Total</span>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="mt-5 space-y-2 w-full">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span style="width:10px;height:10px;background:#22c55e;border-radius:3px;display:inline-block;"></span>
                            <span class="text-gray-600 font-medium">Disetujui</span>
                        </div>
                        <span class="mono text-gray-800 font-semibold">{{ $pctApproved }}%</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span style="width:10px;height:10px;background:#f59e0b;border-radius:3px;display:inline-block;"></span>
                            <span class="text-gray-600 font-medium">Pending</span>
                        </div>
                        <span class="mono text-gray-800 font-semibold">{{ $pctPending }}%</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span style="width:10px;height:10px;background:#ef4444;border-radius:3px;display:inline-block;"></span>
                            <span class="text-gray-600 font-medium">Ditolak</span>
                        </div>
                        <span class="mono text-gray-800 font-semibold">{{ $pctRejected }}%</span>
                    </div>
                </div>
            </div>

            {{-- Info Panel --}}
            <div class="panel anim-4">
                <p class="section-label">Informasi Akun</p>
                <div class="space-y-3">

                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Email</p>
                        <p class="text-sm font-medium text-gray-700 truncate">{{ $institusi->user->email }}</p>
                    </div>
                    <div class="divider"></div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Jenis Institusi</p>
                        <p class="text-sm font-medium text-gray-700">{{ ucfirst($institusi->jenis_institusi) }}</p>
                    </div>
                    @if ($institusi->jenis_institusi === 'kampus')
                    <div class="divider"></div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Fakultas</p>
                        <p class="text-sm font-medium text-gray-700">{{ $institusi->fakultas }}</p>
                    </div>
                    <div class="divider"></div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Departemen</p>
                        <p class="text-sm font-medium text-gray-700">{{ $institusi->departemen }}</p>
                    </div>
                    @endif
                    <div class="divider"></div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Tingkat Penerimaan</p>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="stat-bar-track flex-1">
                                <div class="stat-bar-fill" style="background: linear-gradient(90deg,#22c55e,#16a34a);" data-width="{{ $pctApproved }}"></div>
                            </div>
                            <span class="mono text-xs font-bold text-green-600">{{ $pctApproved }}%</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
</div>

@push('scripts')
<script>
    // Animate progress bars
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            document.querySelectorAll('.stat-bar-fill').forEach(el => {
                el.style.width = el.dataset.width + '%';
            });
        }, 300);

        // Donut animation
        const circ = {{ $circ }};

        const approved = document.getElementById('donut-approved');
        const pending  = document.getElementById('donut-pending');
        const rejected = document.getElementById('donut-rejected');

        setTimeout(() => {
            // Approved segment
            const aDash  = parseFloat(approved.dataset.dash);
            approved.style.strokeDasharray = `${aDash} ${circ - aDash}`;
            approved.style.strokeDashoffset = 0;

            // Pending segment - offset so it starts after approved
            const pDash  = parseFloat(pending.dataset.dash);
            const pStart = parseFloat(pending.dataset.start);
            pending.style.strokeDasharray  = `${pDash} ${circ - pDash}`;
            pending.style.strokeDashoffset = -pStart;

            // Rejected segment
            const rDash  = parseFloat(rejected.dataset.dash);
            const rStart = parseFloat(rejected.dataset.start);
            rejected.style.strokeDasharray  = `${rDash} ${circ - rDash}`;
            rejected.style.strokeDashoffset = -rStart;
        }, 400);
    });
</script>
@endpush
@endsection