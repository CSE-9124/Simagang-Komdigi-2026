@extends('layouts.app')

@section('title', 'Edit Profile Institusi - Sistem Manajemen Magang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">Edit Profile Institusi</h1>
                    <p class="text-gray-600 mt-1">Perbarui informasi institusi</p>
                </div>
                <a href="{{ route('institusi.profile.show') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <form id="institusi-form" method="POST" action="{{ route('institusi.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-building mr-3"></i>Informasi Institusi
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="nama_institusi" class="block text-sm font-medium text-gray-700 mb-2">Nama Institusi</label>
                            <input type="text" name="nama_institusi" id="nama_institusi" value="{{ old('nama_institusi', $institusi->nama_institusi) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_institusi') border-red-500 @enderror" placeholder="Masukkan nama institusi">
                            @error('nama_institusi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jenis_institusi" class="block text-sm font-medium text-gray-700 mb-2">Jenis Institusi</label>
                            <input type="text" name="jenis_institusi" id="jenis_institusi" value="{{ old('jenis_institusi', $institusi->jenis_institusi) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jenis_institusi') border-red-500 @enderror" placeholder="Contoh: Universitas / Perusahaan">
                            @error('jenis_institusi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nomor_identitas" class="block text-sm font-medium text-gray-700 mb-2">Nomor Identitas</label>
                            <input type="text" name="nomor_identitas" id="nomor_identitas" value="{{ old('nomor_identitas', $institusi->nomor_identitas) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nomor_identitas') border-red-500 @enderror" placeholder="NIM / NIK / No. Registrasi">
                            @error('nomor_identitas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $institusi->no_hp) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('no_hp') border-red-500 @enderror" placeholder="Masukkan nomor telepon">
                            @error('no_hp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                            <input type="text" name="fakultas" id="fakultas" value="{{ old('fakultas', $institusi->fakultas) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="departemen" class="block text-sm font-medium text-gray-700 mb-2">Departemen</label>
                            <input type="text" name="departemen" id="departemen" value="{{ old('departemen', $institusi->departemen) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" placeholder="Masukkan email">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-lock mr-3"></i>Ubah Password
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">Kosongkan field password jika tidak ingin mengubah password.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                            <input type="password" name="current_password" id="current_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="password" id="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="button" id="btn-submit"
                    class="inline-flex items-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="confirm-modal" style="display:none; position:fixed; inset:0; z-index:50; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mx-auto mb-4">
            <i class="fas fa-question-circle text-blue-600 text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Simpan Perubahan?</h3>
        <p class="text-gray-500 text-sm mb-6">Apakah Anda yakin ingin menyimpan perubahan pada profil institusi?</p>
        <div class="flex gap-3">
            <button id="btn-cancel" type="button"
                class="flex-1 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition-all duration-200">
                <i class="fas fa-times mr-2"></i>Tidak
            </button>
            <button id="btn-confirm" type="button"
                class="flex-1 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-all duration-200">
                <i class="fas fa-check mr-2"></i>Ya, Simpan
            </button>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('confirm-modal');
    const form  = document.getElementById('institusi-form');

    document.getElementById('btn-submit').addEventListener('click', function() {
        modal.style.display = 'flex';
    });

    document.getElementById('btn-cancel').addEventListener('click', function() {
        modal.style.display = 'none';
    });

    document.getElementById('btn-confirm').addEventListener('click', function() {
        modal.style.display = 'none';
        form.submit();
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) modal.style.display = 'none';
    });
</script>
@endsection
