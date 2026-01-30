@extends('layouts.app')

@section('title', 'Edit Bukti Mikro Skill - Sistem Magang')

@section('content')
<div class="min-h-screen bg-blue-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <div>
                    <h1 class="text-4xl font-bold leading-tight text-blue-600 mb-2 pb-2">
                        Edit Bukti Mikro Skill
                    </h1>
                    <p class="text-gray-600">Perbarui bukti pengumpulan mikro skill Anda</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-edit mr-3"></i>
                    Form Edit
                </h2>
            </div>

            <form method="POST" action="{{ route('intern.microskill.update', $submission->id) }}" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <!-- Title Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-heading mr-2 text-blue-500"></i>
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           value="{{ old('title', $submission->title) }}" 
                           required 
                           placeholder="Masukkan judul mikro skill"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-align-left mr-2 text-blue-500"></i>
                        Deskripsi <span class="text-gray-500 font-normal text-xs">(Opsional)</span>
                    </label>
                    <textarea name="description" 
                              rows="4" 
                              placeholder="Jelaskan detail dari bukti mikro skill ini..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none">{{ old('description', $submission->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Photo Field -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-4 flex items-center">
                        <i class="fas fa-image mr-2 text-blue-500"></i>
                        Foto Bukti <span class="text-gray-500 font-normal text-xs">(Opsional)</span>
                    </label>
                    
                    <!-- Current Photo Display -->
                    @if($submission->photo_path)
                        <div class="mb-6">
                            <div class="bg-white rounded-lg p-4 border border-blue-200">
                                <p class="text-xs font-semibold text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-image mr-2 text-blue-500"></i>
                                    Foto Saat Ini
                                </p>
                                  <div class="flex justify-center">
                                     <img src="{{ asset('storage/'.$submission->photo_path) }}"
                                         alt="Current Photo"
                                         class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg h-auto rounded-lg border-2 border-blue-300 shadow-md mx-auto object-contain">
                                  </div>
                            </div>
                        </div>
                    @endif

                    <!-- File Input -->
                    <input type="file" 
                           name="photo" 
                           accept="image/*" 
                           id="photo-input"
                           class="w-full px-4 py-3 border-2 border-dashed border-blue-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer">

                    <div class="mt-4 bg-blue-100 border border-blue-300 rounded-lg p-3">
                        <p class="text-xs text-blue-800 flex items-start">
                            <i class="fas fa-info-circle mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, GIF (Max. 4MB)</span>
                        </p>
                    </div>

                    @error('photo')
                        <p class="mt-3 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('intern.microskill.index') }}" 
                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection