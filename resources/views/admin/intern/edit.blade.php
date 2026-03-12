@extends('layouts.app')

@section('title', 'Edit Anak Magang - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-blue-600 shadow-lg rounded-lg p-6 mt-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-1">Edit Anak Magang</h1>
                        <p class="text-blue-100 text-sm">Perbarui informasi data anak magang</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white shadow-lg rounded-lg border-t-4 border-blue-500">
                <form method="POST" action="{{ route('admin.intern.update', $intern) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="p-8 border-b border-gray-200">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 rounded-full p-3 mr-4">
                                <i class="fas fa-user text-2xl text-blue-600"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-blue-900">Informasi Pribadi</h2>
                                <p class="text-sm text-gray-600">Data diri dan kontak anak magang</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-bold text-blue-900 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $intern->name) }}"
                                    required
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-bold text-blue-900 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $intern->user->email) }}" required
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="contoh@email.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-bold text-blue-900 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select name="gender" id="gender" required
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki"
                                        {{ old('gender', $intern->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="Perempuan"
                                        {{ old('gender', $intern->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @error('gender')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-bold text-blue-900 mb-2">
                                    Nomor Telepon
                                </label>
                                <input type="text" name="phone" id="phone"
                                    value="{{ old('phone', $intern->phone) }}"
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="p-8 border-b border-gray-200 bg-blue-50 bg-opacity-30">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 rounded-full p-3 mr-4">
                                <i class="fas fa-graduation-cap text-2xl text-blue-600"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-blue-900">Informasi Akademik</h2>
                                <p class="text-sm text-gray-600">Data pendidikan dan institusi</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="education_level" class="block text-sm font-bold text-blue-900 mb-2">
                                    Jenjang Pendidikan <span class="text-red-500">*</span>
                                </label>
                                <select name="education_level" id="education_level" required
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">Pilih Jenjang</option>
                                    <option value="SMA/SMK"
                                        {{ old('education_level', $intern->education_level) == 'SMA/SMK' ? 'selected' : '' }}>
                                        SMA/SMK</option>
                                    <option value="S1/D4"
                                        {{ old('education_level', $intern->education_level) == 'S1/D4' ? 'selected' : '' }}>
                                        S1/D4</option>
                                </select>
                                @error('education_level')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="major" class="block text-sm font-bold text-blue-900 mb-2">
                                    Jurusan
                                </label>
                                <input type="text" name="major" id="major"
                                    value="{{ old('major', $intern->major) }}"
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Masukkan jurusan">
                                @error('major')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="institution" class="block text-sm font-bold text-blue-900 mb-2">
                                    Institusi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="institution" id="institution"
                                    value="{{ old('institution', $intern->institution) }}" required
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Masukkan nama institusi/kampus/sekolah">
                                @error('institution')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="purpose" class="block text-sm font-bold text-blue-900 mb-2">
                                    Keperluan
                                </label>
                                <select name="purpose" id="purpose"
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">Pilih Keperluan (Opsional)</option>
                                    <option value="Magang"
                                        {{ old('purpose', $intern->purpose) == 'Magang' ? 'selected' : '' }}>Magang
                                    </option>
                                    <option value="KKN Profesi"
                                        {{ old('purpose', $intern->purpose) == 'KKN Profesi' ? 'selected' : '' }}>KKN
                                        Profesi</option>
                                    <option value="PKL"
                                        {{ old('purpose', $intern->purpose) == 'PKL' ? 'selected' : '' }}>PKL</option>
                                    <option value="Praktek Industri"
                                        {{ old('purpose', $intern->purpose) == 'Praktek Industri' ? 'selected' : '' }}>
                                        Praktek Industri</option>
                                    <option value="Magang Industri"
                                        {{ old('purpose', $intern->purpose) == 'Magang Industri' ? 'selected' : '' }}>
                                        Magang Industri</option>
                                    <option value="Guru Magang Industri"
                                        {{ old('purpose', $intern->purpose) == 'Guru Magang Industri' ? 'selected' : '' }}>
                                        Guru Magang Industri</option>
                                    <option value="Job on Training"
                                        {{ old('purpose', $intern->purpose) == 'Job on Training' ? 'selected' : '' }}>Job
                                        on Training</option>
                                </select>
                                @error('purpose')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="p-8 border-b border-gray-200">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 rounded-full p-3 mr-4">
                                <i class="fas fa-users text-2xl text-blue-600"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-blue-900">Penempatan</h2>
                                <p class="text-sm text-gray-600">Mentor dan tim yang ditugaskan</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="mentor_id" class="block text-sm font-bold text-blue-900 mb-2">
                                    Mentor
                                </label>
                                <select name="mentor_id" id="mentorSelect"
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm
                                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">

                                    <option value="">Pilih Mentor (Opsional)</option>

                                    @foreach ($mentors as $mentor)
                                        <option value="{{ $mentor->id }}"
                                            data-team="{{ $mentor->team?->name ?? 'Belum masuk dalam tim' }}"
                                            {{ old('mentor_id', $intern->mentor_id) == $mentor->id ? 'selected' : '' }}>
                                            {{ $mentor->name }}
                                            @if ($mentor->position)
                                                - {{ $mentor->position }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('mentor_id')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="team" class="block text-sm font-bold text-blue-900 mb-2">
                                    TIM
                                </label>
                                <input type="text"
                                        id="teamDisplay"
                                        readonly
                                        value="{{ $intern->mentor?->team?->name ?? 'Belum masuk dalam tim' }}"
                                        class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm
                                            bg-blue-50 text-gray-700 cursor-not-allowed">
                                @error('team')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="p-8 border-b border-gray-200 bg-blue-50 bg-opacity-30">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 rounded-full p-3 mr-4">
                                <i class="fas fa-calendar-alt text-2xl text-blue-600"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-blue-900">Foto & Periode Magang</h2>
                                <p class="text-sm text-gray-600">Upload foto dan tentukan periode magang</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if ($intern->photo_path)
                                <div>
                                    <label class="block text-sm font-bold text-blue-900 mb-2">Foto Saat Ini</label>
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ url('storage/' . $intern->photo_path) }}" alt="Current photo"
                                            class="w-32 h-32 rounded-full object-cover border-4 border-blue-300 shadow-lg">
                                        <div class="text-sm text-gray-600">
                                            <p class="font-semibold">Foto profil tersimpan</p>
                                            <p class="text-xs">Upload foto baru untuk menggantinya</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="{{ $intern->photo_path ? '' : 'md:col-span-2' }}">
                                <label for="photo" class="block text-sm font-bold text-blue-900 mb-2">
                                    {{ $intern->photo_path ? 'Ganti Pass Foto' : 'Pass Foto' }}
                                    @if (!$intern->photo_path)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <div class="relative">
                                    <input type="file" name="photo" id="photo" accept="image/*"
                                        {{ !$intern->photo_path ? 'required' : '' }}
                                        class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG, JPEG (Max 2MB)</p>
                                </div>
                                @error('photo')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="start_date" class="block text-sm font-bold text-blue-900 mb-2">
                                    Tanggal Masuk <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ old('start_date', $intern->start_date->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                @error('start_date')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-bold text-blue-900 mb-2">
                                    Tanggal Keluar <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="end_date" id="end_date"
                                    value="{{ old('end_date', $intern->end_date->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                @error('end_date')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
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
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-2">
                                    Status Aktif
                                </label>
                                <div class="flex items-center h-12 bg-blue-50 rounded-lg px-4 border-2 border-blue-200">
                                    <label for="is_active" class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                            {{ old('is_active', $intern->is_active) ? 'checked' : '' }}
                                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="ml-3 text-sm font-semibold text-gray-700">Tandai sebagai aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-8 py-6 bg-gray-50 flex flex-col-reverse md:flex-row md:items-center md:justify-between gap-4">
                        <a href="{{ route('admin.intern.index') }}"
                            class="inline-flex justify-center md:justify-start items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transition transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const mentorSelect = document.getElementById('mentorSelect');
            const teamDisplay = document.getElementById('teamDisplay');

            function updateTeam() {
                const selected = mentorSelect.options[mentorSelect.selectedIndex];

                if (!mentorSelect.value) {
                    teamDisplay.value = "Belum masuk dalam tim";
                    return;
                }

                teamDisplay.value = selected.getAttribute('data-team');
            }

            mentorSelect.addEventListener('change', updateTeam);
            document.addEventListener('DOMContentLoaded', updateTeam);
        </script>
    @endpush
@endsection
