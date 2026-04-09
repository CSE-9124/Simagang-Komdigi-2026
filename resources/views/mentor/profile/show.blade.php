@extends('layouts.app')

@section('title', 'Profile - Sistem Manajemen Magang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">Profile Mentor</h1>
                    <p class="text-gray-600 mt-1">Informasi profil Anda</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('mentor.profile.edit') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </a>
                    <a href="{{ route('mentor.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
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

        <!-- Profile Info -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-user mr-3"></i>Informasi Profil
                </h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Photo -->
                    <div class="md:col-span-2 flex justify-center mb-6">
                        <div class="relative">
                            @if($mentor->photo_path)
                                <img src="{{ asset('storage/' . $mentor->photo_path) }}" alt="Profile Photo" class="w-32 h-32 rounded-full object-cover border-4 border-blue-200">
                            @else
                                <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center border-4 border-blue-200">
                                    <i class="fas fa-user text-blue-600 text-4xl"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $mentor->name }}</span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $user->email }}</span>
                        </div>
                    </div>

                    <!-- Position -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Posisi</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $mentor->position ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $mentor->phone ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Team -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tim</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="text-gray-900">{{ $mentor->team ? $mentor->team->name : '-' }}</span>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg border">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $mentor->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas {{ $mentor->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-2"></i>
                                {{ $mentor->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection