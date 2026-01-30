@extends('layouts.app')

@section('title', 'Edit Logbook - Sistem Magang')

@section('content')
<div class="min-h-screen bg-blue-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold leading-tight text-blue-600 mb-2 pb-2">
                Edit Logbook
            </h1>
            <p class="text-gray-600">Perbarui aktivitas harian Anda</p>
        </div>

        <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-edit mr-3"></i>
                    Form Edit Logbook
                </h2>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('intern.logbook.update', $logbook) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Tanggal Field -->
                    <div class="mb-6">
                        <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar text-blue-500 mr-2"></i>Tanggal
                        </label>
                        <input type="date" name="date" id="date" value="{{ old('date', $logbook->date->format('Y-m-d')) }}" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        @error('date')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Activity Field -->
                    <div class="mb-6">
                        <label for="activity" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tasks text-blue-500 mr-2"></i>Kegiatan Harian
                        </label>
                        <textarea name="activity" id="activity" rows="10" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            placeholder="Tuliskan kegiatan yang Anda lakukan hari ini...">{{ old('activity', $logbook->activity) }}</textarea>
                        @error('activity')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Current Photo Display -->
                    @if($logbook->photo_path)
                        <div class="mb-6">
                            <p class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-image text-blue-500 mr-2"></i>Foto Saat Ini
                            </p>
                            <div class="bg-gray-50 rounded-xl p-4 border-2 border-dashed border-gray-300">
                                <img src="{{ url('storage/' . $logbook->photo_path) }}" 
                                    alt="Current photo" 
                                    class="w-full max-w-md mx-auto rounded-lg shadow-md border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all"
                                    onclick="window.open('{{ url('storage/' . $logbook->photo_path) }}', '_blank')"
                                    title="Klik untuk melihat full size">
                            </div>
                        </div>
                    @endif

                    <!-- Photo Upload Field -->
                    <div class="mb-8">
                        <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-camera text-blue-500 mr-2"></i>Ganti Foto Dokumentasi (Opsional)
                        </label>
                        <input type="file" name="photo" id="photo" accept="image/*" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-2 text-sm text-gray-500 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i>Format: JPG, PNG (Maks: 2MB). Kosongkan jika tidak ingin mengganti foto.
                        </p>
                        @error('photo')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('intern.logbook.index') }}" 
                             class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 w-full sm:w-auto justify-center">
                            <i class="fas fa-save mr-2"></i>Update Logbook
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection