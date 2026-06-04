@extends('layouts.app')

@section('title', 'Detail Pengajuan Magang')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        *,
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .dash-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8eeff 0%, #f0f4ff 40%, #e4ecff 100%);
        }

        .hero-strip {
            background: linear-gradient(110deg, #1e3a8a 0%, #3b4fd8 55%, #4f46e5 100%);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(20, 40, 120, 0.16);
        }

        .hero-strip::before {
            content: '';
            position: absolute;
            top: -70px;
            right: -50px;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-strip::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: 18%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
            pointer-events: none;
        }

        .panel {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(20, 40, 120, 0.06), 0 4px 18px rgba(20, 40, 120, 0.06);
            overflow: hidden;
        }

        .panel-header {
            background: linear-gradient(100deg, #1e3a8a 0%, #3b4fd8 100%);
            padding: 16px 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .panel-header h2 {
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.01em;
            margin: 0;
        }

        .panel-body {
            padding: 20px 22px;
        }

        .section-card {
            background: #f8faff;
            border: 1px solid #e8eeff;
            border-radius: 18px;
        }

        .info-card {
            background: #fff;
            border: 1px solid #e8eeff;
            border-radius: 18px;
            box-shadow: 0 1px 3px rgba(20, 40, 120, 0.05);
            overflow: hidden;
            min-width: 0; 
        }

        .soft-badge {
            background: linear-gradient(135deg, #eff6ff, #f5f3ff);
            border: 1px solid #dbeafe;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .section-card {
            background: #f8faff;
            border: 1px solid #e8eeff;
            border-radius: 18px;
            transition: all 0.3s ease;
        }

        .section-card:hover {
            border-color: #d4dff5;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.08);
        }

        .info-card {
            background: #fff;
            border: 1px solid #e8eeff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(20, 40, 120, 0.06);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            border-color: #c7d2fc;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.12);
            transform: translateY(-2px);
        }

        .field-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            display: block;
        }

        .field-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.6;
            word-break: break-word;      
            overflow-wrap: break-word;   
            white-space: normal; 
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .section-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .section-text h2 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
        }

        .section-text p {
            margin: 0.25rem 0 0 0;
            font-size: 0.75rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .panel-body {
            padding: 24px;
        }

        a[target="_blank"]::after {
            content: '';
        }

        /* Smooth transitions untuk semua elemen */
        * {
            transition: all 0.2s ease;
        }

        button, a {
            transition: all 0.3s ease;
        }

        /* Styling untuk text yang terpotong */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="dash-bg py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="hero-strip px-5 sm:px-8 py-6 sm:py-8">
                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl text-white">
                        {{-- <p class="text-xs sm:text-sm uppercase tracking-[0.3em] text-blue-100/80">Institusi Dashboard</p> --}}
                        <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold leading-tight">Detail Pengajuan Magang</h1>
                        <p class="mt-3 text-sm sm:text-base text-blue-100/90">Lihat informasi pengajuan dan daftar calon peserta magang dalam satu tampilan yang rapi, nyaman, dan mudah dipantau.</p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('institusi.pengajuan.index') }}"
                            class="inline-flex items-center justify-center rounded-2xl bg-white/10 px-5 py-3 text-sm font-semibold text-white backdrop-blur-sm border border-white/10 transition hover:bg-white/15">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <i class="fas fa-file-lines text-blue-200 text-base"></i>
                    <h2>Detail Pengajuan</h2>
                </div>

                <div class="panel-body">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Kolom Kiri -->
                        <div class="lg:col-span-2 space-y-6">
                            <div class="section-card p-5 sm:p-6">
                                <div class="section-title">
                                    <div class="section-icon bg-blue-50 text-blue-600">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div class="section-text">
                                        <p>Informasi Surat</p>
                                        <h2>Informasi Surat Pengajuan Magang</h2>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                                    <div></div>
                                    <a href="{{ route('pengajuan.surat', $pengajuan) }}" target="_blank"
                                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-blue-700 hover:shadow-lg">
                                        <i class="fas fa-download mr-2"></i>
                                        Download Surat Pengajuan
                                    </a>
                                </div>

                                <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                                    <div class="info-card p-4">
                                        <span class="field-label">Nomor Surat Pengajuan</span>
                                        <p class="field-value">{{ $pengajuan->no_surat }}</p>
                                    </div>
                                    <div class="info-card p-4">
                                        <span class="field-label">Penanggung Jawab</span>
                                        <p class="field-value">{{ $pengajuan->tujuan_surat }}</p>
                                    </div>
                                    <div class="info-card p-4">
                                        <span class="field-label">Tanggal Pengajuan</span>
                                        <p class="field-value">{{ \Carbon\Carbon::parse($pengajuan->created_at)->locale('id')->translatedFormat('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="section-card p-5 sm:p-6">
                                <div class="section-title">
                                    <div class="section-icon bg-indigo-50 text-indigo-600">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <div class="section-text">
                                        <p>Pengajuan</p>
                                        <h2>Informasi Pengajuan Magang</h2>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                                    <div class="info-card p-4">
                                        <span class="field-label">Keperluan</span>
                                        <p class="field-value">{{ $pengajuan->keperluan }}</p>
                                    </div>
                                    <div class="info-card p-4">
                                        <span class="field-label">Tanggal Masuk</span>
                                        <p class="field-value">{{ $pengajuan->start_date }}</p>
                                    </div>
                                    <div class="info-card p-4">
                                        <span class="field-label">Tanggal Keluar</span>
                                        <p class="field-value">{{ $pengajuan->end_date }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="section-card p-5 sm:p-6">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                                    <div class="section-title mb-0">
                                        <div class="section-icon bg-blue-50 text-blue-600">
                                            <i class="fas fa-circle-info"></i>
                                        </div>
                                        <div class="section-text">
                                            <p>Status</p>
                                            <h2>Status Pengajuan Magang</h2>
                                        </div>
                                    </div>

                                    @if ($pengajuan->status == 'approved')
                                        <a href="{{ route('institusi.pengajuan.surat-balasan', $pengajuan) }}" target="_blank"
                                            class="inline-flex items-center justify-center rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-green-700 hover:shadow-lg whitespace-nowrap">
                                            <i class="fas fa-download mr-2"></i>
                                            Download Surat Balasan
                                        </a>
                                    @endif
                                </div>

                                <div class="info-card p-4">
                                    <span class="field-label mb-3">Status Pengajuan</span>
                                    @php
                                        $statusClass = match ($pengajuan->status) {
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'revised' => 'bg-orange-100 text-orange-800',
                                            default => 'bg-yellow-100 text-yellow-800',
                                        };
                                    @endphp
                                    <span class="status-pill {{ $statusClass }}">{{ ucfirst($pengajuan->status) }}</span>

                                    @if ($pengajuan->status == 'revised' && $pengajuan->admin_note)
                                        <div class="mt-4 rounded-xl border border-orange-200 bg-orange-50 p-4">
                                            <h4 class="text-sm font-semibold text-orange-800 mb-2">📝 Catatan Revisi</h4>
                                            <p class="text-sm text-orange-700 whitespace-pre-wrap">{{ $pengajuan->admin_note }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="lg:col-span-1">
                            @if ($pengajuan->lowongan)
                            <div class="section-card p-5 sm:p-6 sticky top-6 border-l-4 border-l-purple-500">
                                <div class="section-title">
                                    <div class="section-icon bg-purple-50 text-purple-600">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div class="section-text">
                                        <p>Lowongan Terkait</p>
                                        <h2>Informasi Lowongan</h2>
                                    </div>
                                </div>

                                <div class="space-y-2.5">
                                    <div class="info-card p-3.5">
                                        <span class="field-label">Judul Lowongan</span>
                                        <p class="field-value line-clamp-2">{{ $pengajuan->lowongan->judul_lowongan }}</p>
                                    </div>
                                    <div class="info-card p-3.5">
                                        <span class="field-label">Posisi Magang</span>
                                        <p class="field-value">{{ $pengajuan->lowongan->posisi_magang }}</p>
                                    </div>
                                    <div class="info-card p-3.5">
                                        <span class="field-label">Divisi</span>
                                        <p class="field-value">{{ $pengajuan->lowongan->divisi }}</p>
                                    </div>
                                    <div class="info-card p-3.5">
                                        <span class="field-label">Kuota Peserta</span>
                                        <p class="field-value">{{ $pengajuan->lowongan->kuota_peserta }} Peserta</p>
                                    </div>
                                    <div class="info-card p-3.5">
                                        <span class="field-label">Perusahaan</span>
                                        <p class="field-value">{{ optional($pengajuan->lowongan->industri)->nama_industri ?? '-' }}</p>
                                    </div>
                                    <div class="info-card p-3.5">
                                        <span class="field-label">Status Lowongan</span>
                                        @php
                                            $lowonganStatusClass = match($pengajuan->lowongan->status) {
                                                'dibuka' => 'bg-green-100 text-green-800',
                                                'ditutup' => 'bg-red-100 text-red-800',
                                                default => 'bg-yellow-100 text-yellow-800'
                                            };
                                        @endphp
                                        <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold {{ $lowonganStatusClass }}">{{ ucfirst($pengajuan->lowongan->status) }}</span>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <a href="{{ route('institusi.lowongan.show', $pengajuan->lowongan->id) }}"
                                        class="w-full inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-purple-600 to-purple-700 px-4 py-3 text-sm font-semibold text-white shadow-md transition hover:shadow-lg hover:from-purple-700 hover:to-purple-800">
                                        <i class="fas fa-eye mr-2"></i>Lihat Detail Lengkap
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="section-card p-5 sm:p-6 mt-6">
                        <div class="section-title">
                            <div class="section-icon bg-blue-50 text-blue-600">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="section-text">
                                <p>Peserta</p>
                                <h2>Daftar Calon Peserta Magang</h2>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach ($pengajuan->details as $detail)
                                <div class="info-card p-5 sm:p-6 border-l-4 border-l-blue-400">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-base font-bold text-blue-600">
                                            <i class="fas fa-user-circle mr-2"></i>Peserta #{{ $loop->iteration }}
                                        </h3>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <span class="field-label">Nama</span>
                                            <p class="field-value">{{ $detail->nama }}</p>
                                        </div>
                                        <div>
                                            <span class="field-label">Jurusan</span>
                                            <p class="field-value">{{ $detail->jurusan }}</p>
                                        </div>
                                        <div>
                                            <span class="field-label">Email</span>
                                            <p class="field-value break-all text-blue-600">{{ $detail->email }}</p>
                                        </div>
                                        <div>
                                            <span class="field-label">No Telepon</span>
                                            <p class="field-value">{{ $detail->no_telp }}</p>
                                        </div>
                                        <div>
                                            <span class="field-label">Jenis Kelamin</span>
                                            <p class="field-value">{{ $detail->jenis_kelamin === 'P' ? 'Perempuan' : 'Lelaki' }}</p>
                                        </div>
                                        <div>
                                            <span class="field-label">Soft Skill</span>
                                            <p class="field-value">{{ $detail->soft_skill ?? '—' }}</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <span class="field-label">Hard Skill</span>
                                            <p class="field-value">{{ $detail->hard_skill ?? '—' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-start gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('institusi.pengajuan.index') }}"
                            class="inline-flex items-center px-4 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
