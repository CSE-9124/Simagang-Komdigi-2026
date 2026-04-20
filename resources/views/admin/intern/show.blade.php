@extends('layouts.app')

@section('title', 'Detail Anak Magang - Sistem Magang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="bg-blue-600 shadow-lg rounded-lg p-6 mt-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">Detail Anak Magang</h1>
                    <p class="text-blue-100 text-sm">
                        Informasi profil dan aktivitas magang
                    </p>
                </div>

                <a href="{{ route('admin.intern.edit', $intern) }}"
                class="inline-flex items-center gap-2 w-20 h-10 p-1 bg-white/90 hover:bg-white
                        text-blue-700 font-semibold px-5 py-2.5 rounded-lg shadow transition">
                    <i class="fas fa-edit "></i>
                    Edit
                </a>
            </div>
        </div>

        <!-- Profile -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="flex flex-col items-center">
                    @if($intern->photo_path)
        <img src="{{ url('storage/'.$intern->photo_path) }}"
            alt="{{ $intern->name }}"
            class="w-40 h-40 rounded-full object-cover
                    border-4 border-blue-300
                    shadow-lg ring-4 ring-blue-100">
                @else
                    <div class="w-40 h-40 rounded-full
                                bg-blue-100
                                flex items-center justify-center
                                border-4 border-blue-200
                                shadow-lg">
                        <i class="fas fa-user text-5xl text-blue-500"></i>
                    </div>
                @endif
                    <span class="mt-4 px-4 py-1.5 rounded-full text-xs font-semibold
                        {{ $intern->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $intern->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>

                    @if($intern->team)
                        <span class="mt-2 text-xs text-gray-500">
                            Tim: {{ $intern->team }}
                        </span>
                    @endif
                </div>

                <!-- Info -->
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs">Nama</p>
                        <p class="font-semibold text-gray-900">{{ $intern->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Email</p>
                        <p class="font-semibold text-gray-900">{{ $intern->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Jenis Kelamin</p>
                        <p class="font-semibold text-gray-900">{{ $intern->gender }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Telepon</p>
                        <p class="font-semibold text-gray-900">{{ $intern->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Pendidikan</p>
                        <p class="font-semibold text-gray-900">{{ $intern->education_level }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Jurusan</p>
                        <p class="font-semibold text-gray-900">{{ $intern->major ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-gray-500 text-xs">Institusi</p>
                        <p class="font-semibold text-gray-900">{{ $intern->institution }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Mentor</p>
                        <p class="font-semibold text-gray-900">
                            {{ $intern->mentor ? $intern->mentor->name : 'Belum ada mentor' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Periode Magang</p>
                        <p class="font-semibold text-gray-900">
                            {{ $intern->start_date->format('d M Y') }}
                            –
                            {{ $intern->end_date->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-5 flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Hadir</p>
                    <p class="text-2xl font-bold">{{ $stats['total_hadir'] }}</p>
                </div>
                <i class="fas fa-calendar-check text-green-600 text-2xl"></i>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Izin</p>
                    <p class="text-2xl font-bold">{{ $stats['total_izin'] }}</p>
                </div>
                <i class="fas fa-calendar-times text-yellow-500 text-2xl"></i>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Sakit</p>
                    <p class="text-2xl font-bold">{{ $stats['total_sakit'] }}</p>
                </div>
                <i class="fas fa-calendar-minus text-red-500 text-2xl"></i>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Logbook</p>
                    <p class="text-2xl font-bold">{{ $stats['total_logbooks'] }}</p>
                </div>
                <i class="fas fa-book text-blue-600 text-2xl"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold mb-4">Riwayat Absensi</h2>
                <table class="w-full text-sm divide-y divide-gray-200">
                    <thead>
                        <tr class="text-center bg-blue-50">
                            <th class="px-6 py-4 text-xs font-bold text-blue-900 uppercase">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-bold text-blue-900 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($intern->attendances as $attendance)
                            <tr class="border-b text-center">
                                <td class="py-2">{{ $attendance->date->format('d/m/Y') }}</td>
                                <td class="py-2 capitalize">{{ $attendance->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-400">
                                    Belum ada absensi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Logbook -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold mb-4">Logbook Terakhir</h2>
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @forelse($intern->logbooks as $logbook)
                        <div class="border rounded-lg p-3 bg-blue-50 hover:bg-blue-100 transition">
                            <p class="text-xs text-gray-500 mb-1">
                                {{ $logbook->date->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-700">
                                {{ $logbook->activity }}
                            </p>
                        </div>
                    @empty
                        <p class="text-center text-gray-400">Belum ada logbook</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Laporan Akhir -->
        @if($intern->finalReport)
            <div class="bg-white rounded-xl shadow-sm p-6 mb-10">
                <h2 class="text-lg font-semibold mb-4">Laporan Akhir</h2>
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div>
                        <p class="font-semibold">{{ $intern->finalReport->file_name }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $intern->finalReport->submitted_at->format('d F Y H:i') }}
                        </p>
                    </div>
                    <a href="{{ route('admin.report.show', $intern->finalReport) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @endif

        <div class="mt-10 mb-5">
            <a href="{{ route('admin.intern.index') }}"
            class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar Anak Magang
            </a>
        </div>

    </div>
</div>
@endsection
