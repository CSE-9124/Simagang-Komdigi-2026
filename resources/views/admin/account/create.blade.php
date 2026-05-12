@extends('layouts.app')

@section('title', 'Tambah Akun Admin - Sistem Manajemen Magang')

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

        /* ── Inputs ── */
        .input-main {
            width: 100%;
            padding: 0.7rem 1rem;
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
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }
        select.input-main { cursor: pointer; }

        /* ── Field group ── */
        .field-group { display: flex; flex-direction: column; gap: 6px; }
        .field-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .field-label i { color: #93c5fd; font-size: 12px; }

        /* ── Hint ── */
        .field-hint { font-size: 11px; color: #94a3b8; margin-top: 2px; }

        /* ── Divider ── */
        .form-divider {
            height: 1px;
            background: linear-gradient(to right, #e0e7ff, transparent);
            margin: 4px 0;
        }

        /* ── Buttons ── */
        .btn-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 11px 22px;
            border-radius: 12px;
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
            padding: 11px 26px;
            background: linear-gradient(110deg, #1e3a8a, #3b4fd8);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-save:hover {
            box-shadow: 0 6px 16px rgba(59, 79, 216, 0.3);
            transform: translateY(-1px);
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
        }
    </style>
@endpush

@section('content')
    <div class="dash-bg py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto space-y-6">

            {{-- ── PROFILE HEADER ── --}}
            <div class="profile-strip anim-1">
                <div class="px-6 py-7 flex flex-col sm:flex-row items-center sm:items-start gap-5 relative z-10">

                    {{-- Avatar --}}
                    <div class="avatar-ring flex-shrink-0">
                        <div class="avatar-inner">
                            <i class="fas fa-user-plus text-2xl text-white"></i>
                        </div>
                    </div>

                    {{-- Identity --}}
                    <div class="flex-1 text-center sm:text-left">
                        <h1 class="text-xl font-bold text-white mb-1">Tambah Akun Admin</h1>
                        <p class="text-blue-200 font-semibold text-base">BBLSDM Komdigi Makassar</p>
                        <p class="text-blue-300 text-sm mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Buat akun admin baru dengan role yang sesuai.
                        </p>
                    </div>

                    {{-- Right icon --}}
                    <div class="flex-shrink-0 text-center sm:text-right">
                        <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Akun Baru</p>
                        <div style="width:52px;height:52px;border-radius:50%;background:rgba(255,255,255,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto;">
                            <i class="fas fa-plus text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── FORM PANEL ── --}}
            <div class="panel anim-2">

                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-white text-base font-bold flex items-center gap-3">
                        <i class="fas fa-pen"></i>
                        Informasi Akun
                    </h2>
                </div>

                <form action="{{ route('admin.accounts.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    {{-- Data Utama --}}
                    <p class="section-label">Data Utama</p>

                    <div class="field-group">
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

                    <div class="field-group">
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

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-id-badge"></i> Role Admin
                        </label>
                        <select name="role" class="input-main" required>
                            <option value="">Pilih role...</option>
                            @foreach ($roleOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('role') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
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
                        <div class="field-group">
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

                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-lock"></i> Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation"
                                class="input-main" required placeholder="Ulangi password">
                        </div>
                    </div>

                    <p class="field-hint" style="margin-top:-8px;">
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
@endsection