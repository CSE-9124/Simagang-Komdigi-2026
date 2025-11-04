@extends('layouts.app')

@section('title', 'Edit Logbook - Sistem Magang')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Logbook</h1>

        <form method="POST" action="{{ route('intern.logbook.update', $logbook) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date" name="date" id="date" value="{{ old('date', $logbook->date->format('Y-m-d')) }}" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label for="activity" class="block text-sm font-medium text-gray-700 mb-2">Kegiatan Harian</label>
                <textarea name="activity" id="activity" rows="10" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Tuliskan kegiatan yang Anda lakukan hari ini...">{{ old('activity', $logbook->activity) }}</textarea>
                @error('activity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            @if($logbook->photo_path)
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Foto Saat Ini:</p>
                    <img src="{{ url('storage/' . $logbook->photo_path) }}" alt="Current photo" class="w-full max-w-md border rounded-lg">
                </div>
            @endif

            <div class="mb-6">
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Ganti Foto Dokumentasi (Opsional)</label>
                <input type="file" name="photo" id="photo" accept="image/*" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG (Maks: 2MB)</p>
                @error('photo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('intern.logbook.index') }}" class="text-blue-600 hover:text-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Update Logbook
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
