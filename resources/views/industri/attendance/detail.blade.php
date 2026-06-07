@extends('layouts.app')

@section('title', 'Detail Absensi Izin/Sakit')

@section('content')
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-700 to-indigo-700 px-6 py-6 text-white">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <p class="text-xs uppercase tracking-[0.35em] text-blue-100">Industri</p>
                            <h1 class="text-2xl font-bold mt-1">Detail Absensi {{ ucfirst($attendance->status) }}</h1>
                            <p class="text-sm text-blue-100 mt-1">Informasi lengkap pengajuan izin/sakit anak magang.</p>
                        </div>
                        <a href="{{ route('industri.attendance.index') }}"
                            class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20 transition">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="p-6 sm:p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Nama</p>
                            <p class="mt-1 text-lg font-semibold text-slate-900">{{ $attendance->intern->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Tanggal</p>
                            <p class="mt-1 text-lg font-semibold text-slate-900">{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Status</p>
                            <span class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs font-bold
                                @if ($attendance->status == 'izin') bg-yellow-100 text-yellow-800
                                @else bg-orange-100 text-orange-800 @endif">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Status Dokumen</p>
                            <span class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs font-bold
                                @if ($attendance->document_status == 'approved') bg-emerald-100 text-emerald-800
                                @elseif($attendance->document_status == 'rejected') bg-rose-100 text-rose-800
                                @else bg-slate-100 text-slate-700 @endif">
                                {{ ucfirst($attendance->document_status ?? 'Pending') }}
                            </span>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Keterangan</p>
                        <p class="mt-2 text-slate-700 whitespace-pre-wrap">{{ $attendance->note ?? '-' }}</p>
                    </div>

                    @if ($attendance->document_path)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Dokumen Pendukung</p>
                            <a href="{{ url('storage/' . $attendance->document_path) }}" target="_blank"
                                class="mt-2 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                                <i class="fas fa-file-download"></i>
                                Lihat / Download Dokumen
                            </a>
                        </div>
                    @endif

                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Tindakan Persetujuan</h2>
                                <p class="text-sm text-slate-500">Setujui atau tolak pengajuan izin/sakit ini.</p>
                            </div>
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ ucfirst($attendance->document_status ?? 'Pending') }}</span>
                        </div>

                        <form method="POST" action="{{ route('industri.attendance.update-document-status', $attendance) }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="document_status" class="block text-sm font-semibold text-slate-700 mb-2">Status Dokumen</label>
                                <select id="document_status" name="document_status" required
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200">
                                    <option value="approved" @selected($attendance->document_status === 'approved')>Approved</option>
                                    <option value="rejected" @selected($attendance->document_status === 'rejected')>Rejected</option>
                                </select>
                            </div>

                            <div>
                                <label for="admin_note" class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                                <textarea id="admin_note" name="admin_note" rows="4"
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200">{{ old('admin_note', $attendance->admin_note) }}</textarea>
                            </div>

                            <button type="submit"
                                class="inline-flex items-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
