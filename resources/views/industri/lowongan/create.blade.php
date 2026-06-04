@extends('layouts.app')

@section('title', 'Tambah Lowongan Magang')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

    *{
        font-family:'Plus Jakarta Sans',sans-serif;
    }

    body{
        background:
            radial-gradient(circle at top right, rgba(99,102,241,.10), transparent 25%),
            linear-gradient(135deg,#eff6ff 0%,#f8fafc 45%,#eef2ff 100%);
    }

    .page-wrapper{
        min-height:100vh;
    }

    .hero-card{
        position:relative;
        overflow:hidden;
        border-radius:32px;
        background:linear-gradient(135deg,#1e3a8a 0%,#4338ca 55%,#6366f1 100%);
        box-shadow:0 20px 50px rgba(30,58,138,.18);
    }

    .hero-card::before{
        content:'';
        position:absolute;
        width:300px;
        height:300px;
        border-radius:999px;
        background:rgba(255,255,255,.06);
        top:-120px;
        right:-80px;
    }

    .hero-card::after{
        content:'';
        position:absolute;
        width:340px;
        height:340px;
        border-radius:999px;
        background:rgba(255,255,255,.04);
        bottom:-180px;
        left:-100px;
    }

    .main-card{
        background:rgba(255,255,255,.92);
        backdrop-filter:blur(18px);
        border-radius:32px;
        border:1px solid rgba(255,255,255,.7);
        box-shadow:
            0 10px 40px rgba(15,23,42,.06),
            0 2px 8px rgba(15,23,42,.04);
        overflow:hidden;
    }

    .section-card{
        padding:2rem;
    }

    .section-divider{
        border-top:1px solid #eef2ff;
    }

    .section-icon{
        width:58px;
        height:58px;
        border-radius:20px;
        background:linear-gradient(135deg,#dbeafe,#e0e7ff);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#4338ca;
        font-size:22px;
        flex-shrink:0;
    }

    .section-title{
        font-size:1.2rem;
        font-weight:800;
        color:#0f172a;
    }

    .section-subtitle{
        font-size:.92rem;
        color:#64748b;
        margin-top:4px;
        line-height:1.6;
    }

    .form-label{
        display:block;
        font-size:.92rem;
        font-weight:700;
        color:#334155;
        margin-bottom:.6rem;
    }

    .form-input{
        width:100%;
        border-radius:18px;
        border:1px solid #dbe4f0;
        background:#fff;
        padding:0.95rem 1rem;
        transition:all .2s ease;
        font-size:15px;
        color:#0f172a;
        box-shadow:0 1px 2px rgba(15,23,42,.03);
    }

    .form-input:focus{
        outline:none;
        border-color:#6366f1;
        box-shadow:
            0 0 0 4px rgba(99,102,241,.10),
            0 4px 20px rgba(99,102,241,.08);
    }

    textarea.form-input{
        min-height:130px;
        resize:none;
    }

    .submit-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:12px;
        background:linear-gradient(135deg,#2563eb,#4f46e5);
        color:#fff;
        padding:1rem 2rem;
        border-radius:18px;
        font-weight:700;
        transition:.25s ease;
        box-shadow:0 12px 24px rgba(79,70,229,.18);
        border:none;
    }

    .submit-btn:hover{
        transform:translateY(-2px);
        box-shadow:0 16px 30px rgba(79,70,229,.22);
    }

    .back-btn{
        display:inline-flex;
        align-items:center;
        gap:10px;
        color:#475569;
        font-weight:600;
        transition:.2s;
    }

    .back-btn:hover{
        color:#1e293b;
    }

    .error-box{
        border-radius:20px;
        background:#fef2f2;
        border:1px solid #fecaca;
        color:#b91c1c;
        padding:1rem 1.2rem;
    }

    .success-box{
        border-radius:20px;
        background:#ecfdf5;
        border:1px solid #86efac;
        color:#15803d;
        padding:1rem 1.2rem;
    }

    .floating-badge{
        display:inline-flex;
        align-items:center;
        gap:8px;
        background:rgba(255,255,255,.12);
        border:1px solid rgba(255,255,255,.12);
        backdrop-filter:blur(10px);
        color:#dbeafe;
        padding:.55rem 1rem;
        border-radius:999px;
        font-size:.78rem;
        font-weight:700;
        letter-spacing:.08em;
        text-transform:uppercase;
    }

    .tips-card{
        background:#fff;
        border-radius:28px;
        border:1px solid #eef2ff;
        padding:1.5rem;
        box-shadow:0 4px 20px rgba(15,23,42,.04);
    }

    .tips-item{
        display:flex;
        gap:14px;
        align-items:flex-start;
    }

    .tips-item:not(:last-child){
        padding-bottom:18px;
        margin-bottom:18px;
        border-bottom:1px solid #f1f5f9;
    }

    .tips-icon{
        width:42px;
        height:42px;
        border-radius:14px;
        background:#eef2ff;
        color:#4f46e5;
        display:flex;
        align-items:center;
        justify-content:center;
        flex-shrink:0;
    }
</style>
@endpush

@section('content')

<div class="page-wrapper py-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ALERT --}}
        @if(session('success'))
            <div class="success-box mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-box mb-6">
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- HERO --}}
        <div class="hero-card p-8 lg:p-10 mb-8">

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                <div class="flex items-start gap-5">

                    <div class="w-20 h-20 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/10 flex items-center justify-center shadow-lg">
                        <i class="fas fa-briefcase text-white text-3xl"></i>
                    </div>

                    <div>

                        <div class="floating-badge mb-4">
                            <i class="fas fa-plus-circle"></i>
                            Lowongan Magang
                        </div>

                        <h1 class="text-3xl lg:text-4xl font-extrabold text-white leading-tight">
                            Tambah Lowongan Magang
                        </h1>

                        <p class="text-blue-100 mt-4 leading-relaxed max-w-2xl">
                            Buat lowongan magang baru untuk menjaring peserta terbaik
                            sesuai kebutuhan perusahaan Anda.
                        </p>

                    </div>

                </div>

                <div class="bg-white/10 border border-white/10 backdrop-blur-xl rounded-3xl p-6 min-w-[280px]">

                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center">
                            <i class="fas fa-lightbulb text-white"></i>
                        </div>

                        <div>
                            <h4 class="text-white font-bold">
                                Tips Lowongan
                            </h4>

                            <p class="text-blue-100 text-sm">
                                Buat deskripsi yang jelas.
                            </p>
                        </div>
                    </div>

                    <p class="text-sm text-blue-100 leading-relaxed">
                        Lowongan dengan informasi lengkap lebih menarik
                        dan meningkatkan jumlah pendaftar.
                    </p>

                </div>

            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            {{-- FORM --}}
            <div class="lg:col-span-3">

                <div class="main-card">

                    <form method="POST"
                          action="{{ route('industri.lowongan.store') }}">

                        @csrf

                        {{-- INFORMASI LOWONGAN --}}
                        <div class="section-card">

                            <div class="flex items-start gap-4 mb-8">

                                <div class="section-icon">
                                    <i class="fas fa-briefcase"></i>
                                </div>

                                <div>
                                    <h2 class="section-title">
                                        Informasi Lowongan
                                    </h2>

                                    <p class="section-subtitle">
                                        Informasi dasar mengenai lowongan magang.
                                    </p>
                                </div>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div class="md:col-span-2">
                                    <label class="form-label">
                                        Judul Lowongan
                                    </label>

                                    <input type="text"
                                           name="judul_lowongan"
                                           value="{{ old('judul_lowongan') }}"
                                           placeholder="Contoh: Lowongan Magang UI/UX Designer"
                                           class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">
                                        Posisi Magang
                                    </label>

                                    <input type="text"
                                           name="posisi_magang"
                                           value="{{ old('posisi_magang') }}"
                                           placeholder="Contoh: Frontend Developer"
                                           class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">
                                        Divisi
                                    </label>

                                    <input type="text"
                                           name="divisi"
                                           value="{{ old('divisi') }}"
                                           placeholder="Contoh: IT Development"
                                           class="form-input">
                                </div>

                            </div>

                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="bg-gray-50 section-card section-divider">

                            <div class="flex items-start gap-4 mb-8">

                                <div class="section-icon">
                                    <i class="fas fa-align-left"></i>
                                </div>

                                <div>
                                    <h2 class="section-title">
                                        Detail Pekerjaan
                                    </h2>

                                    <p class="section-subtitle">
                                        Jelaskan tugas dan kebutuhan peserta magang.
                                    </p>
                                </div>

                            </div>

                            <div class="space-y-5">

                                <div>
                                    <label class="form-label">
                                        Deskripsi Pekerjaan
                                    </label>

                                    <textarea name="deskripsi_pekerjaan"
                                              placeholder="Jelaskan tugas dan tanggung jawab peserta magang..."
                                              class="form-input">{{ old('deskripsi_pekerjaan') }}</textarea>
                                </div>

                                <div>
                                    <label class="form-label">
                                        Requirements
                                    </label>

                                    <textarea name="requirements"
                                              placeholder="Tuliskan syarat atau kualifikasi peserta..."
                                              class="form-input">{{ old('requirements') }}</textarea>
                                </div>

                            </div>

                        </div>

                        {{-- INFORMASI MAGANG --}}
                        <div class="section-card section-divider">

                            <div class="flex items-start gap-4 mb-8">

                                <div class="section-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>

                                <div>
                                    <h2 class="section-title">
                                        Informasi Magang
                                    </h2>

                                    <p class="section-subtitle">
                                        Tentukan kuota, durasi, dan status lowongan.
                                    </p>
                                </div>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                                <div>
                                    <label class="form-label">
                                        Kuota Peserta
                                    </label>

                                    <input type="number"
                                           name="kuota_peserta"
                                           value="{{ old('kuota_peserta') }}"
                                           placeholder="0"
                                           class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">
                                        Durasi Magang
                                    </label>

                                    <input type="text"
                                           name="durasi_magang"
                                           value="{{ old('durasi_magang') }}"
                                           placeholder="Contoh: 3 Bulan"
                                           class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">
                                        Status
                                    </label>

                                    <select name="status"
                                            class="form-input">

                                        <option value="aktif"
                                            {{ old('status') == 'aktif' ? 'selected' : '' }}>
                                            Aktif
                                        </option>

                                        <option value="nonaktif"
                                            {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                            Nonaktif
                                        </option>

                                    </select>
                                </div>

                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex flex-col-reverse md:flex-row md:items-center md:justify-between gap-4">

                            <a href="{{ route('industri.lowongan.index') }}"
                               class="back-btn">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>

                            <button type="submit"
                                    class="submit-btn">
                                <i class="fas fa-save"></i>
                                Simpan Lowongan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-6">

                <div class="tips-card sticky top-6">

                    <h3 class="text-lg font-bold text-slate-800 mb-5">
                        Tips Membuat Lowongan
                    </h3>

                    <div>

                        <div class="tips-item">

                            <div class="tips-icon">
                                <i class="fas fa-pen"></i>
                            </div>

                            <div>
                                <h4 class="font-semibold text-slate-800 mb-1">
                                    Judul yang Jelas
                                </h4>

                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Gunakan judul lowongan yang mudah dipahami peserta.
                                </p>
                            </div>

                        </div>

                        <div class="tips-item">

                            <div class="tips-icon">
                                <i class="fas fa-users"></i>
                            </div>

                            <div>
                                <h4 class="font-semibold text-slate-800 mb-1">
                                    Jelaskan Kebutuhan
                                </h4>

                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Tuliskan requirement dengan detail agar seleksi lebih tepat.
                                </p>
                            </div>

                        </div>

                        <div class="tips-item">

                            <div class="tips-icon">
                                <i class="fas fa-bolt"></i>
                            </div>

                            <div>
                                <h4 class="font-semibold text-slate-800 mb-1">
                                    Aktifkan Lowongan
                                </h4>

                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Pastikan status lowongan aktif agar dapat dilihat peserta.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection