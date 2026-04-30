@extends('layouts.app')

@section('title', 'Detail Nilai Sertifikat - Institusi')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-blue-600 mb-3">Detail Nilai Sertifikat</h1>
                <p class="text-sm sm:text-base text-gray-600">Detail nilai sertifikat untuk <strong>{{ $certificate->intern->name }}</strong>.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-blue-200 overflow-hidden">
                <div class="px-6 py-6 border-b border-gray-200 md:px-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Sertifikat #{{ $certificate->certificate_number }}</h2>
                            <p class="text-sm text-gray-500">Diterbitkan: {{ optional($certificate->issue_date)->translatedFormat('d F Y') ?? '-' }}</p>
                        </div>
                        <a href="{{ route('institusi.certificate.index') }}"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-blue-200 text-blue-700 bg-blue-50 hover:bg-blue-100 transition">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Daftar Sertifikat
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2 md:p-8">
                    <div class="rounded-3xl bg-blue-50 p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Informasi Intern</h3>
                        <dl class="space-y-3 text-sm text-gray-700">
                            <div class="flex justify-between gap-4">
                                <dt class="font-semibold">Nama</dt>
                                <dd>{{ $certificate->intern->name }}</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="font-semibold">Institusi</dt>
                                <dd>{{ $certificate->intern->institution }}</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="font-semibold">Periode Magang</dt>
                                <dd>{{ optional($certificate->intern->start_date)->translatedFormat('d M Y') ?? '-' }} - {{ optional($certificate->intern->end_date)->translatedFormat('d M Y') ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="font-semibold">Status</dt>
                                <dd>{{ $certificate->intern->is_active ? 'Aktif' : 'Alumni' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Nilai</h3>
                        <div class="space-y-3 text-sm text-gray-700">
                            @if ($certificate->score)
                                <div class="flex justify-between gap-4">
                                    <span class="font-semibold">Rata-rata Sertifikat</span>
                                    <span>{{ $certificate->score->average }}</span>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <span class="font-semibold">Grade Sertifikat</span>
                                    <span>{{ scoreToGrade($certificate->score->average) }}</span>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <span class="font-semibold">Micro Skill</span>
                                    <span>{{ $certificate->score->micro_skill }} selesai</span>
                                </div>
                            @else
                                <div class="flex justify-between gap-4">
                                    <span class="font-semibold">Rata-rata Sertifikat</span>
                                    <span>-</span>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <span class="font-semibold">Grade Sertifikat</span>
                                    <span>-</span>
                                </div>
                            @endif

                            @if ($certificate->intern->finalReport)
                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex justify-between gap-4">
                                        <span class="font-semibold">Nilai Laporan Akhir</span>
                                        <span>{{ $certificate->intern->finalReport->score ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between gap-4">
                                        <span class="font-semibold">Grade Laporan Akhir</span>
                                        <span>{{ $certificate->intern->finalReport->grade ?? '-' }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="pt-4 border-t border-gray-200">
                                    <p class="text-sm text-gray-500">Belum ada laporan akhir.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($certificate->score)
                    <div class="p-6 md:p-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Detail Komponen Nilai</h3>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @php
                                $items = [
                                    ['label' => 'Kedisiplinan & Kehadiran', 'value' => $certificate->score->discipline_attendance],
                                    ['label' => 'Tanggung Jawab', 'value' => $certificate->score->responsibility],
                                    ['label' => 'Kerjasama & Komunikasi', 'value' => $certificate->score->teamwork_communication],
                                    ['label' => 'Keterampilan Teknis', 'value' => $certificate->score->technical_skill],
                                    ['label' => 'Etos Kerja', 'value' => $certificate->score->work_ethic],
                                    ['label' => 'Inisiatif & Kreativitas', 'value' => $certificate->score->initiative_creativity],
                                ];
                            @endphp

                            @foreach ($items as $item)
                                <div class="rounded-3xl bg-blue-50 p-5 border border-blue-100">
                                    <p class="text-sm text-gray-500">{{ $item['label'] }}</p>
                                    <p class="mt-3 text-3xl font-bold text-blue-700">{{ $item['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
