@extends('layouts.app')

@section('title', 'Mikro Skill Intern - Sistem Manajemen Magang')

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
            box-shadow: 0 1px 3px rgba(30,58,138,0.06), 0 4px 20px rgba(30,58,138,0.06);
            overflow: hidden;
        }

        /* ── Toolbar (search + add) ── */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }
        .toolbar-search {
            flex: 1;
            position: relative;
            min-width: 0;
        }
        .toolbar-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #93c5fd;
            font-size: 13px;
            pointer-events: none;
        }

        /* ── Input ── */
        .input-main {
            width: 100%;
            padding: 0.7rem 1rem 0.7rem 2.4rem;
            border: 1.5px solid #e0e7ff;
            border-radius: 0.75rem;
            background: #f8faff;
            font-size: 14px;
            color: #1e3a8a;
            transition: all .15s ease;
        }
        .input-main::placeholder { color: #94a3b8; }
        .input-main:focus {
            outline: none;
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 0.7rem 1.1rem;
            border-radius: 0.75rem;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
            flex-shrink: 0;
        }
        .btn-search {
            background: linear-gradient(110deg, #1e3a8a, #3b4fd8);
            color: #fff;
        }
        .btn-search:hover {
            box-shadow: 0 4px 12px rgba(59,79,216,0.3);
            transform: translateY(-1px);
            color: #fff;
        }
        .btn-reset {
            background: #f8faff;
            color: #6b7280;
            border: 1.5px solid #e0e7ff;
        }
        .btn-reset:hover {
            border-color: #c7d2fe;
            background: #eff2ff;
            color: #3730a3;
            text-decoration: none;
        }
        .btn-add {
            background: linear-gradient(110deg, #059669, #10b981);
            color: #fff;
        }
        .btn-add:hover {
            box-shadow: 0 4px 12px rgba(16,185,129,0.3);
            transform: translateY(-1px);
            color: #fff;
            text-decoration: none;
        }

        /* ── Table ── */
        .skill-table { min-width: 600px; }
        .skill-table th {
            padding: 12px 18px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #3730a3;
            background: #f0f4ff;
        }
        .skill-table td {
            padding: 14px 18px;
            font-size: 13px;
            color: #334155;
            vertical-align: middle;
        }
        .skill-table tbody tr { transition: background 0.15s; }
        .skill-table tbody tr:hover { background: #f8faff !important; }

        /* ── Count pill ── */
        .count-pill {
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            font-weight: 600;
            padding: 3px 14px;
            border-radius: 999px;
            background: #e0e7ff;
            color: #3730a3;
            min-width: 40px;
            text-align: center;
            display: inline-block;
        }

        /* ── Link chip ── */
        .link-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            max-width: 240px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: background 0.15s;
        }
        .link-chip:hover {
            background: #dbeafe;
            color: #1d4ed8;
            text-decoration: none;
        }

        /* ── Action icon buttons ── */
        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        .icon-btn-detail {
            background: #eff6ff;
            color: #2563eb;
        }
        .icon-btn-detail:hover {
            background: #dbeafe;
            color: #1d4ed8;
            transform: translateY(-1px);
            text-decoration: none;
        }
        .icon-btn-delete {
            background: #fff1f2;
            color: #ef4444;
        }
        .icon-btn-delete:hover {
            background: #fee2e2;
            color: #b91c1c;
            transform: translateY(-1px);
        }

        /* ── Divider ── */
        .toolbar-divider {
            width: 1px;
            height: 28px;
            background: #e0e7ff;
            flex-shrink: 0;
        }

        /* ── Animations ── */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-1 { animation: fadeSlideUp 0.5s ease both; }
        .anim-2 { animation: fadeSlideUp 0.5s ease 0.1s both; }

        @media (max-width: 640px) {
            .avatar-inner { width: 60px; height: 60px; }
            .toolbar { flex-wrap: wrap; }
            .toolbar-divider { display: none; }
            .btn-add { width: 100%; }
        }
    </style>
@endpush

@section('content')
<div class="dash-bg py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- ── PROFILE HEADER ── --}}
        <div class="profile-strip anim-1">
            <div class="px-6 py-7 flex flex-col sm:flex-row items-center sm:items-start gap-5 relative z-10">

                <div class="avatar-ring flex-shrink-0">
                    <div class="avatar-inner">
                        <i class="fas fa-graduation-cap text-2xl text-white"></i>
                    </div>
                </div>

                <div class="flex-1 text-center sm:text-left">
                    <h1 class="text-xl font-bold text-white mb-1">Mikro Skill Intern</h1>
                    <p class="text-blue-200 font-semibold text-base">BBPSDMP Komdigi Makassar</p>
                    <p class="text-blue-300 text-sm mt-1">
                        <i class="fas fa-chart-line mr-1"></i>
                        Monitoring mikro skill anak magang
                    </p>
                </div>

                <div class="flex-shrink-0 text-center sm:text-right">
                    <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Total Mikro Skill</p>
                    <p class="text-5xl font-extrabold text-white mono">{{ $microskills->total() }}</p>
                    <p class="text-blue-300 text-xs mt-1">entri terdaftar</p>
                </div>
            </div>
        </div>

        {{-- ── TABLE PANEL ── --}}
        <div class="panel anim-2">

            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-white text-base font-bold flex items-center gap-3">
                    <i class="fas fa-star"></i>
                    Data Mikro Skill
                </h2>
            </div>

            <div class="p-6">

                {{-- ── TOOLBAR: search + reset + divider + add ── --}}
                <form method="GET" class="mb-6">
                    <div class="toolbar">
                        {{-- Search input --}}
                        <div class="toolbar-search">
                            <span class="toolbar-search-icon">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="q" value="{{ request('q') }}"
                                placeholder="Cari judul atau link mikro skill..."
                                class="input-main">
                        </div>

                        {{-- Search button --}}
                        <button type="submit" class="btn btn-search">
                            <i class="fas fa-search" style="font-size:11px;"></i>
                            Cari
                        </button>

                        {{-- Reset (conditional) --}}
                        @if(request()->anyFilled(['q']))
                            <a href="{{ route('admin.microskill.index') }}" class="btn btn-reset">
                                <i class="fas fa-times" style="font-size:11px;"></i>
                                Reset
                            </a>
                        @endif

                        {{-- Visual separator --}}
                        <div class="toolbar-divider"></div>

                        {{-- Add button --}}
                        <a href="{{ route('admin.microskill.create') }}" class="btn btn-add">
                            <i class="fas fa-plus" style="font-size:11px;"></i>
                            Tambah Microskill
                        </a>
                    </div>
                </form>

                {{-- ── TABLE ── --}}
                <div class="overflow-x-auto rounded-xl border border-blue-50">
                    <table class="skill-table min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr>
                                <th class="text-left rounded-tl-xl">Judul</th>
                                <th class="text-left">Link</th>
                                <th class="text-center">Total Pengerjaan</th>
                                <th class="text-right rounded-tr-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse($microskills as $m)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div style="width:34px;height:34px;border-radius:8px;background:linear-gradient(135deg,#8b5cf6,#7c3aed);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <i class="fas fa-book-open text-white" style="font-size:12px;"></i>
                                            </div>
                                            <span class="font-semibold text-gray-800">{{ $m->judul_micro }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ $m->link_micro }}" target="_blank" class="link-chip">
                                            <i class="fas fa-external-link-alt" style="font-size:10px;flex-shrink:0;"></i>
                                            {{ $m->link_micro }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="count-pill">{{ $m->total ?? 0 }}</span>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex items-center gap-2 justify-end">
                                            <a href="{{ route('admin.microskill.show', ['id' => $m->id]) }}"
                                                class="icon-btn icon-btn-detail">
                                                <i class="fas fa-eye" style="font-size:11px;"></i>
                                                Detail
                                            </a>
                                            <form action="{{ route('admin.microskill.destroy', ['id' => $m->id]) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus microskill ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="icon-btn icon-btn-delete">
                                                    <i class="fas fa-trash" style="font-size:11px;"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-14 text-center">
                                        <i class="fas fa-inbox text-4xl text-gray-200 mb-3 block"></i>
                                        <p class="text-sm text-gray-400 font-medium">Tidak ada data mikro skill.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">{{ $microskills->links() }}</div>

            </div>
        </div>

    </div>
</div>
@endsection