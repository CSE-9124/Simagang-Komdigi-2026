@extends('layouts.app')

@section('title', 'Detail Logbook - Sistem Magang')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        *,
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .mentor-logbook-page {
            min-height: 100vh;
            background: #f1f5ff;
        }

        .logbook-hero {
            background: linear-gradient(110deg, #0f2878 0%, #2d3ecb 55%, #4f46e5 100%);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(20, 40, 120, 0.16);
        }

        .logbook-hero::before {
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

        .logbook-hero::after {
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

        .panel-shell {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(20, 40, 120, 0.06), 0 4px 18px rgba(20, 40, 120, 0.06);
            overflow: hidden;
        }

        .section-card {
            background: #f8faff;
            border: 1px solid #e8eeff;
            border-radius: 18px;
        }

        .soft-badge {
            background: linear-gradient(135deg, #eff6ff, #f5f3ff);
            border: 1px solid #dbeafe;
        }
    </style>
@endpush

@section('content')
    <div class="mentor-logbook-page py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 sm:mb-8">
                <div class="logbook-hero px-5 sm:px-8 py-6 sm:py-8">
                    <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div class="max-w-2xl text-white">
                            <p class="text-xs sm:text-sm uppercase tracking-[0.3em] text-blue-100/80">Mentor Dashboard</p>
                            <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold leading-tight">Detail Logbook</h1>
                
                        </div>

                        <div
                            class="flex items-center gap-4 rounded-2xl bg-white/10 px-4 py-4 backdrop-blur-sm border border-white/10">
                            @if ($logbook->intern->photo_path)
                                <img src="{{ url('storage/' . $logbook->intern->photo_path) }}"
                                    class="h-16 w-16 rounded-full object-cover object-center border-4 border-white shadow-lg flex-shrink-0"
                                    alt="{{ $logbook->intern->name }}" />
                            @else
                                <div
                                    class="h-16 w-16 rounded-full bg-white flex items-center justify-center shadow-lg flex-shrink-0">
                                    <i class="fas fa-user text-blue-600 text-2xl"></i>
                                </div>
                            @endif
                            <div class="min-w-0 text-white">
                                <h2 class="text-lg sm:text-xl font-bold truncate">{{ $logbook->intern->name }}</h2>
                                <p class="mt-1 text-xs sm:text-sm text-blue-100 truncate">
                                    {{ $logbook->intern->institution }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-shell">
                <div class="border-b border-slate-100 bg-white px-5 sm:px-8 py-4 sm:py-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                <i class="fas fa-clipboard-list text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Logbook</p>
                                <p class="text-base sm:text-lg font-bold text-slate-900">Detail catatan harian</p>
                            </div>
                        </div>

                        <div
                            class="soft-badge inline-flex items-center gap-2 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700">
                            <i class="fas fa-calendar-day text-blue-600"></i>
                            <span>{{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 p-5 sm:p-8 lg:grid-cols-2">
                    <div class="section-card p-5 sm:p-6 lg:col-span-2">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-blue-500">Identitas</p>
                                <h3 class="text-lg font-bold text-slate-900">Anak magang</h3>
                            </div>
                        </div>
                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl bg-white px-4 py-4 shadow-sm border border-slate-100">
                                <p class="text-xs uppercase tracking-wide text-slate-400">Nama</p>
                                <p class="mt-1 text-sm sm:text-base font-semibold text-slate-900">
                                    {{ $logbook->intern->name }}</p>
                            </div>
                            <div class="rounded-2xl bg-white px-4 py-4 shadow-sm border border-slate-100">
                                <p class="text-xs uppercase tracking-wide text-slate-400">Instansi</p>
                                <p class="mt-1 text-sm sm:text-base font-semibold text-slate-900">
                                    {{ $logbook->intern->institution }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="section-card p-5 sm:p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-blue-500">Aktivitas</p>
                                <h3 class="text-lg font-bold text-slate-900">Isi logbook</h3>
                            </div>
                        </div>
                        <div class="rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm">
                            <p class="whitespace-pre-line text-sm sm:text-[15px] leading-7 text-slate-700">
                                {{ $logbook->activity }}
                            </p>
                        </div>
                    </div>

                    <div class="section-card p-5 sm:p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                                <i class="fas fa-camera"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-indigo-500">Dokumentasi</p>
                                <h3 class="text-lg font-bold text-slate-900">Foto kegiatan</h3>
                            </div>
                        </div>
                        @if ($logbook->photo_path)
                            @php
                                $photoUrl = URL::temporarySignedRoute('mentor.logbook.photo', now()->addMinutes(5), [
                                    'filename' => basename($logbook->photo_path),
                                ]);
                            @endphp
                            <div
                                class="relative group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
                                <img src="{{ $photoUrl }}"
                                    class="h-72 w-full object-cover transition duration-300 group-hover:scale-[1.02]"
                                    alt="Foto Logbook" onclick="window.open('{{ $photoUrl }}', '_blank')" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-950/35 via-transparent to-transparent opacity-0 transition group-hover:opacity-100">
                                </div>
                                <button type="button"
                                    class="absolute bottom-4 right-4 inline-flex items-center gap-2 rounded-full bg-white/95 px-4 py-2 text-sm font-semibold text-blue-700 shadow-lg transition hover:bg-white"
                                    onclick="window.open('{{ $photoUrl }}', '_blank')">
                                    <i class="fas fa-up-right-from-square"></i>
                                    Lihat penuh
                                </button>
                            </div>
                            <p class="mt-3 text-xs text-slate-500">
                                <i class="fas fa-circle-info mr-1 text-blue-500"></i>
                                Klik gambar atau tombol untuk membuka ukuran penuh.
                            </p>
                        @else
                            <div
                                class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                                <i class="fas fa-image text-4xl text-slate-300"></i>
                                <p class="mt-3 text-sm font-medium text-slate-500">Tidak ada foto dokumentasi.</p>
                            </div>
                        @endif
                    </div>

                    <div
                        class="lg:col-span-2 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ url()->previous() }}"
                            class="inline-flex items-center justify-center rounded-2xl bg-slate-600 px-5 py-3 text-sm sm:text-base font-semibold text-white shadow-sm transition hover:bg-slate-700">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>

                        <a href="{{ route('mentor.logbook.index') }}"
                            class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm sm:text-base font-semibold text-white shadow-sm transition hover:bg-blue-700">
                            <i class="fas fa-list mr-2"></i>
                            Lihat Semua Logbook
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
