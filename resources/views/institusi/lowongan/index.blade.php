@extends('layouts.app')

@section('title', 'Verifikasi Lowongan')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

    *{
        font-family:'Plus Jakarta Sans',sans-serif;
    }

    body{
        background:#f4f7ff;
    }

    .page-bg{
        min-height:100vh;
        background:
            radial-gradient(circle at top left,#dbeafe 0%,transparent 25%),
            radial-gradient(circle at bottom right,#e0e7ff 0%,transparent 25%),
            linear-gradient(180deg,#f8fbff 0%,#f3f6ff 100%);
    }

    .hero-card{
        position:relative;
        overflow:hidden;
        border-radius:32px;
        padding:2rem;
        background:linear-gradient(135deg,#1e3a8a 0%,#4338ca 55%,#6366f1 100%);
        box-shadow:0 25px 55px rgba(37,99,235,.20);
    }

    .hero-card::before{
        content:'';
        position:absolute;
        width:280px;
        height:280px;
        background:rgba(255,255,255,.08);
        border-radius:50%;
        top:-120px;
        right:-80px;
    }

    .hero-card::after{
        content:'';
        position:absolute;
        width:180px;
        height:180px;
        background:rgba(255,255,255,.05);
        border-radius:50%;
        bottom:-70px;
        left:-50px;
    }

    .stats-card{
        background:#fff;
        border-radius:26px;
        padding:1.5rem;
        border:1px solid #eef2ff;
        box-shadow:0 12px 30px rgba(15,23,42,.05);
        transition:.25s ease;
    }

    .stats-card:hover{
        transform:translateY(-4px);
        box-shadow:0 18px 35px rgba(15,23,42,.08);
    }

    .stats-icon{
        width:64px;
        height:64px;
        border-radius:22px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:1.4rem;
    }

    .filter-card{
        background:#fff;
        border-radius:28px;
        padding:1.7rem;
        border:1px solid #eef2ff;
        box-shadow:0 12px 30px rgba(15,23,42,.05);
    }

    .filter-input,
    .filter-select{
        width:100%;
        height:54px;
        border-radius:18px;
        border:1px solid #dbe3f0;
        background:#fff;
        padding:0 1rem;
        font-size:.92rem;
        color:#334155;
        transition:.2s;
    }

    .filter-input:focus,
    .filter-select:focus{
        outline:none;
        border-color:#4f46e5;
        box-shadow:0 0 0 4px rgba(79,70,229,.10);
    }

    .lowongan-card{
        position:relative;
        background:#fff;
        border-radius:30px;
        padding:1.6rem;
        border:1px solid #edf2ff;
        box-shadow:0 12px 35px rgba(15,23,42,.05);
        transition:.25s ease;
        overflow:hidden;
    }

    .lowongan-card:hover{
        transform:translateY(-5px);
        box-shadow:0 25px 45px rgba(15,23,42,.10);
    }

    .lowongan-card::before{
        content:'';
        position:absolute;
        inset:0;
        background:linear-gradient(135deg,rgba(99,102,241,.03),transparent);
        pointer-events:none;
    }

    .logo-wrapper{
        width:78px;
        height:78px;
        border-radius:24px;
        overflow:hidden;
        border:1px solid #e2e8f0;
        background:#fff;
        flex-shrink:0;
    }

    .logo-wrapper img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .status-badge{
        display:inline-flex;
        align-items:center;
        gap:.45rem;
        padding:.5rem 1rem;
        border-radius:999px;
        font-size:.75rem;
        font-weight:800;
        letter-spacing:.3px;
    }

    .detail-box{
        border-radius:20px;
        background:#f8faff;
        border:1px solid #eef2ff;
        padding:1rem;
    }

    .detail-label{
        font-size:.72rem;
        font-weight:800;
        color:#94a3b8;
        text-transform:uppercase;
        letter-spacing:.6px;
    }

    .detail-value{
        margin-top:.35rem;
        font-size:.95rem;
        font-weight:700;
        color:#334155;
    }

    .btn-action{
        height:46px;
        border-radius:16px;
        padding:0 1rem;
        font-size:.88rem;
        font-weight:700;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        transition:.2s;
    }

    .btn-primary{
        background:linear-gradient(135deg,#2563eb,#4f46e5);
        color:#fff;
        box-shadow:0 10px 20px rgba(79,70,229,.20);
    }

    .btn-primary:hover{
        opacity:.92;
        transform:translateY(-1px);
    }

    .btn-success{
        background:#16a34a;
        color:#fff;
    }

    .btn-success:hover{
        background:#15803d;
    }

    .btn-danger{
        background:#fee2e2;
        color:#dc2626;
    }

    .btn-danger:hover{
        background:#dc2626;
        color:#fff;
    }

    .btn-soft{
        background:#eef2ff;
        color:#4f46e5;
    }

    .btn-soft:hover{
        background:#4f46e5;
        color:#fff;
    }

    .empty-card{
        background:#fff;
        border-radius:32px;
        border:1px solid #eef2ff;
        padding:5rem 2rem;
        box-shadow:0 10px 25px rgba(15,23,42,.05);
    }
</style>
@endpush

@section('content')

<div class="page-bg py-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">

        {{-- HERO --}}
        <div class="hero-card">

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                <div class="max-w-2xl">

                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 text-sm font-semibold text-blue-100 backdrop-blur">
                        <i class="fas fa-shield-check"></i>
                        Lowongan Magang 
                    </div>

                    <h1 class="mt-5 text-3xl lg:text-4xl font-extrabold text-white leading-tight">
                        Ajukan Peserta Magang ke Lowongan yang Tersedia
                    </h1>

                    <p class="mt-3 text-blue-100 leading-relaxed">
                        Pilih lowongan magang dari perusahaan mitra dan ajukan peserta magang
                        secara mudah, terstruktur, dan transparan melalui sistem.
                    </p>

                </div>

                <div class="bg-white/10 backdrop-blur rounded-2xl p-5 min-w-[150px]">
                    <p class="text-center text-sm text-blue-100">
                        Total Lowongan
                    </p>

                    <h2 class="text-center mt-2 text-3xl font-extrabold text-white">
                        {{ $totalLowongan }}
                    </h2>
                </div>

            </div>

        </div>

        {{-- FILTER --}}
        <div class="filter-card">

            <form method="GET">

                <div class="flex flex-wrap xl:flex-nowrap items-center gap-4">

                    {{-- SEARCH --}}
                    <div class="w-full xl:flex-1">

                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari lowongan atau perusahaan..."
                            class="filter-input">

                    </div>

                    {{-- PERUSAHAAN --}}
                    <div class="w-full sm:w-[220px]">

                        <select name="perusahaan"
                                class="filter-select">

                            <option value="">
                                Semua Perusahaan
                            </option>

                            @foreach($perusahaans as $perusahaan)

                                <option value="{{ $perusahaan->id }}"
                                    {{ request('perusahaan') == $perusahaan->id ? 'selected' : '' }}>

                                    {{ $perusahaan->nama_industri }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- DIVISI --}}
                    <div class="w-full sm:w-[200px]">

                        <select name="divisi"
                                class="filter-select">

                            <option value="">
                                Semua Divisi
                            </option>

                            @foreach($divisis as $divisi)

                                <option value="{{ $divisi }}"
                                    {{ request('divisi') == $divisi ? 'selected' : '' }}>

                                    {{ $divisi }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- BUTTON FILTER --}}
                    <div class="flex items-center gap-3 w-full sm:w-auto">

                        <button type="submit"
                                class="btn-action btn-primary min-w-[140px]">

                            <i class="fas fa-search mr-2"></i>
                            Filter

                        </button>

                        @if(
                            request()->filled('search') ||
                            request()->filled('status') ||
                            request()->filled('perusahaan') ||
                            request()->filled('divisi')
                        )

                            <a href="{{ route('institusi.lowongan.index') }}"
                            class="btn-action bg-slate-100 hover:bg-slate-200 text-slate-700 min-w-[120px]">

                                <i class="fas fa-rotate-left mr-2"></i>
                                Reset

                            </a>

                        @endif

                    </div>

                </div>

            </form>

        </div>

        {{-- LIST --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            @forelse($lowongans as $lowongan)

                @php
                    $logo = optional($lowongan->industri)->logo_industri
                        ? asset('storage/' . $lowongan->industri->logo_industri)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(optional($lowongan->industri)->nama_industri ?? 'Industri');

                    $status = $lowongan->status ?? 'dibuka';

                    $badgeClass = match($status){
                        'dibuka' => 'bg-green-100 text-green-700',
                        'ditutup' => 'bg-red-100 text-red-700',
                        default => 'bg-yellow-100 text-yellow-700'
                    };

                    $badgeIcon = match($status){
                        'dibuka' => 'fa-check-circle',
                        'ditutup' => 'fa-times-circle',
                        default => 'fa-clock'
                    };
                @endphp

                <div class="lowongan-card">

                    {{-- HEADER --}}
                    <div class="flex items-start gap-4">

                        <div class="logo-wrapper">
                            <img src="{{ asset('storage/vendor/logo_komdigi.jpeg') }}" alt="Logo Industri">
                        </div>

                        <div class="flex-1 min-w-0">

                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                                <div class="min-w-0">

                                    <h2 class="text-xl font-extrabold text-slate-800 line-clamp-2">
                                        {{ $lowongan->judul_lowongan ?? '-' }}
                                    </h2>

                                    <p class="mt-2 text-sm text-slate-500 font-medium">
                                        <i class="fas fa-building mr-1"></i>
                                        BBLSDM Komdigi Makassar
                                    </p>

                                </div>

                                <span class="status-badge {{ $badgeClass }}">
                                    <i class="fas {{ $badgeIcon }}"></i>
                                    {{ $lowongan->status }}
                                </span>

                            </div>

                        </div>

                    </div>

                    {{-- DETAIL --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">

                        <div class="detail-box">
                            <p class="detail-label">
                                Posisi
                            </p>

                            <p class="detail-value">
                                {{ $lowongan->posisi_magang ?? '-' }}
                            </p>
                        </div>

                        <div class="detail-box">
                            <p class="detail-label">
                                Divisi
                            </p>

                            <p class="detail-value">
                                {{ $lowongan->divisi ?? '-' }}
                            </p>
                        </div>

                        <div class="detail-box">
                            <p class="detail-label">
                                Kuota Peserta
                            </p>

                            <p class="detail-value">
                                {{ $lowongan->kuota_peserta ?? 0 }} Peserta
                            </p>
                        </div>

                        {{-- <div class="detail-box">
                            <p class="detail-label">
                                Durasi Magang
                            </p>

                            <p class="detail-value">
                                {{ $lowongan->durasi_magang ?? '-' }}
                            </p>
                        </div> --}}

                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mt-6">

                        <h3 class="text-sm font-bold text-slate-700 mb-3">
                            Deskripsi Pekerjaan
                        </h3>

                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">

                            <p class="text-sm leading-relaxed text-slate-500 line-clamp-4">
                                {{ $lowongan->deskripsi_pekerjaan ?? '-' }}
                            </p>

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="mt-6 flex flex-wrap items-center gap-3">

                        {{-- DETAIL --}}
                        <a href="{{ route('institusi.lowongan.show', $lowongan->id) }}"
                        class="btn-action btn-soft">

                            <i class="fas fa-eye mr-2"></i>
                            Detail

                        </a>

                        @if ($lowongan->status === 'dibuka') 
                            <a href="{{ route('institusi.pengajuan.create', $lowongan->id) }}"
                                class="btn-action bg-green-100 hover:bg-green-200 text-green-700 min-w-[180px]">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Ajukan Permohonan Magang
                            </a>
                        @endif
                        
                    </div>

                </div>

            @empty

                <div class="col-span-full">

                    <div class="empty-card text-center">

                        <div class="w-28 h-28 mx-auto rounded-full bg-slate-100 flex items-center justify-center">

                            <i class="fas fa-briefcase text-5xl text-slate-300"></i>

                        </div>

                        <h3 class="mt-7 text-2xl font-extrabold text-slate-700">
                            Tidak Ada Lowongan
                        </h3>

                        <p class="mt-3 text-slate-500 max-w-lg mx-auto leading-relaxed">
                            Saat ini belum ada data lowongan yang sesuai dengan filter
                            atau belum ada pengajuan lowongan magang.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}
        @if($lowongans->hasPages())

            <div class="pt-2">
                {{ $lowongans->links() }}
            </div>

        @endif

    </div>

</div>

@endsection