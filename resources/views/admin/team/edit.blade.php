@extends('layouts.app')

@section('title', 'Edit Tim - Sistem Manajemen Magang')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-blue-600 shadow-lg rounded-lg p-6 mt-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white mb-1">Edit Tim</h1>
                <p class="text-blue-100 text-sm">Perbarui identitas tim di sini.</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg border-t-4 border-blue-500">
        <form method="POST" action="{{ route('admin.team.update', $team) }}">
            @csrf
            @method('PUT')

            <div class="p-8 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-blue-900">Identitas Tim</h2>
                        <p class="text-sm text-gray-600">Perbarui nama tim</p>
                    </div>
                </div>

                <div class="p-8">
                    <div>
                        <label for="name" class="block text-sm font-bold text-blue-900 mb-2">
                            Nama Tim <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Masukkan nama tim">
                        @error('name')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 bg-gray-50 flex flex-col-reverse md:flex-row md:items-center md:justify-between gap-4">
                <a href="{{ route('admin.team.index') }}" class="inline-flex justify-center md:justify-start items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
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


