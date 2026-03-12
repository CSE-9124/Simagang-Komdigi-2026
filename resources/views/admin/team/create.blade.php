@extends('layouts.app')

@section('title', 'Tambah Tim - Sistem Manajemen Magang')

@section('content')
<div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 min-h-screen p-5">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-6 mb-6">
            <div>
                <h1 class="text-3xl pb-1 font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Tambah Tim
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Tambahkan data Tim baru
                </p>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <form method="POST" action="{{ route('admin.team.store') }}" class="space-y-6">
                @csrf

                <div class="p-8 border-b">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-blue-900">Identitas Tim</h2>
                            <p class="text-sm text-gray-600">Masukkan nama tim</p>
                        </div>
                    </div>
        
                    <div class="p-8">
                        <div>
                            <label for="name" class="block text-sm font-medium text-blue-900 mb-2">
                                Nama Tim <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-gray-50 flex flex-col-reverse md:flex-row md:items-center md:justify-between gap-4">

                    <a href="{{ route('admin.team.index') }}"
                    class="inline-flex justify-center md:justify-start items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transition transform hover:scale-105">
                        <i class="fas fa-save"></i>
                        Simpan Data
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection


