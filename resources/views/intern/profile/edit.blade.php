@extends('layouts.app')

@section('title', 'Edit Profile - Sistem Manajemen Magang')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
            <a href="{{ route('intern.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('intern.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Photo Upload Section -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                <div class="flex items-center space-x-6">
                    @if($intern->photo_path)
                        <img src="{{ url('storage/' . $intern->photo_path) }}" alt="Current Photo" 
                            class="w-32 h-32 rounded-full object-cover border-4 border-blue-500" id="photo-preview">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center" id="photo-preview-placeholder">
                            <i class="fas fa-user text-4xl text-gray-500"></i>
                        </div>
                    @endif
                    <div class="flex-1">
                        <input type="file" name="photo" id="photo" accept="image/*" 
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="mb-6 border-t pt-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password</h2>
                <p class="text-sm text-gray-500 mb-4">Kosongkan jika tidak ingin mengubah password</p>

                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                    <input type="password" name="current_password" id="current_password" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan password lama">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password" id="password" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan password baru">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Konfirmasi password baru">
                </div>
            </div>

            <!-- Profile Info (Read-only) -->
            <div class="mb-6 border-t pt-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Profil</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama</label>
                        <p class="text-gray-900">{{ $intern->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                        <p class="text-gray-900">{{ $intern->gender }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tingkat Pendidikan</label>
                        <p class="text-gray-900">{{ $intern->education_level }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jurusan</label>
                        <p class="text-gray-900">{{ $intern->major ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                        <p class="text-gray-900">{{ $intern->phone ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Institusi</label>
                        <p class="text-gray-900">{{ $intern->institution }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('intern.dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
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

