@extends('layouts.app')

@section('title', 'Detail Verifikasi Lowongan')

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

        /* ── Panel ── */
        .panel {
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(30,58,138,0.06), 0 4px 20px rgba(30,58,138,0.06);
        }

        /* ── Logo wrapper ── */
        .logo-wrapper {
            width: 80px; height: 80px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }
        .logo-wrapper img {
            width: 100%; height: 100%;
            object-fit: cover;
        }

        /* ── Status badge ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }
        .badge-green  { background: #dcfce7; color: #15803d; }
        .badge-red    { background: #fee2e2; color: #b91c1c; }
        .badge-amber  { background: #fef9c3; color: #a16207; }

        /* ── Action buttons on strip ── */
        .action-strip-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            min-width: 130px;
            background: rgba(255,255,255,0.15);
            border: 1.5px solid rgba(255,255,255,0.3);
            color: #fff;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .action-strip-btn:hover {
            background: rgba(255,255,255,0.25);
            border-color: rgba(255,255,255,0.5);
            color: #fff;
            text-decoration: none;
            transform: translateY(-1px);
        }
        .action-strip-btn.approve {
            background: rgba(34,197,94,0.25);
            border-color: rgba(134,239,172,0.4);
        }
        .action-strip-btn.approve:hover {
            background: rgba(34,197,94,0.4);
        }
        .action-strip-btn.reject {
            background: rgba(239,68,68,0.25);
            border-color: rgba(252,165,165,0.4);
        }
        .action-strip-btn.reject:hover {
            background: rgba(239,68,68,0.4);
        }
        .action-strip-btn.delete-btn {
            background: rgba(239,68,68,0.18);
            border-color: rgba(252,165,165,0.35);
        }
        .action-strip-btn.delete-btn:hover {
            background: rgba(239,68,68,0.35);
        }

        /* ── Info item ── */
        .info-item {
            padding: 14px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-item:last-child { border-bottom: none; }
        .info-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }

        /* ── Detail box (grid items) ── */
        .detail-box {
            background: #f8fafc;
            border: 1px solid #e9eef6;
            border-radius: 12px;
            padding: 1rem;
        }
        .detail-label {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: .35rem;
        }
        .detail-value {
            font-size: .9rem;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.5;
            word-break: break-word;
        }

        /* ── Description box ── */
        .description-box {
            background: #f8fafc;
            border: 1px solid #e9eef6;
            border-radius: 12px;
            padding: 1.25rem;
        }

        /* ── Section header ── */
        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }
        .section-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            color: white;
            flex-shrink: 0;
        }
        .section-icon.blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .section-icon.indigo { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .section-icon.green  { background: linear-gradient(135deg, #22c55e, #16a34a); }
        .section-icon.violet { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .section-icon.amber  { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .section-icon.rose   { background: linear-gradient(135deg, #f43f5e, #e11d48); }

        .section-header-text h3 {
            font-size: 14px;
            font-weight: 700;
            color: #1e3a8a;
            margin: 0;
        }
        .section-header-text p {
            font-size: 11px;
            color: #94a3b8;
            margin: 0;
        }

        /* ── Back btn ── */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 12px;
            background: #f0f4ff;
            border: 1.5px solid #e0e7ff;
            color: #3b4fd8;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-back:hover {
            background: #e8eeff;
            border-color: #a5b4fc;
            transform: translateY(-1px);
            color: #3b4fd8;
            text-decoration: none;
        }

        /* ── Animations ── */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-1 { animation: fadeSlideUp 0.5s ease both; }
        .anim-2 { animation: fadeSlideUp 0.5s ease 0.1s both; }
        .anim-3 { animation: fadeSlideUp 0.5s ease 0.2s both; }
        .anim-4 { animation: fadeSlideUp 0.5s ease 0.3s both; }

        @media (max-width: 640px) {
            .panel { padding: 16px; }
        }
    </style>
@endpush

@section('content')
    @php
        $logo = optional($lowongan->industri)->logo_industri
            ? asset('storage/' . $lowongan->industri->logo_industri)
            : 'https://ui-avatars.com/api/?name=' .
                urlencode(optional($lowongan->industri)->nama_industri ?? 'Industri') .
                '&background=4f46e5&color=fff';

        $status = $lowongan->status_verifikasi ?? 'pending';

        $badgeClass = match ($status) {
            'disetujui' => 'badge-green',
            'ditolak'   => 'badge-red',
            default     => 'badge-amber',
        };

        $badgeIcon = match ($status) {
            'disetujui' => 'fa-check-circle',
            'ditolak'   => 'fa-times-circle',
            default     => 'fa-clock',
        };

        $canEdit = auth()->user()->industri
            ? $lowongan->industri_id === auth()->user()->industri->id
            : $lowongan->industri_id === null;
    @endphp

    <div class="dash-bg py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- ── PROFILE STRIP ── --}}
            <div class="profile-strip anim-1">
                <div class="px-6 py-7 flex flex-col sm:flex-row items-center sm:items-start gap-5 relative z-10">

                    {{-- Logo Industri ── --}}
                    <div style="background:linear-gradient(135deg,#60a5fa,#818cf8);padding:3px;border-radius:9999px;display:inline-flex;flex-shrink:0;">
                        <img src="{{ $logo }}"
                             alt="{{ optional($lowongan->industri)->nama_industri ?? 'Industri' }}"
                             style="width:80px;height:80px;border-radius:9999px;object-fit:cover;">
                    </div>

                    {{-- Identity ── --}}
                    <div class="flex-1 text-center sm:text-left">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                            <h1 class="text-xl font-bold text-white">{{ $lowongan->judul_lowongan ?? '-' }}</h1>
                            <span class="badge {{ $badgeClass }}">
                                <i class="fas {{ $badgeIcon }} text-xs"></i>
                                {{ ucfirst($status) }}
                            </span>
                        </div>
                        <p class="text-blue-200 font-semibold text-sm">
                            {{ optional($lowongan->industri)->nama_industri ?? '-' }}
                        </p>
                        <p class="text-blue-300 text-xs mt-1">
                            <i class="fas fa-briefcase mr-1"></i>{{ $lowongan->posisi_magang ?? '-' }}
                            @if($lowongan->divisi)
                                &nbsp;·&nbsp;
                                <i class="fas fa-layer-group mr-1"></i>{{ $lowongan->divisi }}
                            @endif
                            &nbsp;·&nbsp;
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Dibuat {{ optional($lowongan->created_at)->locale('id')->translatedFormat('d F Y') ?? '-' }}
                        </p>
                    </div>

                    {{-- Actions ── --}}
                   <div class="flex flex-wrap sm:flex-col gap-2 items-center sm:items-stretch justify-center sm:justify-center flex-shrink-0 sm:self-center" style="min-width:140px;">
                        @if ($status !== 'disetujui')
                            <form action="{{ route('admin.lowongan.approve', $lowongan->id) }}" method="POST" style="display:contents;">
                                @csrf @method('PATCH')
                                <button type="submit" onclick="return confirm('Setujui lowongan ini?')"
                                    class="action-strip-btn approve" style="width:100%;justify-content:center;">
                                    <i class="fas fa-check text-xs"></i> Setujui
                                </button>
                            </form>
                        @endif
                        @if ($canEdit)
                            <a href="{{ route('admin.lowongan.edit', $lowongan->id) }}"
                               class="action-strip-btn" style="justify-content:center;">
                                <i class="fas fa-edit text-xs"></i> Edit
                            </a>
                        @endif
                        @if ($status !== 'ditolak')
                            <button type="button"
                                class="action-strip-btn reject" style="justify-content:center;"
                                onclick="window.dispatchEvent(new CustomEvent('open-reject-modal', { detail: { url: '{{ route('admin.lowongan.reject', $lowongan->id) }}', title: '{{ addslashes($lowongan->judul_lowongan) }}' } }))">
                                <i class="fas fa-times text-xs"></i> Tolak
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── INFORMASI LOWONGAN ── --}}
            <div class="panel anim-2">
                <div class="section-header">
                    <div class="section-icon indigo"><i class="fas fa-briefcase"></i></div>
                    <div class="section-header-text">
                        <h3>Informasi Lowongan</h3>
                        <p>Detail informasi lowongan magang.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="detail-box">
                        <p class="detail-label">Judul Lowongan</p>
                        <p class="detail-value">{{ $lowongan->judul_lowongan ?? '-' }}</p>
                    </div>
                    <div class="detail-box">
                        <p class="detail-label">Posisi Magang</p>
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
                        <p class="detail-label">Durasi Magang</p>
                        <p class="detail-value">{{ $lowongan->durasi_magang ?? '-' }}</p>
                    </div>
                    <div class="detail-box">
                        <p class="detail-label">Status Lowongan</p>
                        <p class="detail-value">{{ ucfirst($lowongan->status ?? '-') }}</p>
                    </div>
                    <div class="detail-box">
                        <p class="detail-label">Status Verifikasi</p>
                        <p class="detail-value">{{ ucfirst($lowongan->status_verifikasi ?? '-') }}</p>
                    </div>
                    <div class="detail-box">
                        <p class="detail-label">Tanggal Dibuat</p>
                        <p class="detail-value">
                            {{ optional($lowongan->created_at)->locale('id')->translatedFormat('d F Y, H:i') ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- ── FASILITAS ── --}}
            <div class="panel anim-3">
                <div class="section-header">
                    <div class="section-icon green"><i class="fas fa-gift"></i></div>
                    <div class="section-header-text">
                        <h3>Fasilitas</h3>
                        <p>Benefit yang akan didapatkan peserta magang.</p>
                    </div>
                </div>
                <div class="description-box">
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $lowongan->fasilitas ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- ── DESKRIPSI PEKERJAAN ── --}}
            <div class="panel anim-3">
                <div class="section-header">
                    <div class="section-icon blue"><i class="fas fa-file-alt"></i></div>
                    <div class="section-header-text">
                        <h3>Deskripsi Pekerjaan</h3>
                        <p>Penjelasan pekerjaan dan aktivitas magang.</p>
                    </div>
                </div>
                <div class="description-box">
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $lowongan->deskripsi_pekerjaan ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- ── REQUIREMENTS ── --}}
            <div class="panel anim-3">
                <div class="section-header">
                    <div class="section-icon amber"><i class="fas fa-list-check"></i></div>
                    <div class="section-header-text">
                        <h3>Requirements / Persyaratan</h3>
                        <p>Persyaratan peserta magang.</p>
                    </div>
                </div>
                <div class="description-box">
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $lowongan->requirements ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- ── INFORMASI INDUSTRI ── --}}
            <div class="panel anim-3">
                <div class="section-header">
                    <div class="section-icon green"><i class="fas fa-building"></i></div>
                    <div class="section-header-text">
                        <h3>Informasi Industri</h3>
                        <p>Informasi perusahaan pengaju lowongan.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="detail-box">
                        <p class="detail-label">Nama Industri</p>
                        <p class="detail-value">{{ optional($lowongan->industri)->nama_industri ?? '-' }}</p>
                    </div>
                    <div class="detail-box">
                        <p class="detail-label">Bidang Industri</p>
                        <p class="detail-value">{{ optional($lowongan->industri)->bidang_industri ?? '-' }}</p>
                    </div>
                    <div class="detail-box">
                        <p class="detail-label">Kota / Kabupaten</p>
                        <p class="detail-value">{{ optional($lowongan->industri)->kota_kabupaten ?? '-' }}</p>
                    </div>
                    <div class="detail-box">
                        <p class="detail-label">Email Industri</p>
                        <p class="detail-value break-all">{{ optional($lowongan->industri)->email_industri ?? '-' }}</p>
                    </div>
                    <div class="detail-box">
                        <p class="detail-label">Nomor Telepon</p>
                        <p class="detail-value">{{ optional($lowongan->industri)->nomor_telepon_industri ?? '-' }}</p>
                    </div>
                    <div class="detail-box">
                        <p class="detail-label">NIB</p>
                        <p class="detail-value">{{ optional($lowongan->industri)->nib ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- ── ALAMAT INDUSTRI ── --}}
            <div class="panel anim-3">
                <div class="section-header">
                    <div class="section-icon rose"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="section-header-text">
                        <h3>Alamat Industri</h3>
                        <p>Lokasi lengkap perusahaan.</p>
                    </div>
                </div>
                <div class="description-box">
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ optional($lowongan->industri)->alamat_industri ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- ── DESKRIPSI INDUSTRI ── --}}
            <div class="panel anim-3">
                <div class="section-header">
                    <div class="section-icon violet"><i class="fas fa-circle-info"></i></div>
                    <div class="section-header-text">
                        <h3>Deskripsi Industri</h3>
                        <p>Gambaran umum perusahaan.</p>
                    </div>
                </div>
                <div class="description-box">
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ optional($lowongan->industri)->deskripsi_industri ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- ── FOOTER BACK ── --}}
            <div class="anim-4" style="padding-bottom:8px;">
                <a href="{{ route('admin.lowongan.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Kembali ke Daftar Lowongan
                </a>
            </div>

        </div>
    </div>


    {{-- ── MODAL TOLAK ── --}}
    <div x-data="{ showRejectModal: false, rejectUrl: '', jobTitle: '' }"
         @open-reject-modal.window="showRejectModal = true; rejectUrl = $event.detail.url; jobTitle = $event.detail.title">
        <div x-show="showRejectModal" style="display:none;"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900 bg-opacity-50 backdrop-blur-sm"
             x-transition.opacity>
            <div @click.away="showRejectModal = false"
                 class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all"
                 x-show="showRejectModal" x-transition.scale.origin.bottom>
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-orange-100 rounded-full mb-4">
                    <i class="fas fa-times-circle text-orange-500 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-center text-gray-900 mb-2">Konfirmasi Tolak</h3>
                <p class="text-center text-gray-600 mb-6">
                    Apakah Anda yakin ingin menolak lowongan
                    <strong x-text="jobTitle"></strong>?
                    Lowongan ini tidak akan tampil untuk pelamar.
                </p>
                <div class="flex justify-center gap-3">
                    <button type="button" @click="showRejectModal = false"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        Batal
                    </button>
                    <form :action="rejectUrl" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-xl transition-colors flex items-center gap-2">
                            <i class="fas fa-times"></i> Ya, Tolak
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection