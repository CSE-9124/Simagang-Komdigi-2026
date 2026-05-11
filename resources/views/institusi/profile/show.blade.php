@extends('layouts.app')

@section('title', 'Profile Institusi - Sistem Manajemen Magang')

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

        .info-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-item label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item span {
            display: block;
            font-size: 1rem;
            color: #1f2937;
            font-weight: 500;
            word-break: break-word;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            gap: 0.5rem;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
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

            .info-row {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dash-bg min-h-screen py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Strip -->
            <div class="hero-strip">
                <h1><i class="fas fa-user-circle mr-3" style="font-size: 2rem;"></i>Profile Institusi</h1>
                <p>Kelola informasi profil institusi Anda</p>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons mb-6">
                <a href="{{ route('institusi.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>Kembali ke Dashboard
                </a>
                <a href="{{ route('institusi.profile.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>Edit Profile
                </a>
            </div>

            <!-- Profile Info Panel -->
            <div class="panel">
                <div class="panel-header">
                    <i class="fas fa-building"></i>Informasi Institusi
                </div>
                <div class="panel-body">
                    <div class="info-row">
                        <div class="info-item md:col-span-2">
                            <label>Nama Institusi</label>
                            <span>{{ $institusi->nama_institusi ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-item">
                            <label>Nama Lengkap</label>
                            <span>{{ $user->name ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Email</label>
                            <span>{{ $user->email ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-item">
                            <label>Jenis Institusi</label>
                            <span>{{ $institusi->jenis_institusi ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Nomor Identitas</label>
                            <span>{{ $institusi->nomor_identitas ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-item">
                            <label>Nomor Telepon</label>
                            <span>{{ $institusi->no_hp ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Fakultas</label>
                            <span>{{ $institusi->fakultas ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-item">
                            <label>Departemen</label>
                            <span>{{ $institusi->departemen ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Status Akun</label>
                            <span
                                class="status-badge {{ $user->is_active ?? true ? 'status-active' : 'status-inactive' }}">
                                <i
                                    class="fas {{ $user->is_active ?? true ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $user->is_active ?? true ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
