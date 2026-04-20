@extends('layouts.app')

@section('title', 'Tambah Pengajuan Magang - Sistem Magang')

@section('content')
<div class="min-h-screen bg-blue-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold leading-tight text-blue-600 mb-2 pb-2">
                Tambah Pengajuan Magang
            </h1>
            <p class="text-gray-600">Ajukan permohonan magang Anda dengan lengkap</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-edit mr-3"></i>
                    Form Pengajuan Magang
                </h2>
            </div>

            <div class="p-8">
               <form method="POST" action="{{ route('institusi.pengajuan.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="p-8 border-b">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-briefcase text-blue-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-blue-900">Informasi Pengerjaan Magang</h2>
                                <p class="text-sm text-gray-600">Isi informasi periode magang, tujuan kegiatan, dan unggah surat pengajuan.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal Field -->
                            <div>
                                <label class="text-sm font-medium text-blue-900 mb-2">
                                    Tanggal Masuk <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="start_date" value="{{ old('start_date') }}" required
                                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                        focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('start_date')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div>
                                <label class="text-sm font-medium text-blue-900 mb-2">Tanggal Keluar <span class="text-red-500">*</span></label>
                                <input type="date" name="end_date" value="{{ old('end_date') }}" required
                                    class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                        focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('end_date')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
        
                            <div class="md:col-span-2">
                                    <label class="text-sm font-medium text-blue-900 mb-2">Keperluan</label>
                                    <select name="keperluan" required
                                            class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                                focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="{{ old('keperluan') }}">{{ old('keperluan') ?: 'Pilih' }}</option>
                                        @foreach(['Magang','KKN Profesi','PKL','Praktek Industri','Magang Industri','Guru Magang Industri','Job on Training'] as $p)
                                            <option value="{{ $p }}" {{ old('keperluan')==$p?'selected':'' }}>{{ $p }}</option>
                                        @endforeach
                                    </select>
                                    @error('keperluan')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
        
                            <!-- Surat Magang Field -->
                            <div class="mb-6">
                                <label for="surat_magang" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Surat Magang (.pdf) <span class="text-red-500">*</span>
                                </label>
                                <input type="file" name="surat_magang" id="surat_magang" accept=".pdf,.doc,.docx" required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                @error('surat_magang')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- informasi calon anak magang --}}
                    <div class="p-8 border-b bg-gray-50">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-blue-900">Informasi Calon Anak Magang</h2>
                                <p class="text-sm text-gray-600">Isi data dan kontak calon anak magang</p>
                            </div>
                        </div>

                        <div id="intern-container">

                            <!-- CARD 1 -->
                            <div class="intern-card mb-6">

                                <h3 class="text-md font-semibold text-blue-700 mb-4 peserta-title">
                                    Calon Anak Magang 1
                                </h3>

                                <div class="mb-6">
                                    <label class="text-sm font-medium text-blue-900 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name[]" required
                                        class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm
                                        focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="text-sm font-medium text-blue-900 mb-2">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="email[]" required
                                            class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    <div>
                                        <label class="text-sm font-medium text-blue-900 mb-2">
                                            Jurusan <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="jurusan[]" required
                                            class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>

                                    <div>
                                        <label class="text-sm font-medium text-blue-900 mb-2">
                                            Jenis Kelamin <span class="text-red-500">*</span>
                                        </label>
                                        <select name="jenis_kelamin[]" required
                                            class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Pilih</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm font-medium text-blue-900 mb-2">
                                            Nomor Telepon <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="no_telp[]" required
                                            class="mt-1 w-full px-4 py-3 rounded-xl border border-gray-300
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="flex items-center justify-between mt-4 mb-6">
                        <span class="text-sm text-gray-500" id="count-info">1 peserta ditambahkan</span>
                        <button type="button" onclick="addIntern()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-all">
                            <i class="fas fa-plus mr-2"></i> Tambah Peserta
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('institusi.pengajuan.index') }}" 
                            class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali 
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 w-full sm:w-auto justify-center">
                            <i class="fas fa-save mr-2"></i>Simpan Logbook
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    let count = 1;

    function updateTitles() {
        const cards = document.querySelectorAll('.intern-card');
        cards.forEach((card, index) => {
            card.querySelector('.peserta-title').innerText = 'Calon Anak Magang ' + (index + 1);
        });
        document.getElementById('count-info').innerText = cards.length + ' calon anak magang ditambahkan';
    }

    function addIntern() {
        const container = document.getElementById('intern-container');
        const firstCard = container.querySelector('.intern-card');

        const newCard = firstCard.cloneNode(true);

        // reset semua input
        newCard.querySelectorAll('input').forEach(input => input.value = '');
        newCard.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

        container.appendChild(newCard);

        count++;
        document.getElementById('count-info').innerText = count + ' peserta ditambahkan';

        updateTitles();
    }
</script>
@endsection