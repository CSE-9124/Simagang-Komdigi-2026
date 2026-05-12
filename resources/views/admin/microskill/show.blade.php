@extends('layouts.app')

@section('title', 'Daftar Peserta Micro Skill - Sistem Magang')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .mono { font-family: 'DM Mono', monospace; }
    body { background: #f0f4ff; }

    .dash-bg {
        background: linear-gradient(135deg, #e8eeff 0%, #f0f4ff 40%, #e4ecff 100%);
        min-height: 100vh;
    }

    /* ── Profile Strip ── */
    .profile-strip {
        background: linear-gradient(100deg, #1e3a8a 0%, #3b4fd8 50%, #4f46e5 100%);
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(20, 40, 120, 0.16);
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

    /* ── Avatar ring ── */
    .avatar-ring {
        background: linear-gradient(135deg, #60a5fa, #818cf8);
        padding: 3px;
        border-radius: 9999px;
        display: inline-flex;
        flex-shrink: 0;
    }
    .avatar-inner {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border-radius: 9999px;
        width: 80px; height: 80px;
        display: flex; align-items: center; justify-content: center;
    }

    /* ── Panel ── */
    .panel {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(30,58,138,0.06), 0 4px 20px rgba(30,58,138,0.06);
    }

    /* ── Section label ── */
    .section-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 14px;
    }

    /* ── Table ── */
    .data-table { width: 100%; border-collapse: collapse; min-width: 640px; }
    .data-table th {
        padding: 10px 16px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #3730a3;
        background: #f0f4ff;
        text-align: left;
        white-space: nowrap;
    }
    .data-table th:first-child { border-radius: 10px 0 0 10px; }
    .data-table th:last-child  { border-radius: 0 10px 10px 0; text-align: center; }

    .data-table td {
        padding: 13px 16px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .data-table tbody tr { transition: background 0.15s; }
    .data-table tbody tr:hover { background: #f8faff; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    /* ── Avatar cell ── */
    .avatar-cell { display: flex; align-items: center; gap: 10px; }
    .avatar-sm-placeholder {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 13px;
        color: #7c3aed;
        font-weight: 700;
    }
    .cell-name { font-weight: 600; color: #1f2937; font-size: 13px; }
    .cell-sub  { font-size: 11px; color: #94a3b8; margin-top: 1px; }

    /* ── Bukti button ── */
    .bukti-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 999px;
        background: #ede9fe;
        color: #6d28d9;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .bukti-btn:hover {
        background: #ddd6fe;
        color: #5b21b6;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* ── Count badge ── */
    .count-badge {
        font-family: 'DM Mono', monospace;
        font-size: 12px;
        font-weight: 500;
        padding: 3px 12px;
        border-radius: 999px;
        background: #ede9fe;
        color: #6d28d9;
    }

    /* ── Table header row ── */
    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .table-header-title { display: flex; align-items: center; gap: 10px; }
    .table-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        color: white;
        flex-shrink: 0;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }
    .table-title { font-size: 15px; font-weight: 700; color: #1e3a8a; margin: 0; }
    .table-subtitle { font-size: 11px; color: #94a3b8; margin: 0; }

    /* ── Back btn ── */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        background: rgba(255,255,255,0.15);
        border: 1.5px solid rgba(255,255,255,0.3);
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.5);
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* ── Animations ── */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-1 { animation: fadeSlideUp 0.5s ease both; }
    .anim-2 { animation: fadeSlideUp 0.5s ease 0.1s both; }
    .anim-3 { animation: fadeSlideUp 0.5s ease 0.2s both; }

    @media (max-width: 640px) {
        .avatar-inner { width: 60px; height: 60px; }
        .panel { padding: 16px; }
    }
</style>
@endpush

@section('content')
<div class="dash-bg py-8">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

    {{-- ── PROFILE HEADER ── --}}
    <div class="profile-strip anim-1">
        <div class="px-6 py-7 flex flex-col sm:flex-row items-center sm:items-start gap-5 relative z-10">

            <div class="avatar-ring flex-shrink-0">
                <div class="avatar-inner">
                    <i class="fas fa-graduation-cap text-2xl text-white"></i>
                </div>
            </div>

            <div class="flex-1 text-center sm:text-left">
                <p class="text-blue-300 text-xs font-semibold uppercase tracking-widest mb-1">Micro Skill</p>
                <h1 class="text-xl font-bold text-white mb-1">{{ $micro->judul_micro }}</h1>
                <p class="text-blue-300 text-sm mt-1">
                    <i class="fas fa-users mr-1"></i>
                    Daftar peserta yang telah menyelesaikan micro skill ini
                </p>
            </div>

            <div class="flex-shrink-0 flex flex-col sm:flex-row items-center gap-3">
                <div class="text-center sm:text-right">
                    <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Pengumpulan</p>
                    <p class="text-4xl font-extrabold text-white mono">{{ $submissions->total() }}</p>
                </div>
                <a href="{{ route('admin.microskill.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Kembali
                </a>
            </div>

        </div>
    </div>

    {{-- ── TABEL PESERTA ── --}}
    <div class="panel anim-2">
        <div class="table-header">
            <div class="table-header-title">
                <div class="table-icon"><i class="fas fa-list-check"></i></div>
                <div>
                    <p class="table-title">Daftar Pengumpulan</p>
                    <p class="table-subtitle">Peserta yang telah mengirim bukti pengerjaan</p>
                </div>
            </div>
            <span class="count-badge">{{ $submissions->total() }} peserta</span>
        </div>

        <div style="overflow-x:auto;border-radius:14px;border:1px solid #e8eeff;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Institusi</th>
                        <th>Dikirim</th>
                        <th style="text-align:center;">Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $s)
                        <tr>
                            <td>
                                <div class="avatar-cell">
                                    @if(!empty($s->intern->photo_path))
                                        <img src="{{ url('storage/'.$s->intern->photo_path) }}"
                                             alt="{{ $s->intern->name }}"
                                             style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #ddd6fe;flex-shrink:0;">
                                    @else
                                        <div class="avatar-sm-placeholder">
                                            {{ strtoupper(substr($s->intern->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="cell-name">{{ $s->intern->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="color:#475569;">{{ $s->intern->institution }}</td>
                            <td class="mono" style="font-size:12px;color:#64748b;">
                                {{ $s->submitted_at ? \Carbon\Carbon::parse($s->submitted_at)->format('d/m/Y H:i') : '—' }}
                            </td>
                            <td style="text-align:center;">
                                @if($s->photo_path)
                                    @php
                                        $microSkillFilename = basename($s->photo_path);
                                        $microSkillUrl = URL::temporarySignedRoute('admin.microskill.photo', now()->addSeconds(30), ['filename' => $microSkillFilename]);
                                    @endphp
                                    <a href="{{ $microSkillUrl }}" target="_blank" class="bukti-btn">
                                        <i class="fas fa-image text-xs"></i>
                                        Lihat Bukti
                                    </a>
                                @else
                                    <span style="color:#d1d5db;font-size:12px;">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding:40px;text-align:center;color:#94a3b8;">
                                <i class="fas fa-inbox" style="font-size:2.5rem;display:block;margin-bottom:10px;color:#e2e8f0;"></i>
                                <p style="font-size:13px;margin:0;">Belum ada peserta yang mengerjakan micro skill ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
            <div style="margin-top:16px;">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>

</div>
</div>
@endsection