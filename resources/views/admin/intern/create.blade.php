@extends('layouts.app')

@section('title', 'Tambah Anak Magang - Sistem Magang')

@section('content')
<div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 min-h-screen p-5">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 p-6 lg:px-8">
        
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 gap-4 mb-5">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Tambah Anak Magang
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Tambahkan data anak magang baru
                    </p>
                </div>
        
            </div>
        
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <form method="POST" action="{{ route('admin.intern.store') }}" enctype="multipart/form-data">
                    @csrf
        
                    <div class="p-8 border-b">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <h2 class="text-lg font-bold text-gray-800">Informasi Pribadi</h2>
                        </div>
        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                            focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('name')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div>
                                <label class="text-sm font-medium text-gray-600">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                            focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('email')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div>
                                <label class="text-sm font-medium text-gray-600">Jenis Kelamin *</label>
                                <select name="gender" required
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki" {{ old('gender')=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender')=='Perempuan'?'selected':'' }}>Perempuan</option>
                                </select>
                                @error('gender')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div>
                                <label class="text-sm font-medium text-gray-600">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                @error('phone')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
        
                    <div class="p-8 bg-gray-50 border-b">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-indigo-600"></i>
                            </div>
                            <h2 class="text-lg font-bold text-gray-800">Informasi Akademik</h2>
                        </div>
        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Jenjang Pendidikan *</label>
                                <select name="education_level" required
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                    <option value="">Pilih</option>
                                    <option value="SMA/SMK" {{ old('education_level')=='SMA/SMK'?'selected':'' }}>SMA/SMK</option>
                                    <option value="S1/D4" {{ old('education_level')=='S1/D4'?'selected':'' }}>S1/D4</option>
                                </select>
                                @error('education_level')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div>
                                <label class="text-sm font-medium text-gray-600">Jurusan</label>
                                <input type="text" name="major" value="{{ old('major') }}"
                                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                @error('major')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600">Institusi *</label>
                                <input type="text" name="institution" value="{{ old('institution') }}" required
                                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                @error('institution')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600">Keperluan</label>
                                <select name="purpose"
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                    <option value="">Pilih</option>
                                    @foreach(['Magang','KKN Profesi','PKL','Praktek Industri','Magang Industri','Guru Magang Industri','Job on Training'] as $p)
                                        <option value="{{ $p }}" {{ old('purpose')==$p?'selected':'' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                                @error('purpose')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
        
                    <!-- Penempatan -->
                    <div class="p-8 border-b">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <h2 class="text-lg font-bold text-gray-800">Penempatan</h2>
                        </div>
        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Mentor</label>
                                <select name="mentor_id"
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                    <option value="">Pilih Mentor</option>
                                    @foreach(\App\Models\Mentor::where('is_active', true)->orderBy('name')->get() as $mentor)
                                        <option value="{{ $mentor->id }}" {{ old('mentor_id')==$mentor->id?'selected':'' }}>
                                            {{ $mentor->name }} @if($mentor->position) - {{ $mentor->position }} @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('mentor_id')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div>
                                <label class="text-sm font-medium text-gray-600">Tim</label>
                                <select name="team"
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                    <option value="">Pilih Tim</option>
                                    @foreach([
                                        'TIM DEA','TIM GTA','TIM VSGA','TIM TA','TIM Microskill',
                                        'TIM Media (DiaPus)','TIM Tata Usaha (Umum)','FGA','Keuangan',
                                        'Tim PUSDATIN','Tim Perencanaan, Anggaran, Dan Kerja Sama',
                                        'Tim Kepegawaian, Persuratan dan Kearsipan'
                                    ] as $team)
                                        <option value="{{ $team }}" {{ old('team')==$team?'selected':'' }}>
                                            {{ $team }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('team')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
        
                
                    <div class="p-8 bg-gray-50 border-b">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-blue-600"></i>
                            </div>
                            <h2 class="text-lg font-bold text-gray-800">Foto & Periode Magang</h2>
                        </div>
        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Pass Foto *</label>
                                <input type="file" name="photo" accept="image/*" required
                                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                @error('photo')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div>
                                <label class="text-sm font-medium text-gray-600">Tanggal Masuk *</label>
                                <input type="date" name="start_date" value="{{ old('start_date') }}" required
                                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                @error('start_date')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div>
                                <label class="text-sm font-medium text-gray-600">Tanggal Keluar *</label>
                                <input type="date" name="end_date" value="{{ old('end_date') }}" required
                                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                @error('end_date')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
        
            
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-shield-alt text-blue-600"></i>
                            </div>
                            <h2 class="text-lg font-bold text-gray-800">Keamanan & Status</h2>
                        </div>
        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Password *</label>
                                <input type="password" name="password" required
                                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300">
                                @error('password')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div class="flex items-center mt-6">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="h-5 w-5 text-blue-600 rounded">
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    Tandai sebagai aktif
                                </span>
                            </div>
                        </div>
                    </div>
        
            
                    <div class="px-8 py-6 bg-gray-50 flex justify-between items-center">
                        <a href="{{ route('admin.intern.index') }}"
                        class="text-blue-600 hover:text-blue-800 font-semibold transition inline-flex items-center gap-2">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
        
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600
                                    hover:from-blue-700 hover:to-indigo-700
                                    text-white font-semibold px-8 py-3 rounded-xl shadow-lg
                                    transition transform hover:scale-105">
                            <i class="fas fa-save"></i>
                            Simpan Data
                        </button>
                    </div>
        
                </form>
            </div>
        </div>
</div>
@endsection
