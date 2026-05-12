@extends('layouts.app')

@section('title', 'Kelola Anak Magang - Sistem Magang')

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
        background: linear-gradient(135deg, #3b82f6, #6366f1);
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

    /* ── Filter inputs ── */
    .filter-control {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        background: #f8faff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        color: #1f2937;
        transition: all 0.2s ease;
        outline: none;
        box-sizing: border-box;
    }
    .filter-control:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .filter-control:hover:not(:focus) { border-color: #c7d2fe; background: #fff; }

    select.filter-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236366f1' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
    }

    .filter-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 5px;
    }

    /* ── Buttons ── */
    .btn-filter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 18px;
        border-radius: 12px;
        background: linear-gradient(110deg, #1e3a8a, #3b4fd8);
        color: #fff;
        font-weight: 700;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-filter:hover {
        box-shadow: 0 4px 14px rgba(59,79,216,0.3);
        transform: translateY(-1px);
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px; height: 40px;
        border-radius: 10px;
        background: #f0f4ff;
        border: 1.5px solid #e0e7ff;
        color: #3b4fd8;
        font-size: 13px;
        transition: all 0.2s ease;
        text-decoration: none;
        flex-shrink: 0;
    }
    .btn-reset:hover {
        background: #e8eeff;
        border-color: #a5b4fc;
        color: #3b4fd8;
        text-decoration: none;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        border-radius: 12px;
        background: rgba(255,255,255,0.15);
        border: 1.5px solid rgba(255,255,255,0.25);
        color: #fff;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-add:hover {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.4);
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* ── Table header ── */
    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .table-header-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .table-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        color: white;
        flex-shrink: 0;
    }
    .table-icon.blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .table-icon.gray   { background: linear-gradient(135deg, #6b7280, #4b5563); }

    .table-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e3a8a;
        margin: 0;
    }
    .table-subtitle {
        font-size: 11px;
        color: #94a3b8;
        margin: 0;
    }

    /* ── Count badge ── */
    .count-badge {
        font-family: 'DM Mono', monospace;
        font-size: 12px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 999px;
        background: #e0e7ff;
        color: #3730a3;
    }
    .count-badge.gray {
        background: #f1f5f9;
        color: #64748b;
    }

    /* ── Data table ── */
    .data-table {
        min-width: 900px;
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        padding: 10px 14px;
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
        padding: 13px 14px;
        font-size: 13px;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .data-table tbody tr { transition: background 0.15s; }
    .data-table tbody tr:hover { background: #f8faff; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    /* Alumni table */
    .data-table.alumni th {
        color: #6b7280;
        background: #f8fafc;
    }
    .data-table.alumni tbody tr:hover { background: #f9fafb; }

    /* ── Avatar cell ── */
    .avatar-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .avatar-sm {
        width: 36px; height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #c7d2fe;
        flex-shrink: 0;
    }
    .avatar-sm-placeholder {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 13px;
        color: #6366f1;
        font-weight: 700;
    }
    .avatar-sm-placeholder.gray {
        background: #f1f5f9;
        color: #94a3b8;
    }
    .cell-name {
        font-weight: 600;
        color: #1f2937;
        font-size: 13px;
    }

    /* ── Pills ── */
    .pill {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
    }
    .pill-blue   { background: #e0e7ff; color: #3730a3; }
    .pill-green  { background: #dcfce7; color: #15803d; }
    .pill-red    { background: #fee2e2; color: #b91c1c; }
    .pill-gray   { background: #f1f5f9; color: #64748b; }

    /* ── Action buttons ── */
    .action-group { display: flex; align-items: center; justify-content: center; gap: 6px; }
    .action-btn-sm {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .action-btn-sm:hover { transform: translateY(-1px); text-decoration: none; }
    .action-view   { background: #dcfce7; color: #15803d; }
    .action-view:hover  { background: #bbf7d0; }
    .action-edit   { background: #e0e7ff; color: #3730a3; }
    .action-edit:hover  { background: #c7d2fe; }
    .action-delete { background: #fee2e2; color: #b91c1c; border: none; }
    .action-delete:hover { background: #fecaca; }

    /* ── Empty state ── */
    .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: #94a3b8;
    }
    .empty-state i { font-size: 2.5rem; display: block; margin-bottom: 10px; color: #e2e8f0; }
    .empty-state p { font-size: 13px; margin: 0; }

    /* ── Animations ── */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-1 { animation: fadeSlideUp 0.5s ease both; }
    .anim-2 { animation: fadeSlideUp 0.5s ease 0.1s both; }
    .anim-3 { animation: fadeSlideUp 0.5s ease 0.2s both; }
    .anim-4 { animation: fadeSlideUp 0.5s ease 0.3s both; }

    @media (max-width: 640px) {
        .avatar-inner { width: 60px; height: 60px; }
        .panel { padding: 16px; }
    }
</style>
@endpush

@section('content')
<div class="dash-bg py-8">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

    {{-- ── PROFILE HEADER ── --}}
    <div class="profile-strip anim-1">
        <div class="px-6 py-7 flex flex-col sm:flex-row items-center sm:items-start gap-5 relative z-10">

            <div class="avatar-ring flex-shrink-0">
                <div class="avatar-inner">
                    <i class="fas fa-users text-2xl text-white"></i>
                </div>
            </div>

            <div class="flex-1 text-center sm:text-left">
                <h1 class="text-xl font-bold text-white mb-1">Kelola Anak Magang</h1>
                <p class="text-blue-200 font-semibold text-base">BBLSDM Komdigi Makassar</p>
                <p class="text-blue-300 text-sm mt-1">
                    <i class="fas fa-info-circle mr-1"></i>
                    Manajemen data peserta magang aktif dan alumni
                </p>
            </div>

            <div class="flex-shrink-0 flex flex-col sm:flex-row items-center gap-3">
                <div class="text-center sm:text-right">
                    <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Total Peserta</p>
                    <p class="text-4xl font-extrabold text-white mono">{{ $activeInterns->total() + $alumniInterns->total() }}</p>
                </div>
                <a href="{{ route('admin.intern.create') }}" class="btn-add">
                    <i class="fas fa-plus text-sm"></i>
                    Tambah Peserta
                </a>
            </div>

        </div>
    </div>

    {{-- ── FILTER PANEL ── --}}
    <div class="panel anim-2">
        <p class="section-label"><i class="fas fa-filter mr-1"></i> Filter & Pencarian</p>
        <form method="GET" action="{{ route('admin.intern.index') }}">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;align-items:end;">

                <div>
                    <label class="filter-label" for="search">Cari Nama</label>
                    <div style="position:relative;">
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Ketik nama peserta..."
                               class="filter-control" style="padding-left:36px;">
                        <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:12px;pointer-events:none;"></i>
                    </div>
                </div>

                <div>
                    <label class="filter-label" for="team">Tim</label>
                    <select name="team_id" id="team" class="filter-control">
                        <option value="">Semua Tim</option>
                        @foreach($teams as $teamOption)
                            <option value="{{ $teamOption->id }}" {{ request('team_id') == $teamOption->id ? 'selected' : '' }}>
                                {{ $teamOption->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="filter-label" for="mentor_id">Mentor</label>
                    <select name="mentor_id" id="mentor_id" class="filter-control">
                        <option value="">Semua Mentor</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id }}" {{ request('mentor_id') == $mentor->id ? 'selected' : '' }}>
                                {{ $mentor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex;align-items:flex-end;gap:8px;">
                    <button type="submit" class="btn-filter" style="flex:1;">
                        <i class="fas fa-filter"></i>
                        Terapkan
                    </button>
                    @if(request()->anyFilled(['search', 'team_id', 'mentor_id']))
                        <a href="{{ route('admin.intern.index') }}" class="btn-reset" title="Reset filter">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>

            </div>
        </form>
    </div>

    {{-- ── TABEL PESERTA AKTIF ── --}}
    <div class="panel anim-3">
        <div class="table-header">
            <div class="table-header-title">
                <div class="table-icon blue"><i class="fas fa-users"></i></div>
                <div>
                    <p class="table-title">Peserta Magang Aktif</p>
                    <p class="table-subtitle">Daftar peserta yang sedang aktif magang</p>
                </div>
            </div>
            <span class="count-badge">{{ $activeInterns->total() }} peserta</span>
        </div>

        <div style="overflow-x:auto;overflow-y:auto;max-height:520px;border-radius:14px;border:1px solid #e8eeff;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Institusi</th>
                        <th>Tim</th>
                        <th>Mentor</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeInterns as $intern)
                        <tr>
                            <td>
                                <div class="avatar-cell">
                                    @if($intern->photo_path)
                                        <img src="{{ url('storage/'.$intern->photo_path) }}"
                                             alt="{{ $intern->name }}" class="avatar-sm">
                                    @else
                                        <div class="avatar-sm-placeholder">
                                            {{ strtoupper(substr($intern->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="cell-name">{{ $intern->name }}</span>
                                </div>
                            </td>
                            <td class="mono" style="font-size:12px;color:#64748b;">{{ $intern->user->email }}</td>
                            <td style="color:#475569;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $intern->institution }}
                            </td>
                            <td>
                                @if($intern->team)
                                    <span class="pill pill-blue">{{ $intern->team->name }}</span>
                                @else
                                    <span class="pill pill-gray">—</span>
                                @endif
                            </td>
                            <td style="color:#475569;">{{ $intern->mentor?->name ?? '—' }}</td>
                            <td>
                                @if($intern->is_active)
                                    <span class="pill pill-green"><i class="fas fa-circle" style="font-size:6px;margin-right:4px;"></i>Aktif</span>
                                @else
                                    <span class="pill pill-red"><i class="fas fa-circle" style="font-size:6px;margin-right:4px;"></i>Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.intern.show', $intern) }}"
                                       class="action-btn-sm action-view" title="Lihat detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.intern.edit', $intern) }}"
                                       class="action-btn-sm action-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.intern.destroy', $intern) }}" method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Hapus data {{ addslashes($intern->name) }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn-sm action-delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>Belum ada peserta magang aktif.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activeInterns->hasPages())
            <div style="margin-top:16px;">
                {{ $activeInterns->links() }}
            </div>
        @endif
    </div>

    {{-- ── TABEL ALUMNI ── --}}
    <div class="panel anim-4">
        <div class="table-header">
            <div class="table-header-title">
                <div class="table-icon gray"><i class="fas fa-user-graduate"></i></div>
                <div>
                    <p class="table-title" style="color:#374151;">Data Alumni</p>
                    <p class="table-subtitle">Peserta yang telah selesai masa magang</p>
                </div>
            </div>
            <span class="count-badge gray">{{ $alumniInterns->total() }} alumni</span>
        </div>

        <div style="overflow-x:auto;overflow-y:auto;max-height:420px;border-radius:14px;border:1px solid #f1f5f9;">
            <table class="data-table alumni">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Institusi</th>
                        <th>Tim</th>
                        <th>Mentor</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumniInterns as $intern)
                        <tr>
                            <td>
                                <div class="avatar-cell">
                                    @if($intern->photo_path)
                                        <img src="{{ url('storage/'.$intern->photo_path) }}"
                                             alt="{{ $intern->name }}"
                                             class="avatar-sm" style="border-color:#e2e8f0;">
                                    @else
                                        <div class="avatar-sm-placeholder gray">
                                            {{ strtoupper(substr($intern->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="cell-name" style="color:#374151;">{{ $intern->name }}</span>
                                </div>
                            </td>
                            <td class="mono" style="font-size:12px;color:#94a3b8;">{{ $intern->user->email }}</td>
                            <td style="color:#6b7280;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $intern->institution }}
                            </td>
                            <td>
                                @if($intern->team)
                                    <span class="pill pill-gray">{{ $intern->team->name }}</span>
                                @else
                                    <span style="color:#d1d5db;">—</span>
                                @endif
                            </td>
                            <td style="color:#6b7280;">{{ $intern->mentor?->name ?? '—' }}</td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.intern.show', $intern) }}"
                                       class="action-btn-sm action-view" title="Lihat detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.intern.edit', $intern) }}"
                                       class="action-btn-sm action-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.intern.destroy', $intern) }}" method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Hapus data {{ addslashes($intern->name) }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn-sm action-delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>Belum ada data alumni.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($alumniInterns->hasPages())
            <div style="margin-top:16px;">
                {{ $alumniInterns->links() }}
            </div>
        @endif
    </div>

</div>
</div>
@endsection