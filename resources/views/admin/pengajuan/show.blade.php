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

                <a href="#"
                class="inline-flex items-center gap-2 bg-white text-blue-700 font-semibold px-4 py-2 rounded-lg shadow">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
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
                    <form method="POST" action="{{ route('admin.pengajuan.update-status', $pengajuan) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                Status Pengajuan Calon Anak Magang
                            </label>
                            <select name="status" id="status" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                {{-- <option value="pending" {{ $pengajuan->status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option> --}}
                                <option value="approved" {{ $pengajuan->status == 'approved' ? 'selected' : '' }}>
                                    Approved
                                </option>
                                {{-- <option value="revised" {{ $pengajuan->needs_revision ? 'selected' : '' }}>
                                    Perlu Revisi
                                </option> --}}
                                <option value="rejected" {{ $pengajuan->status == 'rejected' ? 'selected' : '' }}>
                                    Rejected
                                </option>
                            </select>
                            <p class="mt-2 text-sm text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-2 mt-0.5 text-blue-500"></i>
                                <span>Perbarui status pengajuan magang sesuai dengan keputusan Anda</span>
                            </p>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-gray-200">
                            <button type="submit" 
                                class="w-full inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white justify-center font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                Simpan Status
                            </button>

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