@extends('layouts.app')

@section('title', 'Register - Sistem Magang')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white shadow-lg rounded-lg p-6 md:p-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Daftar Akun Anak Magang</h2>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <select name="gender" id="gender" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="education_level" class="block text-sm font-medium text-gray-700 mb-2">Jenjang Pendidikan</label>
                    <select name="education_level" id="education_level" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jenjang</option>
                        <option value="SMA/SMK" {{ old('education_level') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                        <option value="S1/D4" {{ old('education_level') == 'S1/D4' ? 'selected' : '' }}>S1/D4</option>
                    </select>
                    @error('education_level')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="major" class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                    <input type="text" name="major" id="major" value="{{ old('major') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('major')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">Institusi</label>
                    <input type="text" name="institution" id="institution" value="{{ old('institution') }}" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan nama institusi/kampus">
                    @error('institution')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">Keperluan</label>
                    <select name="purpose" id="purpose" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Keperluan (Opsional)</option>
                        <option value="Magang" {{ old('purpose') == 'Magang' ? 'selected' : '' }}>Magang</option>
                        <option value="KKN Profesi" {{ old('purpose') == 'KKN Profesi' ? 'selected' : '' }}>KKN Profesi</option>
                        <option value="PKL" {{ old('purpose') == 'PKL' ? 'selected' : '' }}>PKL</option>
                        <option value="Praktek Industri" {{ old('purpose') == 'Praktek Industri' ? 'selected' : '' }}>Praktek Industri</option>
                        <option value="Magang Industri" {{ old('purpose') == 'Magang Industri' ? 'selected' : '' }}>Magang Industri</option>
                        <option value="Guru Magang Industri" {{ old('purpose') == 'Guru Magang Industri' ? 'selected' : '' }}>Guru Magang Industri</option>
                        <option value="Job on Training" {{ old('purpose') == 'Job on Training' ? 'selected' : '' }}>Job on Training</option>
                    </select>
                    @error('purpose')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Pass Foto</label>
                    <input type="file" name="photo" id="photo" accept="image/*" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('photo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('start_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Keluar</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('end_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-500">
                    Sudah punya akun? Login di sini
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition duration-150">
                    Daftar
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
