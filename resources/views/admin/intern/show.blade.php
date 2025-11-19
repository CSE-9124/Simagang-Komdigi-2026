@extends('layouts.app')

@section('title', 'Detail Anak Magang - Sistem Magang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Anak Magang</h1>
            <div class="flex space-x-3">
                <a href="{{ route('admin.intern.edit', $intern) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.intern.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col items-center md:items-start">
                @if($intern->photo_path)
                    <img src="{{ url('storage/' . $intern->photo_path) }}" alt="{{ $intern->name }}" 
                        class="w-48 h-48 rounded-full object-cover border-4 border-blue-500 mb-4">
                @else
                    <div class="w-48 h-48 rounded-full bg-gray-300 flex items-center justify-center mb-4">
                        <i class="fas fa-user text-6xl text-gray-500"></i>
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                    <p class="text-lg text-gray-900">{{ $intern->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Email</label>
                    <p class="text-lg text-gray-900">{{ $intern->user->email }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                    <p class="text-lg text-gray-900">{{ $intern->gender }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Jenjang Pendidikan</label>
                    <p class="text-lg text-gray-900">{{ $intern->education_level }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Jurusan</label>
                    <p class="text-lg text-gray-900">{{ $intern->major ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Nomor Telepon</label>
                    <p class="text-lg text-gray-900">{{ $intern->phone ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Institusi</label>
                    <p class="text-lg text-gray-900">{{ $intern->institution }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Keperluan</label>
                    <p class="text-lg text-gray-900">{{ $intern->purpose ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Mentor</label>
                    <p class="text-lg text-gray-900">{{ $intern->mentor ? $intern->mentor->name : 'Belum ada mentor' }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">TIM</label>
                    @if($intern->team)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            {{ $intern->team }}
                        </span>
                    @else
                        <p class="text-lg text-gray-900">-</p>
                    @endif
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Periode Magang</label>
                    <p class="text-lg text-gray-900">{{ $intern->start_date->format('d F Y') }} - {{ $intern->end_date->format('d F Y') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Status</label>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $intern->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $intern->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-2">Total Hadir</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['total_hadir'] }}</p>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-2">Total Izin</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['total_izin'] }}</p>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-2">Total Sakit</p>
                <p class="text-3xl font-bold text-red-600">{{ $stats['total_sakit'] }}</p>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-2">Total Logbook</p>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['total_logbooks'] }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Riwayat Absensi (30 Terakhir)</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($intern->attendances as $attendance)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900">{{ $attendance->date->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($attendance->status == 'hadir') bg-green-100 text-green-800
                                        @elseif($attendance->status == 'izin') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-2 text-center text-gray-500">Belum ada absensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Logbook Terakhir (10 Terakhir)</h2>
            <div class="space-y-4">
                @forelse($intern->logbooks as $logbook)
                    <div class="border-b border-gray-200 pb-4">
                        <p class="text-sm font-medium text-blue-600 mb-1">{{ $logbook->date->format('d F Y') }}</p>
                        <p class="text-sm text-gray-700 line-clamp-3">{{ $logbook->activity }}</p>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Belum ada logbook</p>
                @endforelse
            </div>
        </div>
    </div>

    @if($intern->finalReport)
        <div class="bg-white shadow rounded-lg p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Laporan Akhir</h2>
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-lg font-medium text-gray-900">{{ $intern->finalReport->file_name }}</p>
                    <p class="text-sm text-gray-500">Diupload: {{ $intern->finalReport->submitted_at->format('d F Y H:i') }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($intern->finalReport->status == 'approved') bg-green-100 text-green-800
                        @elseif($intern->finalReport->status == 'rejected') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucfirst($intern->finalReport->status) }}
                    </span>
                    <a href="{{ route('admin.report.show', $intern->finalReport) }}" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
