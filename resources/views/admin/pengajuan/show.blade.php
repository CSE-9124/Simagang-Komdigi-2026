@extends('layouts.app')

@section('title', 'Detail Pengajuan Magang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="bg-blue-600 shadow-lg rounded-lg p-6 mt-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">Detail Pengajuan Magang</h1>
                    <p class="text-blue-100 text-sm">
                        Informasi pengajuan dan calon anak magang
                    </p>
                </div>
            </div>
        </div>

        <!-- CARD -->
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">

            <!-- INFORMASI MAGANG -->
            <div class="p-8 border-b">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-briefcase text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-blue-900">Informasi Pengerjaan Magang</h2>
                    </div>
                    
                    <a href="{{ asset('storage/' . $pengajuan->surat_path) }}" target="_blank"
                        class="text-blue-600 font-semibold text-right ml-auto bg-blue-100 px-3 py-1 rounded-lg">
                        <i class="fas fa-download mr-2"></i>
                        Download Surat
                    </a>
                    
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-gray-700">

                    <div>
                        <p class="text-sm text-gray-500">Tanggal Masuk</p>
                        <p class="font-semibold">{{ $pengajuan->start_date }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Tanggal Keluar</p>
                        <p class="font-semibold">{{ $pengajuan->end_date }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Keperluan</p>
                        <p class="font-semibold">{{ $pengajuan->keperluan }}</p>
                    </div>

                </div>
            </div>

            <!-- PESERTA -->
            <div class="p-8 bg-gray-50">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-blue-900">Daftar Calon Anak Magang</h2>
                    </div>
                </div>

                @foreach($pengajuan->details as $i => $peserta)
                    <div class="mb-6 bg-white p-6 rounded-xl border">

                        <h3 class="text-md font-semibold text-blue-700 mb-4">
                            Calon Anak Magang {{ $i + 1 }}
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-gray-700">

                            <div>
                                <p class="text-sm text-gray-500">Nama</p>
                                <p class="font-semibold">{{ $peserta->nama }}</p>
                            </div>

                            
                            <div>
                                <p class="text-sm text-gray-500">Jurusan</p>
                                <p class="font-semibold">{{ $peserta->jurusan }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Jenis Kelamin</p>
                                <p class="font-semibold">
                                    @if($peserta->jenis_kelamin == 'L')
                                        Laki-laki
                                    @elseif($peserta->jenis_kelamin == 'P')
                                        Perempuan
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-semibold">{{ $peserta->email }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">No Telepon</p>
                                <p class="font-semibold">{{ $peserta->no_telp }}</p>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

            {{-- Form Update Status --}}
            <div class="p-8 bg-white shadow-lg border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r rounded-t-2xl from-blue-600 to-indigo-600 px-6 py-4">
                    <div class="flex items-center bg-blue-700 bg-opacity-20">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Update Status Pengajuan</h3>
                    </div>
                </div>

                <div class="p-8 bg-gray-50 rounded-b-2xl border border-blue-100">
                    <form id="update-status-form" method="POST" action="{{ route('admin.pengajuan.update-status', $pengajuan) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                Status Pengajuan Calon Anak Magang
                            </label>
                            <select name="status" id="status" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                {{ $pengajuan->status == 'approved' ? 'disabled' : '' }}>
                                {{-- <option value="pending" {{ $pengajuan->status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option> --}}
                                <option value="approved" {{ $pengajuan->status == 'approved' ? 'selected' : '' }}>
                                    Approved
                                </option>
                                <option value="revised" {{ $pengajuan->status == 'revised' ? 'selected' : '' }}>
                                    Revisi
                                </option>
                                <option value="rejected" {{ $pengajuan->status == 'rejected' ? 'selected' : '' }}>
                                    Rejected
                                </option>
                            </select>
                            <p class="mt-2 text-sm text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-2 mt-0.5 text-blue-500"></i>
                                <span>Perbarui status pengajuan magang sesuai dengan keputusan Anda</span>
                            </p>
                        </div>

                        <div class="mb-6" id="no_surat_block">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nomor Surat Balasan
                            </label>
                            <input type="text" name="no_surat_balasan"
                                placeholder="contoh: B-747/BBPSDMP.73/UM.01.01/12/2025"
                                value="{{ old('no_surat_balasan', $pengajuan->nomor_surat_balasan ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                        </div>

                        <div class="mb-6" id="admin-note-block" style="display: {{ $pengajuan->status == 'revised' ? 'block' : 'none' }};">
                            <label for="admin_note" class="block text-sm font-semibold text-gray-700 mb-2">
                                Catatan Revisi (opsional)
                            </label>
                            <textarea name="admin_note" id="admin_note" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">{{ old('admin_note', $pengajuan->admin_note) }}</textarea>
                            <p class="mt-2 text-sm text-gray-500">
                                Tuliskan apa saja yang perlu direvisi oleh institusi/anak magang.
                            </p>
                        </div>

                        <script>
                            (function(){
                                const statusEl = document.getElementById('status');
                                const noSuratBlock = document.getElementById('no_surat_block');
                                const noteBlock = document.getElementById('admin-note-block');

                                function updateUI(value) {

                                    // NOMOR SURAT
                                    if (value === 'rejected' || value === 'revised') {
                                        noSuratBlock.style.display = 'none';
                                    } else {
                                        noSuratBlock.style.display = 'block';
                                    }

                                    // CATATAN REVISI
                                    if (value === 'revised') {
                                        noteBlock.style.display = 'block';
                                    } else {
                                        noteBlock.style.display = 'none';
                                    }
                                }

                                // trigger saat change
                                statusEl.addEventListener('change', function(e){
                                    updateUI(e.target.value);
                                });

                                // 🔥 trigger awal (PENTING)
                                updateUI(statusEl.value);

                            })();
                            </script>

                        <!-- Modal Konfirmasi (tersimpan di DOM, ditampilkan via JS) -->
                        <div id="confirm-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
                            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                            <div class="relative max-w-md w-full bg-white rounded-xl shadow-lg overflow-hidden">
                                <div class="p-6 text-center">
                                    <div class="mx-auto w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center mb-3">
                                        <span class="text-blue-600 text-xl">?</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 modal-title">Simpan Perubahan?</h3>
                                    <p class="mt-2 text-sm text-gray-500 modal-message">Apakah Anda yakin ingin menyimpan perubahan?</p>
                                </div>
                                <div class="px-4 pb-4 pt-2 bg-gray-50 flex gap-3 justify-center">
                                    <button id="confirm-cancel" type="button" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 font-semibold hover:bg-gray-100">
                                        Tidak
                                    </button>
                                    <button id="confirm-accept" type="button" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                                        Ya, Simpan
                                    </button>
                                </div>
                            </div>
                        </div>

                        <script>
                            (function(){
                                const form = document.getElementById('update-status-form');
                                const statusEl = document.getElementById('status');
                                const modal = document.getElementById('confirm-modal');
                                const modalTitle = modal.querySelector('.modal-title');
                                const modalMessage = modal.querySelector('.modal-message');
                                const btnCancel = document.getElementById('confirm-cancel');
                                const btnConfirm = document.getElementById('confirm-accept');

                                let confirmed = false;

                                function getMessage(status) {
                                    if (status === 'approved') {
                                        return {
                                            title: 'Simpan Status?',
                                            message: 'Apakah Anda yakin ingin menyimpan status? tindakan ini akan menyetujui pengajuan magang dan tidak dapat diubah kembali.'
                                        };
                                    }
                                    if (status === 'rejected') {
                                        return {
                                            title: 'Simpan Status?',
                                            message: 'Apakah Anda yakin ingin menyimpan status? tindakan ini akan menolak pengajuan magang dan tidak dapat diubah kembali.'
                                        };
                                    }
                                    return {
                                        title: 'Simpan Perubahan?',
                                        message: 'Konfirmasi: lanjutkan perubahan status?'
                                    };
                                }

                                form.addEventListener('submit', function(e){
                                    const status = statusEl.value;

                                    // langsung submit jika pilih 'revised'
                                    if (status === 'revised') {
                                        return true;
                                    }

                                    // jika sudah dikonfirmasi melalui modal, biarkan submit berjalan
                                    if (confirmed) {
                                        return true;
                                    }

                                    e.preventDefault();

                                    const info = getMessage(status);
                                    modalTitle.textContent = info.title;
                                    modalMessage.textContent = info.message;
                                    modal.classList.remove('hidden');
                                    // fokus ke tombol batal agar aksesibilitas lebih baik
                                    btnCancel.focus();
                                });

                                btnCancel.addEventListener('click', function(){
                                    modal.classList.add('hidden');
                                });

                                btnConfirm.addEventListener('click', function(){
                                    confirmed = true;
                                    modal.classList.add('hidden');
                                    // kirim form setelah menutup modal
                                    form.submit();
                                });
                            })();
                        </script>

                        <div class="flex items-center justify-end pt-4 border-gray-200">
                            @if($pengajuan->status == 'approved')
                                <button type="button" disabled
                                    class="w-full inline-flex items-center px-6 py-3 bg-gray-300 text-gray-700 justify-center font-bold rounded-xl shadow-sm transition-all duration-300">
                                    Sudah Disetujui — Tidak dapat diubah
                                </button>
                            @else
                                <button type="submit" 
                                    class="w-full inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white justify-center font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                    Simpan Status
                                </button>
                            @endif

                        </div>
                    </form>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="p-6 border-t">
                <a href="{{ route('admin.pengajuan.index') }}" 
                    class="text-blue-600 font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

        </div>
    </div>
</div>
@endsection