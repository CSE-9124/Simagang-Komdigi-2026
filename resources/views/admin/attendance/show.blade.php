@extends('layouts.app')

@section('title', 'Detail Absensi - Sistem Magang')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">


    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-blue-600 shadow-lg rounded-lg p-6 mt-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">Detail Absensi</h1>
                    <p class="text-blue-100 text-sm">
                        Informasi kehadiran anak magang
                    </p>
                </div>

                <a href="{{ route('admin.attendance.index') }}"
                class="inline-flex items-center w-1/3 sm:w-auto gap-2 bg-white/90 hover:bg-white
                        text-blue-700 font-semibold px-5 py-2.5 rounded-lg shadow transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>


        <div class="bg-white rounded-xl shadow-sm p-6 space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500">Anak Magang</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $attendance->intern->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Tanggal</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $attendance->date->format('d F Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Status</p>
                    <span class="inline-block mt-1 px-3 py-1 rounded-full text-sm font-semibold
                        @if($attendance->status == 'hadir') bg-green-100 text-green-700
                        @elseif($attendance->status == 'izin') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700
                        @endif">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </div>
            </div>

            @if($attendance->status == 'hadir')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500">Check In</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') : '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Check Out</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i:s') : '-' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @if($attendance->photo_path)
                        @php
                            $photoUrl = URL::temporarySignedRoute(
                                'admin.attendance.photo',
                                now()->addMinutes(5),
                                ['filename' => basename($attendance->photo_path)]
                            );
                        @endphp
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Foto Check In</p>
                            <img src="{{ $photoUrl }}"
                                class="rounded-lg border cursor-pointer"
                                onclick="window.open('{{ $photoUrl }}','_blank')">
                        </div>
                    @endif

                    @if($attendance->photo_checkout)
                        @php
                            $photoCheckoutUrl = URL::temporarySignedRoute(
                                'admin.attendance.photo',
                                now()->addMinutes(5),
                                ['filename' => basename($attendance->photo_checkout)]
                            );
                        @endphp
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Foto Check Out</p>
                            <img src="{{ $photoCheckoutUrl }}"
                                class="rounded-lg border cursor-pointer"
                                onclick="window.open('{{ $photoCheckoutUrl }}','_blank')">
                        </div>
                    @endif
                </div>

            @else
                <div>
                    <p class="text-xs text-gray-500">Keterangan</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $attendance->note ?? '-' }}
                    </p>
                </div>

                @if($attendance->document_path)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Dokumen Pendukung</p>
                        <a href="{{ url('storage/' . $attendance->document_path) }}" target="_blank"
                            class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold">
                            <i class="fas fa-file-download"></i>
                            Download Dokumen
                        </a>
                    </div>
                @endif

                <!-- Verifikasi -->
                <form method="POST"
                        action="{{ route('admin.attendance.update-document-status', $attendance) }}"
                        class="border-t pt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Status Dokumen
                        </label>
                        <select name="document_status" required
                                class="w-full px-4 py-2 rounded-lg border border-gray-300
                                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending" {{ $attendance->document_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $attendance->document_status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $attendance->document_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Catatan Admin
                        </label>
                        <textarea name="admin_note" rows="4"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300
                                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('admin_note', $attendance->admin_note) }}</textarea>
                    </div>

                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg">
                        Update Status
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
