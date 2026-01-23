@extends('layouts.app')

@section('title', 'Laporan Akhir - Sistem Magang')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Laporan Akhir</h1>

        @if($report)
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">

            {{-- Header --}}
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm text-gray-600">
                        Diupload pada: {{ $report->submitted_at->format('d F Y H:i') }}
                    </p>
                </div>
                <div class="flex flex-col items-end space-y-2">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($report->status == 'approved') bg-green-100 text-green-800
                        @elseif($report->status == 'rejected') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucfirst($report->status) }}
                    </span>

                    @if($report->needs_revision)
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                        <i class="fas fa-exclamation-triangle mr-1"></i>Perlu Revisi
                    </span>
                    @endif

                    @if($report->grade)
                    <span class="px-3 py-1 rounded-full text-lg font-bold
                        @if($report->grade == 'A') bg-green-100 text-green-800
                        @elseif($report->grade == 'B') bg-blue-100 text-blue-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        Nilai: {{ $report->grade }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- DETAIL BERKAS --}}
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Detail Berkas</h3>

            <div class="space-y-3 text-sm">

                {{-- Laporan --}}
                <div class="flex items-center justify-between bg-white p-3 rounded border">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-file-pdf text-red-500 text-lg"></i>
                        <div>
                            <p class="font-medium">Laporan Akhir</p>
                            <p class="text-gray-500">{{ $report->file_name }}</p>
                        </div>
                    </div>
                    <a href="{{ url('storage/' . $report->file_path) }}" target="_blank"
                        class="text-blue-600 hover:underline font-medium">
                        Download
                    </a>
                </div>

                {{-- File Project --}}
                @if($report->project_file)
                <div class="flex items-center justify-between bg-white p-3 rounded border">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-file-archive text-gray-600 text-lg"></i>
                        <div>
                            <p class="font-medium">File Proyek</p>
                            <p class="text-gray-500">{{ basename($report->project_file) }}</p>
                        </div>
                    </div>
                    <a href="{{ url('storage/' . $report->project_file) }}" target="_blank"
                        class="text-blue-600 hover:underline font-medium">
                        Download
                    </a>
                </div>
                @endif

                {{-- Link Project --}}
                @if($report->project_link)
                <div class="flex items-center justify-between bg-white p-3 rounded border">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-link text-indigo-600 text-lg"></i>
                        <div>
                            <p class="font-medium">Link Proyek</p>
                            <a href="{{ $report->project_link }}" target="_blank"
                                class="text-indigo-600 hover:underline break-all">
                                {{ $report->project_link }}
                            </a>
                        </div>
                    </div>
                    <a href="{{ $report->project_link }}" target="_blank"
                        class="text-indigo-600 hover:underline font-medium">
                        Buka
                    </a>
                </div>
                @endif
            </div>

            {{-- Catatan Admin --}}
            @if($report->admin_note)
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-sm font-medium text-blue-900 mb-2">
                    <i class="fas fa-comment-dots mr-2"></i>Catatan Admin
                </p>
                <div class="bg-white p-3 rounded border">
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">
                        {{ $report->admin_note }}
                    </p>
                </div>
            </div>
            @endif

            {{-- Button --}}
            <div class="mt-6 flex space-x-4">
                @if($report->status !== 'approved' || $report->needs_revision)
                <button onclick="document.getElementById('uploadForm').classList.toggle('hidden')"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-upload mr-2"></i>
                    {{ $report->needs_revision ? 'Upload Revisi' : 'Update Laporan' }}
                </button>
                @endif
            </div>
        </div>

        {{-- FORM UPDATE --}}
        <form id="uploadForm" method="POST"
            action="{{ route('intern.report.update', $report) }}"
            enctype="multipart/form-data" class="hidden">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium">Upload Laporan Baru</label>
                <input type="file" name="file" required
                    class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Upload Proyek (Opsional)</label>
                <input type="file" name="project_file"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Link Proyek (Opsional)</label>
                <input type="url" name="project_link"
                    value="{{ old('project_link', $report->project_link) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                Update Laporan
            </button>
        </form>

        @else
        <div class="text-center py-12">
            <i class="fas fa-file-alt text-gray-400 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg mb-6">Anda belum mengupload laporan akhir.</p>

            <form method="POST" action="{{ route('intern.report.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-6 max-w-md mx-auto">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Laporan Akhir
                    </label>
                    <input type="file" name="file" id="file" accept=".pdf,.doc,.docx" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                        focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-gray-500">
                        Format: PDF, DOC, DOCX (Maks: 10MB)
                    </p>
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 max-w-md mx-auto">
                    <label for="project_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Proyek Akhir (opsional)
                    </label>
                    <input type="file" name="project_file" id="project_file"
                        accept=".zip,.rar,.7z,.tar,.gz"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                        focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-gray-500">
                        Format: .zip, .rar, .7z, .tar.gz (Opsional, Maks: 50MB)
                    </p>
                    @error('project_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 max-w-md mx-auto">
                    <label for="project_link" class="block text-sm font-medium text-gray-700 mb-2">
                        Link Proyek (opsional)
                    </label>
                    <input type="url" name="project_link" id="project_link"
                        placeholder="https://example.com/project"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                        focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('project_link') }}">
                    <p class="mt-1 text-sm text-gray-500">
                        Contoh: GitHub, GitHub Pages, Google Drive (Public)
                    </p>
                    @error('project_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    <i class="fas fa-upload mr-2"></i>Upload Laporan
                </button>
            </form>
        </div>
        @endif


    </div>
</div>
@endsection
