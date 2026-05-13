@extends('layouts.app')

@section('title', 'Tambah Akun Admin - Sistem Manajemen Magang')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .dash-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8eeff 0%, #f0f4ff 40%, #e4ecff 100%);
        }

        .hero-strip {
            background: linear-gradient(100deg, #1e3a8a 0%, #3b4fd8 50%, #4f46e5 100%);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(20, 40, 120, 0.16);
            color: #fff;
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

        .panel {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(30, 58, 138, 0.06), 0 4px 20px rgba(30, 58, 138, 0.06);
            overflow: hidden;
        }

        .input-main {
            width: 100%;
            padding: 0.6rem 0.9rem;
            border: 1px solid #d1d5db;
            border-radius: 0.6rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            transition: all .15s ease;
            font-size: 14px;
            color: #111827;
            background: #fff;
        }

        .input-main::placeholder { color: #9ca3af; }

        .input-main:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        select.input-main { cursor: pointer; }

        .field-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
        }

        .field-label i { color: #93c5fd; font-size: 12px; }

        .field-hint {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 4px;
        }

        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 12px;
        }

        .form-divider {
            height: 1px;
            background: linear-gradient(to right, #e0e7ff, transparent);
            margin: 8px 0;
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: 10px;
            border: 1.5px solid #e0e7ff;
            background: #f8faff;
            color: #6b7280;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            border-color: #c7d2fe;
            background: #eff2ff;
            color: #3730a3;
            text-decoration: none;
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 24px;
            background: linear-gradient(to right, #2563eb, #4f46e5);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-save:hover {
            box-shadow: 0 6px 16px rgba(59, 79, 216, 0.3);
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 1.6rem; }
        }
    </style>
@endpush

@php
    $permissionLabels = [
        'view_users' => 'Melihat daftar user (Intern dan Mentor)',
        'create_users' => 'Membuat user baru (Intern dan Mentor)',
        'edit_users' => 'Mengedit user (Intern dan Mentor)',
        'delete_users' => 'Menghapus user (Intern dan Mentor)',
        'view_admins' => 'Melihat daftar Admin',
        'create_admin' => 'Membuat Admin baru (dengan assign aksesibilitas)',
        'edit_admin' => 'Mengedit Admin (update akses)',
        'delete_admin' => 'Menghapus Admin (hanya Super Admin)',
        'view_mentors' => 'Melihat daftar Mentor',
        'manage_mentors' => 'Kelola data Mentor (CRUD)',
        'view_attendance' => 'Melihat data Absensi',
        'manage_attendance' => 'Kelola Absensi (Approve/Reject)',
        'view_logbook' => 'Melihat data Logbook',
        'manage_logbook' => 'Kelola Logbook (Approve/Reject)',
        'view_reports' => 'Melihat Laporan Akhir',
        'manage_reports' => 'Kelola Laporan Akhir (Approve/Reject/Score)',
        'manage_pengajuan' => 'Kelola Pengajuan Calon Anak Magang (Approve/Reject/Revision)',
        'view_interns' => 'Melihat daftar Intern',
        'manage_interns' => 'Kelola data Intern (CRUD)',
        'view_teams' => 'Melihat daftar Tim',
        'manage_teams' => 'Kelola data Tim (CRUD)',
        'access_admin_dashboard' => 'Akses Admin Dashboard',
    ];

    $roleAccessInfo = [
        'admin_full' => [
            'description' => 'Akses paling lengkap untuk mengelola user, mentor, peserta magang, absensi, logbook, laporan akhir, pengajuan, tim, dan dashboard admin.',
            'permissions' => [
                'view_users',
                'create_users',
                'edit_users',
                'delete_users',
                'view_mentors',
                'manage_mentors',
                'view_interns',
                'manage_interns',
                'view_attendance',
                'manage_attendance',
                'view_logbook',
                'manage_logbook',
                'view_reports',
                'manage_reports',
                'manage_pengajuan',
                'view_teams',
                'manage_teams',
                'access_admin_dashboard',
            ],
        ],
        'admin_user_manager' => [
            'description' => 'Fokus pada pengelolaan user dan data pendukung, dengan akses lihat ke beberapa data operasional.',
            'permissions' => [
                'view_users',
                'view_interns',
                'manage_interns',
                'view_mentors',
                'manage_mentors',
                'view_attendance',
                'view_logbook',
                'view_reports',
                'access_admin_dashboard',
            ],
        ],
        'admin_data_manager' => [
            'description' => 'Berfokus pada pengelolaan data peserta magang dan operasional pendukung seperti absensi, logbook, dan laporan.',
            'permissions' => [
                'view_interns',
                'manage_interns',
                'view_attendance',
                'manage_attendance',
                'view_logbook',
                'manage_logbook',
                'view_reports',
                'manage_reports',
                'access_admin_dashboard',
            ],
        ],
    ];
@endphp

@section('content')
    <div class="dash-bg py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">

            {{-- ── HERO STRIP ── --}}
            <div class="hero-strip mb-6">
                <div class="relative z-10 px-6 py-7">
                    <h1 class="hero-title text-4xl font-bold mb-1">Tambah Akun Admin</h1>
                    <p class="text-blue-100">Buat akun admin baru dengan role yang sesuai kebutuhan.</p>
                </div>
            </div>

            {{-- ── FORM PANEL ── --}}
            <div class="panel">

                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-pen mr-3"></i>Informasi Akun
                    </h2>
                </div>

                <form action="{{ route('admin.accounts.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    {{-- Data Utama --}}
                    <p class="section-label">Data Utama</p>

                    <div>
                        <label class="field-label">
                            <i class="fas fa-user"></i> Nama Lengkap
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="input-main" required placeholder="Masukkan nama lengkap">
                        @error('name')
                            <p class="text-xs text-red-500 flex items-center gap-1 mt-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="field-label">
                            <i class="fas fa-envelope"></i> Alamat Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="input-main" required placeholder="contoh@email.com">
                        @error('email')
                            <p class="text-xs text-red-500 flex items-center gap-1 mt-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="field-label">
                            <i class="fas fa-id-badge"></i> Akses Admin
                        </label>
                        <select name="role" class="input-main" required>
                            <option value="">Pilih Akses...</option>
                            @foreach ($roleOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('role') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <div class="mt-3 rounded-2xl border border-blue-100 bg-blue-50/70 p-4" id="role-access-info" aria-live="polite">
                            <div class="flex items-start gap-3">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-slate-800">Informasi akses role</p>
                                    <p class="mt-1 text-sm leading-6 text-slate-600" id="role-access-description">
                                        Pilih Akses Admin untuk melihat permission yang tersedia.
                                    </p>
                                    <div class="mt-3 hidden" id="role-access-permissions-wrapper">
                                        <p class="text-xs font-bold uppercase tracking-[0.08em] text-slate-500">Permission yang diberikan</p>
                                        <ul class="mt-2 grid gap-2 sm:grid-cols-2" id="role-access-permissions"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('role')
                            <p class="text-xs text-red-500 flex items-center gap-1 mt-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-divider"></div>

                    {{-- Password --}}
                    <p class="section-label">Password</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input type="password" name="password"
                                class="input-main" required placeholder="Minimal 8 karakter">
                            @error('password')
                                <p class="text-xs text-red-500 flex items-center gap-1 mt-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">
                                <i class="fas fa-lock"></i> Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation"
                                class="input-main" required placeholder="Ulangi password">
                        </div>
                    </div>

                    <p class="field-hint">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Gunakan kombinasi huruf, angka, dan simbol untuk keamanan lebih baik.
                    </p>

                    <div class="form-divider"></div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('admin.accounts.index') }}" class="btn-cancel">
                            <i class="fas fa-arrow-left text-xs"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save text-xs"></i>
                            Simpan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.querySelector('select[name="role"]');
            const description = document.getElementById('role-access-description');
            const permissionsWrapper = document.getElementById('role-access-permissions-wrapper');
            const permissionsList = document.getElementById('role-access-permissions');
            const permissionLabels = @json($permissionLabels);
            const roleAccessInfo = @json($roleAccessInfo);

            if (!roleSelect || !description || !permissionsWrapper || !permissionsList) {
                return;
            }

            const renderRoleInfo = (role) => {
                const info = roleAccessInfo[role];

                if (!info) {
                    description.textContent = 'Pilih Akses Admin untuk melihat permission yang tersedia.';
                    permissionsWrapper.classList.add('hidden');
                    permissionsList.innerHTML = '';
                    return;
                }

                description.textContent = info.description;
                permissionsList.innerHTML = info.permissions
                    .map((permission) => `
                        <li class="flex items-start gap-2 rounded-lg bg-white px-3 py-2 text-sm text-slate-700 shadow-sm ring-1 ring-blue-100">
                            <i class="fas fa-circle-check mt-1 text-[11px] text-blue-600"></i>
                            <span>${permissionLabels[permission] ?? permission}</span>
                        </li>
                    `)
                    .join('');
                permissionsWrapper.classList.remove('hidden');
            };

            roleSelect.addEventListener('change', function () {
                renderRoleInfo(this.value);
            });

            renderRoleInfo(roleSelect.value);
        });
    </script>
@endsection