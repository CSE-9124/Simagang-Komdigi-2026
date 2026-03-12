@extends('layouts.app')

@section('title', 'Edit Mentor - Sistem Manajemen Magang')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-blue-600 shadow-lg rounded-lg p-6 mt-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white mb-1">Edit Mentor</h1>
                <p class="text-blue-100 text-sm">Perbarui informasi mentor di sini.</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg border-t-4 border-blue-500">
        <form method="POST" action="{{ route('admin.mentor.update', $mentor) }}">
            @csrf
            @method('PUT')

            <div class="p-8 border-b border-gray-200">
                <div class="flex items-center mb-6">
                    <div class="bg-blue-100 rounded-full p-3 mr-4">
                        <i class="fas fa-user text-2xl text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-blue-900">Informasi Pribadi</h2>
                        <p class="text-sm text-gray-600">Data diri dan kontak mentor</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-blue-900 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $mentor->name) }}" required
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Masukkan nama lengkap">
                        @error('name')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>
                
                    <div>
                        <label for="email" class="block text-sm font-bold text-blue-900 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $mentor->email) }}"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="contoh@email.com">
                        @error('email')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-bold text-blue-900 mb-2">
                            Jabatan
                        </label>
                        <input type="text" name="position" id="position" value="{{ old('position', $mentor->position) }}"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold text-blue-900 mb-2">
                            Telepon
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $mentor->phone) }}"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                </div>
            </div>

            <!-- Penempatan -->
            <div class="p-8 border-b">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-blue-900">Penempatan</h2>
                            <p class="text-sm text-gray-600">Tim yang ditugaskan</p>
                        </div>
                    </div>

                    <div>

                        {{-- Tim Dropdown --}}
                        <div>
                            <label class="text-sm font-medium text-blue-900 mb-2">
                                Pilih Tim <span class="text-red-500">*</span>
                            </label>

                            <select name="team_id" id="mentorSelect" required
                                class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                    focus:outline-none focus:ring-blue-500 focus:border-blue-500">

                                <option value="">Pilih Tim</option>

                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}"
                                            data-team="{{ $team->name }}"
                                            {{ old('team_id', $mentor->team_id) == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('team_id')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>  
                    </div>
                </div>
            

            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-blue-100 rounded-full p-3 mr-4">
                        <i class="fas fa-shield-alt text-2xl text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-blue-900">Keamanan & Status</h2>
                        <p class="text-sm text-gray-600">Pengaturan password dan status aktif</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-bold text-blue-900 mb-2">
                            Password Baru
                        </label>
                        <input type="password" name="password" id="password" 
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Kosongkan jika tidak ingin mengubah">
                        <p class="mt-2 text-xs text-gray-500">Minimal 8 karakter</p>
                        @error('password')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-blue-900 mb-2">Status Aktif</label>
                        <div class="flex items-center h-12 bg-blue-50 rounded-lg px-4 border-2 border-blue-200">
                            <label for="is_active" class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $mentor->is_active) ? 'checked' : '' }} 
                                    class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-3 text-sm font-semibold text-gray-700">Tandai sebagai aktif</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="flex items-center">
                <input id="is_active" name="is_active" type="checkbox" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded" {{ old('is_active', $mentor->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 block text-sm text-gray-700">Aktif</label>
            </div> --}}

            {{-- <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.mentor.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Simpan</button>
            </div> --}}
            <div class="px-8 py-6 bg-gray-50 flex flex-col-reverse md:flex-row md:items-center md:justify-between gap-4">
                <a href="{{ route('admin.mentor.index') }}" class="inline-flex justify-center md:justify-start items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transition transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


