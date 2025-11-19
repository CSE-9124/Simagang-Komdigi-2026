@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-start space-x-6">
                <div>
                    @if($intern->photo_path)
                        <img src="{{ url('storage/'.$intern->photo_path) }}" class="w-28 h-28 object-cover rounded border" />
                    @else
                        <div class="w-28 h-28 rounded bg-gray-100 flex items-center justify-center text-gray-400">No Photo</div>
                    @endif
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $intern->name }}</h1>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-700">
                        <div><span class="text-gray-500">Institusi:</span> {{ $intern->institution }}</div>
                        <div><span class="text-gray-500">Jenjang:</span> {{ $intern->education_level }}</div>
                        <div><span class="text-gray-500">Jurusan:</span> {{ $intern->major ?? '-' }}</div>
                        <div><span class="text-gray-500">Nomor Telepon:</span> {{ $intern->phone ?? '-' }}</div>
                        <div><span class="text-gray-500">Periode:</span> {{ $intern->start_date->format('d M Y') }} - {{ $intern->end_date->format('d M Y') }}</div>
                        <div><span class="text-gray-500">Status:</span> {{ $intern->is_active ? 'Aktif' : 'Tidak aktif' }}</div>
                    </div>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-blue-50 rounded">
                    <div class="text-sm text-gray-600">Total Absensi</div>
                    <div class="text-2xl font-bold">{{ $intern->attendances()->count() }}</div>
                </div>
                <div class="p-4 bg-green-50 rounded">
                    <div class="text-sm text-gray-600">Total Logbook</div>
                    <div class="text-2xl font-bold">{{ $intern->logbooks()->count() }}</div>
                </div>
                <div class="p-4 bg-purple-50 rounded">
                    <div class="text-sm text-gray-600">Laporan Akhir</div>
                    <div class="text-2xl font-bold">{{ $intern->finalReport ? '1' : '0' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-lg font-semibold mb-3">Absensi Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">In</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Out</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($intern->attendances as $a)
                            <tr>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}</td>
                                <td class="px-4 py-2 capitalize">{{ $a->status }}</td>
                                <td class="px-4 py-2">{{ $a->check_in ? \Carbon\Carbon::parse($a->check_in)->format('H:i') : '-' }}</td>
                                <td class="px-4 py-2">{{ $a->check_out ? \Carbon\Carbon::parse($a->check_out)->format('H:i') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">Tidak ada data.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-lg font-semibold mb-3">Logbook Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aktivitas</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($intern->logbooks as $l)
                            <tr>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($l->date)->format('d M Y') }}</td>
                                <td class="px-4 py-2">{{ $l->activity }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-4 text-center text-gray-500">Tidak ada data.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-semibold mb-3">Laporan Akhir</h2>
            @if($intern->finalReport)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div><span class="text-gray-500">File:</span> <a class="text-blue-600 hover:underline" target="_blank" href="{{ url('storage/'.$intern->finalReport->file_path) }}">{{ $intern->finalReport->file_name }}</a></div>
                    <div><span class="text-gray-500">Status:</span> <span class="capitalize">{{ $intern->finalReport->status }}</span></div>
                    <div><span class="text-gray-500">Nilai:</span> {{ $intern->finalReport->grade ?? '-' }}</div>
                    <div><span class="text-gray-500">Perlu Revisi:</span> {{ $intern->finalReport->needs_revision ? 'Ya' : 'Tidak' }}</div>
                    <div><span class="text-gray-500">Dikirim:</span> {{ $intern->finalReport->submitted_at ? \Carbon\Carbon::parse($intern->finalReport->submitted_at)->format('d M Y H:i') : '-' }}</div>
                    <div><span class="text-gray-500">Catatan Admin:</span> {{ $intern->finalReport->admin_note ?? '-' }}</div>
                </div>
            @else
                <p class="text-gray-600">Belum ada laporan akhir.</p>
            @endif
        </div>
    </div>
</div>
@endsection


