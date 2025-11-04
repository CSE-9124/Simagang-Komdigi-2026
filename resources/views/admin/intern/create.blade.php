@extends('layouts.app')

@section('title', 'Tambah Anak Magang - Sistem Magang')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Tambah Anak Magang</h1>

        <form method="POST" action="{{ route('admin.intern.store') }}" enctype="multipart/form-data" class="space-y-6">
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
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">NIM/NIS</label>
                    <input type="text" name="student_id" id="student_id" value="{{ old('student_id') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('student_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">Institusi</label>
                    <input type="text" name="institution" id="institution" value="{{ old('institution') }}" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan nama institusi/kampus">
                    @error('institution')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="mentor_id" class="block text-sm font-medium text-gray-700 mb-2">Mentor</label>
                    <select name="mentor_id" id="mentor_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Mentor (Opsional)</option>
                        @foreach(\App\Models\Mentor::where('is_active', true)->orderBy('name')->get() as $mentor)
                            <option value="{{ $mentor->id }}" {{ old('mentor_id') == $mentor->id ? 'selected' : '' }}>
                                {{ $mentor->name }} @if($mentor->position) - {{ $mentor->position }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('mentor_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="team" class="block text-sm font-medium text-gray-700 mb-2">TIM</label>
                    <select name="team" id="team" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih TIM (Opsional)</option>
                        <option value="TIM DEA" {{ old('team') == 'TIM DEA' ? 'selected' : '' }}>TIM DEA</option>
                        <option value="TIM GTA" {{ old('team') == 'TIM GTA' ? 'selected' : '' }}>TIM GTA</option>
                        <option value="TIM VSGA" {{ old('team') == 'TIM VSGA' ? 'selected' : '' }}>TIM VSGA</option>
                        <option value="TIM TA" {{ old('team') == 'TIM TA' ? 'selected' : '' }}>TIM TA</option>
                        <option value="TIM Microskill" {{ old('team') == 'TIM Microskill' ? 'selected' : '' }}>TIM Microskill</option>
                        <option value="TIM Media" {{ old('team') == 'TIM Media' ? 'selected' : '' }}>TIM Media</option>
                        <option value="TIM Tata Usaha" {{ old('team') == 'TIM Tata Usaha' ? 'selected' : '' }}>TIM Tata Usaha</option>
                    </select>
                    @error('team')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
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
                    <label for="is_active" class="flex items-center mt-6">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} 
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.intern.index') }}" class="text-blue-600 hover:text-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
