@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Detail Logbook</h1>

            <div class="space-y-2 text-sm text-gray-700 mb-4">
                <div><span class="text-gray-500">Nama:</span> {{ $logbook->intern->name }}</div>
                <div><span class="text-gray-500">Institusi:</span> {{ $logbook->intern->institution }}</div>
                <div><span class="text-gray-500">Tanggal:</span> {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}</div>
            </div>

            <div class="mb-4">
                <h2 class="text-lg font-semibold mb-2">Aktivitas</h2>
                <p class="text-gray-800 whitespace-pre-line">{{ $logbook->activity }}</p>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-2">Foto</h2>
                @if($logbook->photo_path)
                    <img src="{{ url('storage/'.$logbook->photo_path) }}" class="w-full max-w-md border rounded" />
                @else
                    <p class="text-gray-500">Tidak ada foto.</p>
                @endif
            </div>

            <div class="mt-6">
                <a href="{{ url()->previous() }}" class="px-4 py-2 rounded border">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection


