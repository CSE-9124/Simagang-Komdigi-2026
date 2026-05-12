@extends('layouts.app')

@section('title', 'Kelola Akun Admin - Sistem Manajemen Magang')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .mono { font-family: 'DM Mono', monospace; }

        body { background: #f0f4ff; }

        .dash-bg {
            background: linear-gradient(135deg, #e8eeff 0%, #f0f4ff 40%, #e4ecff 100%);
            min-height: 100vh;
        }

        /* ── Profile Strip (mirrors dashboard) ── */
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
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }
        .profile-strip::after {
            content: '';
            position: absolute;
            bottom: -80px; left: 30%;
            width: 300px; height: 300px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        /* ── Avatar ring (mirrors dashboard) ── */
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

        /* ── Panel (mirrors dashboard) ── */
        .panel {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(30, 58, 138, 0.06), 0 4px 20px rgba(30, 58, 138, 0.06);
            overflow: hidden;
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

        /* ── Input ── */
        .input-main {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1.5px solid #e0e7ff;
            border-radius: 0.75rem;
            background: #f8faff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            font-size: 14px;
            color: #1e3a8a;
            transition: all .15s ease;
        }
        .input-main::placeholder { color: #94a3b8; }
        .input-main:focus {
            outline: none;
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        /* ── Action button (mirrors dashboard action-btn) ── */
        .action-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            background: linear-gradient(110deg, #1e3a8a, #3b4fd8);
            color: #fff;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .action-btn-primary:hover {
            box-shadow: 0 6px 16px rgba(59, 79, 216, 0.3);
            transform: translateY(-1px);
            color: #fff;
            text-decoration: none;
        }

        .search-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0.65rem 1.25rem;
            background: linear-gradient(110deg, #1e3a8a, #3b4fd8);
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .search-btn:hover {
            box-shadow: 0 4px 12px rgba(59, 79, 216, 0.3);
            transform: translateY(-1px);
        }

        /* ── Table ── */
        .admin-table { min-width: 600px; }
        .admin-table th {
            padding: 12px 18px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #3730a3;
            background: #f0f4ff;
        }
        .admin-table td {
            padding: 14px 18px;
            font-size: 13px;
            color: #334155;
            vertical-align: middle;
        }
        .admin-table tbody tr { transition: background 0.15s; }
        .admin-table tbody tr:hover { background: #f8faff !important; }

        /* ── Role badges ── */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        /* ── Action icon buttons ── */
        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px; height: 32px;
            border-radius: 8px;
            font-size: 13px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .icon-btn-edit {
            background: #eff6ff;
            color: #3b82f6;
        }
        .icon-btn-edit:hover {
            background: #dbeafe;
            color: #1d4ed8;
            transform: translateY(-1px);
        }
        .icon-btn-delete {
            background: #fff1f2;
            color: #ef4444;
            border: none;
            cursor: pointer;
        }
        .icon-btn-delete:hover {
            background: #fee2e2;
            color: #b91c1c;
            transform: translateY(-1px);
        }

        /* ── Count badge (summary in header) ── */
        .count-badge {
            font-family: 'DM Mono', monospace;
            font-size: 38px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        /* ── Animations ── */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-1 { animation: fadeSlideUp 0.5s ease both; }
        .anim-2 { animation: fadeSlideUp 0.5s ease 0.1s both; }
        .anim-3 { animation: fadeSlideUp 0.5s ease 0.2s both; }

        /* ── Mobile ── */
        @media (max-width: 640px) {
            .avatar-inner { width: 60px; height: 60px; }
            .panel { padding: 16px; }
            .count-badge { font-size: 28px; }
        }
    </style>
@endpush

@section('content')
    <div class="dash-bg py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto space-y-6">

            {{-- ── PROFILE HEADER (mirrors dashboard profile-strip) ── --}}
            <div class="profile-strip anim-1">
                <div class="px-6 py-7 flex flex-col sm:flex-row items-center sm:items-start gap-5 relative z-10">

                    {{-- Avatar --}}
                    <div class="avatar-ring flex-shrink-0">
                        <div class="avatar-inner">
                            <i class="fas fa-user-shield text-2xl text-white"></i>
                        </div>
                    </div>

                    {{-- Identity --}}
                    <div class="flex-1 text-center sm:text-left">
                        <h1 class="text-xl font-bold text-white mb-1">Kelola Akun Admin</h1>
                        <p class="text-blue-200 font-semibold text-base">BBLSDM Komdigi Makassar</p>
                        <p class="text-blue-300 text-sm mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Atur super admin dan admin lain sesuai akses yang dibutuhkan.
                        </p>
                    </div>

                    {{-- Summary right + Tambah Admin CTA --}}
                    <div class="flex-shrink-0 flex flex-col items-center sm:items-end gap-3">
                        <div class="text-center sm:text-right">
                            <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Total Admin</p>
                            <p class="count-badge">{{ $accounts->total() }}</p>
                        </div>
                        <a href="{{ route('admin.accounts.create') }}" class="action-btn-primary">
                            <i class="fas fa-plus text-xs"></i>
                            <span>Tambah Admin</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── ACCOUNTS TABLE PANEL ── --}}
            <div class="panel anim-2">

                {{-- Panel header bar --}}
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-white text-base font-bold flex items-center gap-3">
                        <i class="fas fa-user-shield"></i>
                        Daftar Akun Admin
                    </h2>
                </div>

                <div class="p-6">

                    {{-- Search bar --}}
                    <form method="GET" action="{{ route('admin.accounts.index') }}"
                        class="mb-6 flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1 sm:max-w-md">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-blue-300 text-sm pointer-events-none">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama atau email..."
                                class="input-main pl-9">
                        </div>
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search text-xs"></i>
                            <span>Cari</span>
                        </button>
                    </form>

                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-xl border border-blue-50">
                        <table class="admin-table min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr>
                                    <th class="text-left rounded-tl-xl">Nama</th>
                                    <th class="text-left">Email</th>
                                    <th class="text-left">Role</th>
                                    <th class="text-center rounded-tr-xl">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-50">
                                @forelse($accounts as $account)
                                    @php
                                        $roleName = $account->getRoleNames()->first() ?? ($account->role ?? '-');
                                        $roleBadgeMap = [
                                            'super_admin' => [
                                                'label'   => 'Super Admin',
                                                'classes' => 'background:#fef2f2;color:#b91c1c;',
                                                'dot'     => '#ef4444',
                                            ],
                                            'admin_full' => [
                                                'label'   => 'Admin Full',
                                                'classes' => 'background:#eff6ff;color:#1d4ed8;',
                                                'dot'     => '#3b82f6',
                                            ],
                                            'admin_user_manager' => [
                                                'label'   => 'Admin User Manager',
                                                'classes' => 'background:#f0fdf4;color:#15803d;',
                                                'dot'     => '#22c55e',
                                            ],
                                            'admin_data_manager' => [
                                                'label'   => 'Admin Data Manager',
                                                'classes' => 'background:#fefce8;color:#a16207;',
                                                'dot'     => '#f59e0b',
                                            ],
                                        ];
                                        $roleBadge = $roleBadgeMap[$roleName] ?? [
                                            'label'   => str_replace('_', ' ', ucwords($roleName, '_')),
                                            'classes' => 'background:#f1f5f9;color:#475569;',
                                            'dot'     => '#94a3b8',
                                        ];
                                    @endphp
                                    <tr>
                                        {{-- Nama with mini avatar --}}
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#60a5fa,#818cf8);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                    <i class="fas fa-user text-white" style="font-size:13px;"></i>
                                                </div>
                                                <span class="font-semibold text-gray-800">{{ $account->name }}</span>
                                            </div>
                                        </td>

                                        {{-- Email --}}
                                        <td class="text-gray-500">{{ $account->email }}</td>

                                        {{-- Role badge --}}
                                        <td>
                                            <span class="role-badge" style="{{ $roleBadge['classes'] }}">
                                                <span style="width:6px;height:6px;border-radius:50%;background:{{ $roleBadge['dot'] }};display:inline-block;flex-shrink:0;"></span>
                                                {{ $roleBadge['label'] }}
                                            </span>
                                        </td>

                                        {{-- Actions --}}
                                        <td>
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.accounts.edit', $account) }}"
                                                    class="icon-btn icon-btn-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                @if (!$account->isSuperAdmin())
                                                    <form action="{{ route('admin.accounts.destroy', $account) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirm('Hapus akun admin ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="icon-btn icon-btn-delete" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-xs text-gray-300 font-medium px-2">Terlindungi</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-14 text-center">
                                            <i class="fas fa-user-slash text-4xl text-gray-200 mb-3 block"></i>
                                            <p class="text-sm text-gray-400 font-medium">Belum ada akun admin.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $accounts->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection