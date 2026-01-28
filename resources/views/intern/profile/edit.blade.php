@extends('layouts.app')

@section('title', 'Edit Profile - Sistem Manajemen Magang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">Edit Profile</h1>
                    <p class="text-gray-600 mt-1">Perbarui informasi profil Anda</p>
                </div>
                <a href="{{ route('intern.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl" role="alert">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle mr-3 mt-1"></i>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('intern.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Photo Upload Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-image mr-3"></i>
                        Foto Profil
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
                        <div class="flex-shrink-0">
                            @if($intern->photo_path)
                                <img src="{{ url('storage/' . $intern->photo_path) }}" alt="Current Photo" 
                                    class="w-32 h-32 rounded-full object-cover border-4 border-blue-500" id="photo-preview">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center" id="photo-preview-placeholder">
                                    <i class="fas fa-user text-4xl text-gray-500"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Foto Baru</label>
                            <input type="file" name="photo" id="photo" accept="image/*" 
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-3 text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-2"></i>Format: JPG, PNG, GIF. Maksimal 2MB
                            </p>
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-times-circle mr-2"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-lock mr-3"></i>
                        Ubah Password
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-6 flex items-center">
                        Kosongkan jika tidak ingin mengubah password
                    </p>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                            <input type="password" name="current_password" id="current_password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                placeholder="Masukkan password lama">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-times-circle mr-2"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="password" id="password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                placeholder="Masukkan password baru">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-times-circle mr-2"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                placeholder="Konfirmasi password baru">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Info (Read-only) -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-green-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-user-circle mr-3"></i>
                        Informasi Profil
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Nama</label>
                            <p class="text-gray-900 font-medium">{{ $intern->name }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Email</label>
                            <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Jenis Kelamin</label>
                            <p class="text-gray-900 font-medium">{{ $intern->gender }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Tingkat Pendidikan</label>
                            <p class="text-gray-900 font-medium">{{ $intern->education_level }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Jurusan</label>
                            <p class="text-gray-900 font-medium">{{ $intern->major ?: '-' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Nomor Telepon</label>
                            <p class="text-gray-900 font-medium">{{ $intern->phone ?: '-' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Institusi</label>
                            <p class="text-gray-900 font-medium">{{ $intern->institution }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('intern.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Photo preview
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photo-preview');
                const placeholder = document.getElementById('photo-preview-placeholder');
                
                if (preview) {
                    preview.src = e.target.result;
                } else if (placeholder) {
                    placeholder.innerHTML = '<img src="' + e.target.result + '" class="w-32 h-32 rounded-full object-cover border-4 border-blue-500" id="photo-preview">';
                    placeholder.removeAttribute('id');
                    placeholder.classList.remove('bg-gray-300', 'flex', 'items-center', 'justify-center');
                } else {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-32 h-32 rounded-full object-cover border-4 border-blue-500';
                    img.id = 'photo-preview';
                    document.querySelector('.flex.items-center.space-x-6').insertBefore(img, document.querySelector('.flex-1'));
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection