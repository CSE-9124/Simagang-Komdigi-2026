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

    /* ── Lowongan Card ── */
    .lowongan-card{
        position:relative;
        background:#fff;
        border-radius:30px;
        padding:1.6rem;
        border:1px solid #edf2ff;
        box-shadow:0 12px 35px rgba(15,23,42,.05);
        transition:.25s ease;
        overflow:hidden;
        display:flex;
        flex-direction:column;
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

    /* Card grows so footer always sticks to bottom */
    .lowongan-card .card-body {
        flex: 1;
    }

    .logo-wrapper{
        width:72px;
        height:72px;
        border-radius:20px;
        overflow:hidden;
        border:1px solid #e2e8f0;
        background:#f8faff;
        flex-shrink:0;
    }

    .logo-wrapper img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    /* ── Status Badge (selaras dengan detail page) ── */
    .status-badge{
        display:inline-flex;
        align-items:center;
        gap:.4rem;
        padding:.35rem .9rem;
        border-radius:999px;
        font-size:.72rem;
        font-weight:800;
        letter-spacing:.3px;
        white-space:nowrap;
    }

    .badge-green  { background:#dcfce7; color:#15803d; }
    .badge-red    { background:#fee2e2; color:#b91c1c; }
    .badge-amber  { background:#fef9c3; color:#a16207; }

    /* ── Detail boxes ── */
    .detail-box{
        border-radius:16px;
        background:#f8faff;
        border:1px solid #eef2ff;
        padding:.85rem 1rem;
    }

    .detail-label{
        font-size:.68rem;
        font-weight:800;
        color:#94a3b8;
        text-transform:uppercase;
        letter-spacing:.6px;
    }

    .detail-value{
        margin-top:.3rem;
        font-size:.88rem;
        font-weight:700;
        color:#334155;
        line-height:1.4;
    }

    /* ── Divider ── */
    .card-divider {
        height:1px;
        background: linear-gradient(to right, transparent, #e2e8f0, transparent);
        margin: 1.1rem 0;
    }

    /* ── Action buttons ── */
    .btn-action{
        height:42px;
        border-radius:14px;
        padding:0 1.1rem;
        font-size:.83rem;
        font-weight:700;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:.45rem;
        transition:.2s;
        text-decoration:none;
        border:none;
        cursor:pointer;
    }

    .btn-action:hover{
        transform:translateY(-1px);
        text-decoration:none;
    }

    .btn-primary{
        background:linear-gradient(135deg,#2563eb,#4f46e5);
        color:#fff;
        box-shadow:0 8px 18px rgba(79,70,229,.20);
    }

    .btn-primary:hover{ opacity:.92; color:#fff; }

    .btn-soft{
        background:#eef2ff;
        color:#4f46e5;
    }

    .btn-soft:hover{
        background:#4f46e5;
        color:#fff;
    }

    .btn-danger{
        background:#fee2e2;
        color:#dc2626;
    }

    .btn-danger:hover{
        background:#dc2626;
        color:#fff;
    }

    .empty-card{
        background:#fff;
        border-radius:32px;
        border:1px solid #eef2ff;
        padding:5rem 2rem;
        box-shadow:0 10px 25px rgba(15,23,42,.05);
    }

    /* ── Meta info row ── */
    .meta-row {
        display:flex;
        flex-wrap:wrap;
        align-items:center;
        gap:.5rem .75rem;
        margin-top:.5rem;
    }

    .meta-chip {
        display:inline-flex;
        align-items:center;
        gap:.3rem;
        font-size:.75rem;
        font-weight:600;
        color:#64748b;
    }

    .meta-chip i {
        font-size:.65rem;
        color:#94a3b8;
    }
</style>
@endpush

@section('content')

<div class="page-bg py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">

        {{-- ── HERO ── --}}
        <div class="hero-card">
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 text-sm font-semibold text-blue-100 backdrop-blur">
                        <i class="fas fa-shield-check"></i>
                        Dashboard Verifikasi
                    </div>
                    <h1 class="mt-5 text-3xl lg:text-4xl font-extrabold text-white leading-tight">
                        Manajemen Lowongan Magang
                    </h1>
                    <p class="mt-3 text-blue-100 leading-relaxed">
                        Kelola dan publikasikan berbagai lowongan magang dari setiap unit kerja,
                        divisi, atau tim. Tambahkan peluang magang baru, perbarui informasi
                        lowongan, serta pantau status publikasi secara terpusat.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.lowongan.create') }}"
                       class="inline-flex items-center justify-center bg-white text-blue-700 font-semibold px-6 py-3 rounded-2xl shadow-lg hover:bg-blue-50 transition gap-2">
                        <i class="fas fa-plus"></i>
                        Tambah Lowongan
                    </a>
                </div>
            </div>
        </div>

        {{-- ── STATS ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="stats-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Total Lowongan</p>
                        <h2 class="mt-2 text-3xl font-extrabold text-slate-800">{{ $totalLowongan }}</h2>
                    </div>
                    <div class="stats-icon bg-blue-100 text-blue-700"><i class="fas fa-briefcase"></i></div>
                </div>
            </div>
            <div class="stats-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Pending</p>
                        <h2 class="mt-2 text-3xl font-extrabold text-yellow-500">{{ $totalPending }}</h2>
                    </div>
                    <div class="stats-icon bg-yellow-100 text-yellow-700"><i class="fas fa-clock"></i></div>
                </div>
            </div>
            <div class="stats-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Disetujui</p>
                        <h2 class="mt-2 text-3xl font-extrabold text-green-600">{{ $totalApprove }}</h2>
                    </div>
                    <div class="stats-icon bg-green-100 text-green-700"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
            <div class="stats-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Ditolak</p>
                        <h2 class="mt-2 text-3xl font-extrabold text-red-600">{{ $totalTolak }}</h2>
                    </div>
                    <div class="stats-icon bg-red-100 text-red-700"><i class="fas fa-times-circle"></i></div>
                </div>
            </div>
        </div>

        {{-- ── FILTER ── --}}
        <div class="filter-card">
            <form method="GET">
                <div class="flex flex-wrap xl:flex-nowrap items-center gap-4">
                    <div class="w-full xl:flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari lowongan atau perusahaan..."
                            class="filter-input">
                    </div>
                    <div class="w-full sm:w-[220px]">
                        <select name="perusahaan" class="filter-select">
                            <option value="">Semua Perusahaan</option>
                            @foreach($perusahaans as $perusahaan)
                                <option value="{{ $perusahaan->id }}"
                                    {{ request('perusahaan') == $perusahaan->id ? 'selected' : '' }}>
                                    {{ $perusahaan->nama_industri }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-[200px]">
                        <select name="divisi" class="filter-select">
                            <option value="">Semua Divisi</option>
                            @foreach($divisis as $divisi)
                                <option value="{{ $divisi }}" {{ request('divisi') == $divisi ? 'selected' : '' }}>
                                    {{ $divisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-[180px]">
                        <select name="status" class="filter-select">
                            <option value="">Semua Status</option>
                            <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak"   {{ request('status') == 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="submit" class="btn-action btn-primary min-w-[140px]">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        @if(request()->filled('search') || request()->filled('status') || request()->filled('perusahaan') || request()->filled('divisi'))
                            <a href="{{ route('admin.lowongan.index') }}"
                               class="btn-action bg-slate-100 hover:bg-slate-200 text-slate-700 min-w-[120px]">
                                <i class="fas fa-rotate-left"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- ── CARD LIST ── --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            @forelse($lowongans as $lowongan)
                @php
                    $logo = optional($lowongan->industri)->logo_industri
                        ? asset('storage/' . $lowongan->industri->logo_industri)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(optional($lowongan->industri)->nama_industri ?? 'Industri') . '&background=4f46e5&color=fff';

                    $status    = $lowongan->status_verifikasi ?? 'pending';

                    $badgeClass = match($status){
                        'disetujui' => 'badge-green',
                        'ditolak'   => 'badge-red',
                        default     => 'badge-amber',
                    };

                    $badgeIcon = match($status){
                        'disetujui' => 'fa-check-circle',
                        'ditolak'   => 'fa-times-circle',
                        default     => 'fa-clock',
                    };
                @endphp

                <div class="lowongan-card">

                    {{-- ── Header ── --}}
                    <div class="flex items-start gap-4">
                        <div class="logo-wrapper">
                            <img src="{{ asset('storage/vendor/logo_komdigi.jpeg') }}" alt="Logo Industri">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <h2 class="text-base font-extrabold text-slate-800 leading-snug line-clamp-2 flex-1 min-w-0 pr-2">
                                    {{ $lowongan->judul_lowongan ?? '-' }}
                                </h2>
                                {{-- Status badge — selaras dengan detail page --}}
                                <span class="status-badge {{ $badgeClass }} flex-shrink-0">
                                    <i class="fas {{ $badgeIcon }}"></i>
                                    {{ ucfirst($status) }}
                                </span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-chip">
                                    <i class="fas fa-building"></i>
                                    BBLSDM Komdigi Makassar
                                </span>
                                <span class="meta-chip">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ optional($lowongan->created_at)->translatedFormat('d M Y') ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-divider"></div>

                    {{-- ── Detail Grid ── --}}
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="detail-box">
                                <p class="detail-label">Posisi</p>
                                <p class="detail-value">{{ $lowongan->posisi_magang ?? '-' }}</p>
                            </div>
                            <div class="detail-box">
                                <p class="detail-label">Divisi</p>
                                <p class="detail-value">{{ $lowongan->divisi ?? '-' }}</p>
                            </div>
                            <div class="detail-box">
                                <p class="detail-label">Kuota Peserta</p>
                                <p class="detail-value">{{ $lowongan->kuota_peserta ?? 0 }} Peserta</p>
                            </div>
                            <div class="detail-box">
                                <p class="detail-label">Durasi Magang (Bulan)</p>
                                <p class="detail-value">{{ $lowongan->durasi_magang ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- ── Deskripsi ── --}}
                        <div class="mt-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Pekerjaan</p>
                            <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                <p class="text-sm leading-relaxed text-slate-500 line-clamp-3">
                                    {{ $lowongan->deskripsi_pekerjaan ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-divider"></div>

                    {{-- ── Footer Actions ── --}}
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('admin.lowongan.show', $lowongan->id) }}" class="btn-action btn-soft">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <button type="button"
                            class="btn-action btn-danger"
                            onclick="window.dispatchEvent(new CustomEvent('open-delete-modal-lowongan', {
                                detail: {
                                    url: '{{ route('admin.lowongan.destroy', $lowongan->id) }}',
                                    title: '{{ addslashes($lowongan->judul_lowongan) }}'
                                }
                            }))">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>

                </div>

            @empty
                <div class="col-span-full">
                    <div class="empty-card text-center">
                        <div class="w-28 h-28 mx-auto rounded-full bg-slate-100 flex items-center justify-content:center;">
                            <i class="fas fa-briefcase text-5xl text-slate-300 mx-auto"></i>
                        </div>
                        <h3 class="mt-7 text-2xl font-extrabold text-slate-700">Belum Ada Lowongan Magang</h3>
                        <p class="mt-3 text-slate-500 max-w-lg mx-auto leading-relaxed">
                            Belum ditemukan lowongan magang yang sesuai dengan filter yang dipilih.
                        </p>
                    </div>
                </div>
            @endforelse

        </div>

        {{-- ── PAGINATION ── --}}
        @if($lowongans->hasPages())
            <div class="pt-2">{{ $lowongans->links() }}</div>
        @endif

    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{-- ── MODAL HAPUS (Alpine.js — selaras dengan detail page) ── --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<div x-data="{ showDeleteModal: false, deleteUrl: '', jobTitle: '' }"
     @open-delete-modal-lowongan.window="showDeleteModal = true; deleteUrl = $event.detail.url; jobTitle = $event.detail.title">

    <div x-show="showDeleteModal" style="display:none;"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900 bg-opacity-50 backdrop-blur-sm"
         x-transition.opacity>

        <div @click.away="showDeleteModal = false"
             class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all"
             x-show="showDeleteModal" x-transition.scale.origin.bottom>

            {{-- Icon --}}
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>

            {{-- Title --}}
            <h3 class="text-xl font-bold text-center text-gray-900 mb-2">Konfirmasi Hapus</h3>

            {{-- Message --}}
            <p class="text-center text-gray-600 mb-6">
                Apakah Anda yakin ingin menghapus lowongan
                <strong x-text="jobTitle"></strong>?
                Tindakan ini tidak dapat dibatalkan.
            </p>

            {{-- Buttons --}}
            <div class="flex justify-center gap-3">
                <button type="button" @click="showDeleteModal = false"
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Batal
                </button>
                <form :action="deleteUrl" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors flex items-center gap-2">
                        <i class="fas fa-trash"></i> Ya, Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection