@extends('layouts.app')

@section('title', 'Detail Absensi - Sistem Magang')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Absensi</h1>
            <a href="{{ route('admin.attendance.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Anak Magang</label>
                <p class="text-lg text-gray-900">{{ $attendance->intern->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal</label>
                <p class="text-lg text-gray-900">{{ $attendance->date->format('d F Y') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    @if($attendance->status == 'hadir') bg-green-100 text-green-800
                    @elseif($attendance->status == 'izin') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($attendance->status) }}
                </span>
            </div>

            @if($attendance->status == 'hadir')
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Check In</label>
                    <p class="text-lg text-gray-900">{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') : '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Check Out</label>
                    <p class="text-lg text-gray-900">{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i:s') : '-' }}</p>
                </div>
                @if($attendance->photo_path)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Foto Check In</label>
                        <img src="{{ url('storage/' . $attendance->photo_path) }}" alt="Check In Photo" class="w-full max-w-md border rounded-lg cursor-pointer" onclick="window.open('{{ url('storage/' . $attendance->photo_path) }}', '_blank')">
                    </div>
                @endif
                @if($attendance->photo_checkout)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Foto Check Out</label>
                        <img src="{{ url('storage/' . $attendance->photo_checkout) }}" alt="Check Out Photo" class="w-full max-w-md border rounded-lg cursor-pointer" onclick="window.open('{{ url('storage/' . $attendance->photo_checkout) }}', '_blank')">
                    </div>
                @endif
            @else
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Keterangan</label>
                    <p class="text-lg text-gray-900">{{ $attendance->note ?? '-' }}</p>
                </div>
                @if($attendance->document_path)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Dokumen Pendukung</label>
                        <a href="{{ url('storage/' . $attendance->document_path) }}" target="_blank" 
                            class="text-blue-600 hover:text-blue-800 underline">
                            <i class="fas fa-download mr-2"></i>Download Dokumen
                        </a>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.attendance.update-document-status', $attendance) }}" class="mt-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="document_status" class="block text-sm font-medium text-gray-700 mb-2">Status Dokumen</label>
                        <select name="document_status" id="document_status" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending" {{ $attendance->document_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $attendance->document_status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $attendance->document_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="admin_note" class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                        <textarea name="admin_note" id="admin_note" rows="4" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('admin_note', $attendance->admin_note) }}</textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Update Status
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
