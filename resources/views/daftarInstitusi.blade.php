<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pendaftaran Institusi - Simagang</title>
    <link rel="shortcut icon" href="{{ url('storage/vendor/icon-komdigi.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 min-h-screen p-5">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-6 mb-6">
                <div>
                    <h1 class="text-3xl pb-1 font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Daftar Institusi
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Tambahkan institusi baru untuk keperluan magang dan kerjasama dengan Komdigi.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <form method="POST" action="{{ route('admin.intern.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="p-8 bg-gray-50 border-b">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-building text-blue-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-blue-900">Informasi Institusi</h2>
                                <p class="text-sm text-gray-600">Data institusi </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1">
                            <div>
                                <label class="text-sm font-medium text-blue-900 mb-2">Nama Institusi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_institusi" value="{{ old('nama_institusi') }}"
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('nama_institusi')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="mt-4">
                                <label class="text-sm font-medium text-blue-900 mb-2">
                                    Nomor Identitas (NPSN/Kode PT) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nomor_identitas" value="{{ old('nomor_identitas') }}" required
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('nomor_identitas')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="mt-4">
                                <label class="text-sm font-medium text-blue-900 mb-2">
                                    Jenis Institusi <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis_institusi" required
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih</option>
                                    <option value="Sekolah" {{ old('jenis_institusi')=='Sekolah'?'selected':'' }}>Sekolah</option>
                                    <option value="Kampus" {{ old('jenis_institusi')=='Kampus'?'selected':'' }}>Kampus</option>
                                </select>
                                @error('jenis_institusi')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                        </div>
                    </div>
                    <div class="p-8 border-b">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-blue-900">Informasi Pribadi Admin</h2>
                                <p class="text-sm text-gray-600">Data diri dan kontak admin institusi untuk informasi lebih lanjut</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1">
                            <div>
                                <label class="text-sm font-medium text-blue-900 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('nama_admin') }}" required
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('nama_admin')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="mt-4">
                                <label class="text-sm font-medium text-blue-900 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('email')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="mt-4">
                                <label class="text-sm font-medium text-blue-900 mb-2">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('no_hp')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-shield-alt text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-blue-900">Keamanan & Status</h2>
                            <p class="text-sm text-gray-600">Pengaturan password dan status aktif</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-blue-900 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" required
                                class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                    focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('password')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-blue-900 mb-2">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center mt-1 w-full bg-blue-50 rounded-xl px-4 py-3.5 border border-gray-300">
                                <input value="Admin Institusi" type="text" disabled
                                    class="w-full bg-transparent focus:outline-none text-gray-700 font-medium">
                            </div>
                        </div>
                    </div>
                </div>

        
                <div class="px-8 py-6 bg-gray-50 flex flex-col-reverse md:flex-row md:items-center md:justify-between gap-4">
                    <a href="{{ route('landing') }}" class="inline-flex justify-center md:justify-start items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
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
</body>
</html>