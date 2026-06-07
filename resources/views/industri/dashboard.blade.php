@extends('layouts.app')

@section('title', 'Dashboard Industri')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .mono {
        font-family: 'DM Mono', monospace;
    }

    body {
        background: #f3f7ff;
    }

    .dash-bg {
        min-height: 100vh;
        background:
            radial-gradient(circle at top right, rgba(99, 102, 241, 0.12), transparent 30%),
            linear-gradient(135deg, #eef4ff 0%, #f5f7ff 40%, #edf3ff 100%);
    }

    .hero-card {
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        background: linear-gradient(135deg, #1e3a8a 0%, #4338ca 55%, #6366f1 100%);
        box-shadow: 0 15px 40px rgba(30, 58, 138, 0.18);
    }

    .hero-card::before {
        content: '';
        position: absolute;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        top: -120px;
        right: -80px;
    }

    .hero-card::after {
        content: '';
        position: absolute;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        bottom: -180px;
        left: -80px;
    }

    .company-logo {
        width: 88px;
        height: 88px;
        border-radius: 24px;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .company-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .panel {
        background: #fff;
        border-radius: 24px;
        padding: 24px;
        box-shadow:
            0 4px 20px rgba(15, 23, 42, 0.04),
            0 1px 3px rgba(15, 23, 42, 0.06);
    }

    .section-label {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 18px;
    }

    .stats-card {
        border-radius: 22px;
        padding: 22px;
        transition: all .25s ease;
    }

    .stats-card:hover {
        transform: translateY(-4px);
    }

    .stats-blue {
        background: linear-gradient(135deg, #dbeafe, #eef2ff);
    }

    .stats-green {
        background: linear-gradient(135deg, #dcfce7, #f0fdf4);
    }

    .stats-orange {
        background: linear-gradient(135deg, #fef3c7, #fffbeb);
    }

    .stats-red {
        background: linear-gradient(135deg, #fee2e2, #fff1f2);
    }

    .stats-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px;
        border-radius: 18px;
        border: 1.5px solid #e2e8f0;
        background: #f8fbff;
        transition: all .2s ease;
        text-decoration: none;
    }

    .quick-action:hover {
        border-color: #a5b4fc;
        background: #eef2ff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .quick-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e0e7ff;
        color: #4338ca;
        font-size: 18px;
        flex-shrink: 0;
    }

    .profile-alert {
        border-radius: 20px;
        background: linear-gradient(135deg, #fff7ed, #fffbeb);
        border: 1px solid #fdba74;
        padding: 22px;
    }

    .progress-track {
        width: 100%;
        height: 10px;
        background: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        width: 68%;
        border-radius: 999px;
        background: linear-gradient(90deg, #3b82f6, #6366f1);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .badge-approved {
        background: rgba(34,197,94,.12);
        color: #15803d;
        border: 1px solid rgba(34,197,94,.2);
    }

    .badge-pending {
        background: rgba(245,158,11,.12);
        color: #b45309;
        border: 1px solid rgba(245,158,11,.2);
    }

    .activity-item {
        display: flex;
        gap: 14px;
        padding: 14px 0;
    }

    .activity-item:not(:last-child) {
        border-bottom: 1px solid #f1f5f9;
    }

    .activity-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .divider {
        border-top: 1px solid #f1f5f9;
    }

    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .anim-1 { animation: fadeSlideUp .5s ease both; }
    .anim-2 { animation: fadeSlideUp .5s ease .1s both; }
    .anim-3 { animation: fadeSlideUp .5s ease .2s both; }
    .anim-4 { animation: fadeSlideUp .5s ease .3s both; }
</style>
@endpush

@section('content')

@php
    
    $pelamarMasuk   = 47;
    $magangBerjalan = 19;


    $industri = $industri ?? null;


    $profileIncomplete =
        !$industri ||
        empty($industri->deskripsi_industri) ||
        empty($industri->alamat_industri) ||
        empty($industri->logo_industri) ||
        empty($industri->nomor_telepon_industri) ||
        empty($industri->nib);
@endphp

<div class="dash-bg py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- HERO --}}
        <div class="hero-card p-7 anim-1">
            <div class="relative z-10 flex flex-col lg:flex-row gap-6 lg:items-center">

                {{-- Logo --}}
                <div class="company-logo">
                    @if ($industri && $industri->logo_industri)
                        <img src="{{ asset('storage/' . $industri->logo_industri) }}" alt="Logo Industri">
                    @else
                        <i class="fas fa-building text-3xl text-white"></i>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 text-center lg:text-left">

                    <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                        <h1 class="text-2xl lg:text-3xl font-extrabold text-white">
                            {{ $industri->nama_industri ?? 'Industri Belum Diatur' }}
                        </h1>
                    </div>

                    <p class="text-indigo-100 mt-2 font-medium">
                        {{ $industri->bidang_industri ?? 'Bidang industri belum diisi' }}
                    </p>

                    <div class="flex flex-wrap gap-5 mt-5 text-sm text-indigo-100 justify-center lg:justify-start">

                        <div>
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            {{ $industri->kota_kabupaten ?? '-' }}
                        </div>

                        <div>
                            <i class="fas fa-envelope mr-1"></i>
                            {{ $industri->email_industri ?? auth()->user()->email }}
                        </div>

                    </div>
                </div>

                {{-- Statistik --}}
                <div class="text-center lg:text-right">
                    <p class="text-indigo-200 text-xs uppercase tracking-[0.2em] font-bold mb-2">
                        Total Lowongan
                    </p>

                    <h2 class="text-5xl font-extrabold text-white mono">
                        {{ $totalLowongan ?? '0' }}
                    </h2>

                    <p class="text-indigo-200 text-sm mt-1">
                        Lowongan tersedia
                    </p>
                </div>

            </div>
        </div>

        {{-- ALERT --}}
        @if ($profileIncomplete)
            <div class="profile-alert anim-2">

                <div class="flex flex-col lg:flex-row gap-5 lg:items-center">

                    <div class="flex gap-4 flex-1">

                        <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-orange-500 text-xl"></i>
                        </div>

                        <div class="flex-1">

                            <h3 class="font-bold text-orange-900 text-lg mb-1">
                                Profil Industri Belum Lengkap
                            </h3>

                            <p class="text-orange-800 text-sm leading-relaxed">
                                Lengkapi profil industri terlebih dahulu agar perusahaan Anda terlihat lebih profesional
                                dan dapat membuka lowongan magang dengan optimal.
                            </p>

                            <div class="mt-4">

                                <div class="flex justify-between text-xs font-semibold text-orange-700 mb-2">
                                    <span>Kelengkapan Profil</span>
                                    <span>{{ $progress }}%</span>
                                </div>

                                <div class="progress-track">
                                    <div class="progress-fill" style="width: {{ $progress }}%"></div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div>
                        <a href="{{ route('industri.profile.create') }}"
                           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-3 rounded-2xl transition">
                            <i class="fas fa-user-edit"></i>
                            Lengkapi Profil
                        </a>
                    </div>

                </div>

            </div>
        @endif

        {{-- STATS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 anim-2">

            <div class="stats-card stats-blue">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-semibold text-blue-700">
                            Total Lowongan
                        </p>

                        <h2 class="text-3xl font-extrabold text-slate-800 mt-2 mono">
                            {{ $totalLowongan ?? '0' }}
                        </h2>

                        <p class="text-xs text-slate-500 mt-1">
                            Semua lowongan magang
                        </p>
                    </div>

                    <div class="stats-icon bg-blue-100 text-blue-600">
                        <i class="fas fa-briefcase"></i>
                    </div>

                </div>
            </div>

            <div class="stats-card stats-green">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-semibold text-green-700">
                            Lowongan Terverifikasi
                        </p>

                        <h2 class="text-3xl font-extrabold text-slate-800 mt-2 mono">
                            {{ $totalLowonganVerifikasi ?? '0' }}
                        </h2>

                        <p class="text-xs text-slate-500 mt-1">
                            Semua lowongan yang sudah disetujui admin
                        </p>
                    </div>

                    <div class="stats-icon bg-green-100 text-green-600">
                        <i class="fas fa-bolt"></i>
                    </div>

                </div>
            </div>

            <div class="stats-card stats-orange">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-semibold text-orange-700">
                            Pengajuan Masuk
                        </p>

                        <h2 class="text-3xl font-extrabold text-slate-800 mt-2 mono">
                            {{ $totalPengajuan ?? '0' }}
                        </h2>

                        <p class="text-xs text-slate-500 mt-1">
                            Total pengajuan
                        </p>
                    </div>

                    <div class="stats-icon bg-orange-100 text-orange-600">
                        <i class="fas fa-users"></i>
                    </div>

                </div>
            </div>

            {{-- <div class="stats-card stats-red">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-semibold text-red-700">
                            Magang Berjalan
                        </p>

                        <h2 class="text-3xl font-extrabold text-slate-800 mt-2 mono">
                            {{ $magangBerjalan ?? '0' }}
                        </h2>

                        <p class="text-xs text-slate-500 mt-1">
                            Peserta aktif
                        </p>
                    </div>

                    <div class="stats-icon bg-red-100 text-red-600">
                        <i class="fas fa-user-graduate"></i>
                    </div>

                </div>
            </div> --}}

        </div>

        {{-- MAIN --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- QUICK ACTION --}}
                <div class="panel anim-3">

                    <p class="section-label">
                        Aksi Cepat
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <a href="{{ route('industri.lowongan.create') }}" class="quick-action">
                            <div class="quick-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>

                            <div>
                                <h4 class="font-bold text-slate-800">
                                    Buat Lowongan
                                </h4>

                                <p class="text-sm text-slate-500">
                                    Tambahkan lowongan magang baru
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('industri.lowongan.index') }}" class="quick-action">
                            <div class="quick-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>

                            <div>
                                <h4 class="font-bold text-slate-800">
                                    Kelola Lowongan
                                </h4>

                                <p class="text-sm text-slate-500">
                                    Lihat semua lowongan magang
                                </p>
                            </div>
                        </a>

                        <a href="#" class="quick-action">
                            <div class="quick-icon">
                                <i class="fas fa-user-check"></i>
                            </div>

                            <div>
                                <h4 class="font-bold text-slate-800">
                                    Data Pelamar
                                </h4>

                                <p class="text-sm text-slate-500">
                                    Kelola pendaftar magang
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('industri.profile.create') }}" class="quick-action">
                            <div class="quick-icon">
                                <i class="fas fa-building"></i>
                            </div>

                            <div>
                                <h4 class="font-bold text-slate-800">
                                    Edit Profil
                                </h4>

                                <p class="text-sm text-slate-500">
                                    Perbarui informasi industri
                                </p>
                            </div>
                        </a>

                    </div>

                </div>

                
            </div>

            {{-- RIGHT --}}
            <div class="space-y-6">

                {{-- PROFILE --}}
                <div class="panel anim-3">

                    <p class="section-label">
                        Informasi Industri
                    </p>

                    <div class="space-y-4">

                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">
                                Nama Industri
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $industri->nama_industri ?? '-' }}
                            </p>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">
                                Bidang Industri
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $industri->bidang_industri ?? '-' }}
                            </p>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">
                                Kota / Kabupaten
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $industri->kota_kabupaten ?? '-' }}
                            </p>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">
                                Email
                            </p>

                            <p class="text-sm font-semibold text-slate-700 break-all">
                                {{ $industri->email_industri ?? '-' }}
                            </p>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">
                                Nomor Telepon
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $industri->nomor_telepon_industri ?? '-' }}
                            </p>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">
                                NIB
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $industri->nib ?? 'Belum diisi' }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">
                                NIB
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $industri->nib ?? 'Belum diisi' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection