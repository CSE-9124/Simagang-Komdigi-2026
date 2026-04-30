@extends('layouts.app')

@section('title', 'Profile Institusi - Sistem Manajemen Magang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">Profile Institusi</h1>
                    <p class="text-gray-600 mt-1">Informasi profil institusi Anda</p>
                </div>
                <div class="flex flex-row gap-3">
                    <a href="{{ route('institusi.dashboard') }}" class="inline-flex w-full justify-center items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-300 sm:w-auto">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <a href="{{ route('institusi.profile.edit') }}" class="inline-flex w-full justify-center items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300 sm:w-auto">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-building mr-3"></i>Informasi Institusi
                </h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Institusi -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Institusi</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $institusi->nama_institusi ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $user->name ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $user->email ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Jenis Institusi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Institusi</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $institusi->jenis_institusi ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Nomor Identitas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Identitas</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $institusi->nomor_identitas ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $institusi->no_hp ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Fakultas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $institusi->fakultas ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Departemen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Departemen</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $institusi->departemen ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Status akun -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Akun</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->is_active ?? true ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas {{ $user->is_active ?? true ? 'fa-check-circle' : 'fa-times-circle' }} mr-2"></i>
                                {{ ($user->is_active ?? true) ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
