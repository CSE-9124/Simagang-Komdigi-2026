@extends('layouts.app')

@section('title', 'Edit Profile Institusi - Sistem Manajemen Magang')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap');

        .dash-bg {
            background: linear-gradient(135deg, #e8eeff 0%, #f0f4ff 40%, #e4ecff 100%);
        }

        .hero-strip {
            position: relative;
            background: linear-gradient(110deg, #3b4fd8 0%, #4f46e5 50%, #6366f1 100%);
            padding: 2.5rem 2rem;
            border-radius: 1rem;
            color: white;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .hero-strip::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .hero-strip::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.05);
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

        .panel {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group input.error,
        .form-group textarea.error {
            border-color: #ef4444;
        }

        .error-message {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .help-text {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.375rem;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 50;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            max-width: 420px;
            width: 90%;
            text-align: center;
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            background: #dbeafe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: #3b82f6;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .modal-text {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
        }

        .modal-btn {
            flex: 1;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .modal-btn-cancel {
            background: #e5e7eb;
            color: #374151;
        }

        .modal-btn-cancel:hover {
            background: #d1d5db;
        }

        .modal-btn-confirm {
            background: #3b82f6;
            color: white;
        }

        .modal-btn-confirm:hover {
            background: #2563eb;
        }

        @media (max-width: 640px) {
            .hero-strip {
                padding: 1.5rem 1rem;
            }

            .hero-strip h1 {
                font-size: 1.5rem;
            }

            .hero-strip+div {
                margin-top: 1rem;
            }

            .panel-body {
                padding: 1.25rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .action-buttons {
                justify-content: stretch;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .modal-content {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dash-bg min-h-screen py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Strip -->
            <div class="hero-strip">
                <h1><i class="fas fa-user-edit mr-3" style="font-size: 2rem;"></i>Edit Profile Institusi</h1>
                <p>Perbarui informasi profil institusi Anda</p>
            </div>

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('institusi.profile.show') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>Kembali ke Profile
                </a>
            </div>

            <form id="institusi-form" method="POST" action="{{ route('institusi.profile.update') }}">
                @csrf
                @method('PUT')

                <!-- Informasi Institusi Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <i class="fas fa-building"></i>Informasi Institusi
                    </div>
                    <div class="panel-body">
                        <div class="form-row full">
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                    placeholder="Masukkan nama lengkap" @error('name') class="error" @enderror>
                                @error('name')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row full">
                            <div class="form-group">
                                <label for="nama_institusi">Nama Institusi</label>
                                <input type="text" name="nama_institusi" id="nama_institusi"
                                    value="{{ old('nama_institusi', $institusi->nama_institusi) }}"
                                    placeholder="Masukkan nama institusi" @error('nama_institusi') class="error" @enderror>
                                @error('nama_institusi')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="jenis_institusi">Jenis Institusi</label>
                                <input type="text" name="jenis_institusi" id="jenis_institusi"
                                    value="{{ old('jenis_institusi', $institusi->jenis_institusi) }}"
                                    placeholder="Contoh: Universitas / Perusahaan"
                                    @error('jenis_institusi') class="error" @enderror>
                                @error('jenis_institusi')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nomor_identitas">Nomor Identitas</label>
                                <input type="text" name="nomor_identitas" id="nomor_identitas"
                                    value="{{ old('nomor_identitas', $institusi->nomor_identitas) }}"
                                    placeholder="NIM / NIK / No. Registrasi"
                                    @error('nomor_identitas') class="error" @enderror>
                                @error('nomor_identitas')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="no_hp">Nomor Telepon</label>
                                <input type="text" name="no_hp" id="no_hp"
                                    value="{{ old('no_hp', $institusi->no_hp) }}" placeholder="Masukkan nomor telepon"
                                    @error('no_hp') class="error" @enderror>
                                @error('no_hp')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $user->email) }}" placeholder="Masukkan email"
                                    @error('email') class="error" @enderror>
                                @error('email')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="fakultas">Fakultas</label>
                                <input type="text" name="fakultas" id="fakultas"
                                    value="{{ old('fakultas', $institusi->fakultas) }}"
                                    placeholder="Masukkan nama fakultas">
                            </div>

                            <div class="form-group">
                                <label for="departemen">Departemen</label>
                                <input type="text" name="departemen" id="departemen"
                                    value="{{ old('departemen', $institusi->departemen) }}"
                                    placeholder="Masukkan nama departemen">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Change Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <i class="fas fa-lock"></i>Ubah Password
                    </div>
                    <div class="panel-body">
                        <p class="help-text mb-6">Kosongkan field password jika tidak ingin mengubah password.</p>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="current_password">Password Lama</label>
                                <input type="password" name="current_password" id="current_password"
                                    placeholder="Masukkan password saat ini"
                                    @error('current_password') class="error" @enderror>
                                @error('current_password')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" name="password" id="password"
                                    placeholder="Masukkan password baru" @error('password') class="error" @enderror>
                                @error('password')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row full">
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    placeholder="Konfirmasi password baru">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="button" id="btn-submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirm-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h3 class="modal-title">Simpan Perubahan?</h3>
            <p class="modal-text">Apakah Anda yakin ingin menyimpan perubahan pada profil institusi?</p>
            <div class="modal-buttons">
                <button id="btn-cancel" type="button" class="modal-btn modal-btn-cancel">
                    <i class="fas fa-times"></i>Tidak
                </button>
                <button id="btn-confirm" type="button" class="modal-btn modal-btn-confirm">
                    <i class="fas fa-check"></i>Ya, Simpan
                </button>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('confirm-modal');
        const form = document.getElementById('institusi-form');

        document.getElementById('btn-submit').addEventListener('click', function() {
            modal.classList.add('active');
        });

        document.getElementById('btn-cancel').addEventListener('click', function() {
            modal.classList.remove('active');
        });

        document.getElementById('btn-confirm').addEventListener('click', function() {
            modal.classList.remove('active');
            form.submit();
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    </script>
@endsection
