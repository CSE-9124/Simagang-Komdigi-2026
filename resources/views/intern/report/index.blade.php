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
                    <a href="{{ route('download', ['path' => $report->file_path]) }}" target="_blank"
                        class="text-blue-600 hover:underline font-medium">
                        Download
                    </a>
                </div>

                {{-- File Project (support multiple) --}}
                @php
                    $projectFilesDisplay = $report->project_files ?? null;
                @endphp
                @if(!empty($projectFilesDisplay) && is_array($projectFilesDisplay))
                    <div class="space-y-2">
                        <h4 class="text-sm font-medium text-gray-700">File Proyek</h4>
                        @foreach($projectFilesDisplay as $pf)
                            <div class="flex items-center justify-between bg-white p-3 rounded border">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-archive text-gray-600 text-lg"></i>
                                    <div>
                                        <p class="font-medium">File Proyek {{ $loop->iteration }}</p>
                                        <p class="text-gray-500">{{ data_get($pf, 'name') ?? basename(data_get($pf, 'path', '')) }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('download', ['path' => data_get($pf, 'path')]) }}" target="_blank"
                                    class="text-blue-600 hover:underline font-medium">Download</a>
                            </div>
                        @endforeach
                    </div>
                @elseif($report->project_file)
                    <div class="flex items-center justify-between bg-white p-3 rounded border">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file-archive text-gray-600 text-lg"></i>
                            <div>
                                <p class="font-medium">File Proyek</p>
                                <p class="text-gray-500">{{ $report->project_file_name ?? basename($report->project_file) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('download', ['path' => $report->project_file]) }}" target="_blank"
                            class="text-blue-600 hover:underline font-medium">Download</a>
                    </div>
                @endif

                {{-- Link Project (support multiple) --}}
                @php
                    $projectLinksDisplay = $report->project_links ?? null;
                @endphp
                @if(!empty($projectLinksDisplay) && is_array($projectLinksDisplay))
                    <div class="space-y-2">
                        <h4 class="text-sm font-medium text-gray-700">Link Proyek</h4>
                        @foreach($projectLinksDisplay as $pl)
                            @if(!empty($pl))
                            <div class="flex items-center justify-between bg-white p-3 rounded border">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-link text-indigo-600 text-lg"></i>
                                    <div>
                                        <p class="font-medium">Link Proyek {{ $loop->iteration }}</p>
                                        <a href="{{ $pl }}" target="_blank" class="text-indigo-600 hover:underline break-all">{{ $pl }}</a>
                                    </div>
                                </div>
                                <a href="{{ $pl }}" target="_blank" class="text-indigo-600 hover:underline font-medium">Buka</a>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @elseif($report->project_link)
                    <div class="flex items-center justify-between bg-white p-3 rounded border">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-link text-indigo-600 text-lg"></i>
                            <div>
                                <p class="font-medium">Link Proyek</p>
                                <a href="{{ $report->project_link }}" target="_blank" class="text-indigo-600 hover:underline break-all">{{ $report->project_link }}</a>
                            </div>
                        </div>
                        <a href="{{ $report->project_link }}" target="_blank" class="text-indigo-600 hover:underline font-medium">Buka</a>
                    </div>
                @endif
                
                {{-- Activities (Kegiatan Magang) --}}
                <div class="mt-4 p-4 bg-white rounded border">
                    <h4 class="font-semibold">Kegiatan Selama Magang</h4>
                    @if($report->activities && count($report->activities))
                        <div class="mt-2 space-y-2">
                            @foreach($report->activities as $activity)
                                <div class="p-3 bg-gray-50 rounded border">
                                    <p class="text-gray-900">{{ $activity['description'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-2 text-gray-500">Belum ada kegiatan yang dicatat.</p>
                    @endif
                </div>
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
                <label class="block text-sm font-medium">Laporan Saat Ini</label>
                <div class="relative">
                    <input type="text" id="fileDisplay" value="{{ $report->file_name }}" readonly
                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700 cursor-pointer"
                        onclick="document.getElementById('fileInput').click()">
                    <input type="file" name="file" id="fileInput" style="display: none;" onchange="updateFileDisplay(this)">
                    <button type="button" class="absolute right-2 top-2 text-gray-500 hover:text-gray-700" onclick="clearFile()">×</button>
                </div>
                <p class="mt-1 text-sm text-gray-500">
                    Klik untuk pilih file baru atau biarkan untuk tetap menggunakan file saat ini. 
                    <a href="{{ route('download', ['path' => $report->file_path]) }}" target="_blank" class="text-blue-600 hover:underline">Lihat file saat ini</a>
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Proyek Saat Ini (maks 3 file)</label>
                <div class="relative">
                    <input type="text" id="projectDisplay" value="{{ $report->project_file ? ($report->project_file_name ?? basename($report->project_file)) : 'Belum ada file proyek' }}" readonly
                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700 cursor-pointer"
                        onclick="document.getElementById('projectInput').click()">
                    <input type="file" name="project_files[]" id="projectInput" style="display: none;" onchange="updateProjectDisplay(this)" multiple accept=".zip,.rar,.7z,.tar,.gz">
                    <button type="button" class="absolute right-2 top-2 text-gray-500 hover:text-gray-700" onclick="clearProject()">×</button>
                </div>
                <p class="mt-1 text-sm text-gray-500">
                    Klik untuk pilih hingga 3 file baru atau biarkan untuk tetap menggunakan file saat ini.
                    @if($report->project_file)
                        <a href="{{ route('download', ['path' => $report->project_file]) }}" target="_blank" class="text-blue-600 hover:underline">Download file saat ini</a>
                    @endif
                    Format: .zip, .rar, .7z, .tar.gz (Maks: 100MB per file)
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Link Proyek (Opsional, maks 3)</label>
                @php
                    // Prefer new `project_links` array; fall back to legacy `project_link` string
                    $existingLinks = [];
                    if (!empty($report->project_links) && is_array($report->project_links)) {
                        $existingLinks = $report->project_links;
                    } elseif (!empty($report->project_link)) {
                        $existingLinks = [$report->project_link];
                    }
                @endphp
                @for($i = 0; $i < 3; $i++)
                    <input type="url" name="project_links[]"
                        value="{{ old('project_links.'.$i, data_get($existingLinks, $i, '')) }}"
                        class="w-full border rounded px-3 py-2 mb-2">
                @endfor
                <p class="mt-1 text-sm text-gray-500">Opsional: masukkan hingga 3 tautan (GitHub, Drive, Pages, dll.).</p>
            </div>

            {{-- Activities (Kegiatan Magang) --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Kegiatan Selama Magang (Opsional)</label>
                <textarea name="activities[0][description]" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsikan kegiatan harian/mingguan yang relevan untuk laporan akhir...">{{ old('activities.0.description', data_get($report, 'activities.0.description', '')) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Opsional: Masukkan ringkasan kegiatan selama magang.</p>
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
                        Upload Proyek Akhir (opsional, maks 3 file)
                    </label>
                    <input type="file" name="project_files[]" id="project_file"
                        accept=".zip,.rar,.7z,.tar,.gz" multiple
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                        focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-gray-500">
                        Format: .zip, .rar, .7z, .tar.gz (Opsional, Maks: 100MB per file, maksimal 3 file)
                    </p>
                </div>

                <div class="mb-6 max-w-md mx-auto">
                    <label for="project_link" class="block text-sm font-medium text-gray-700 mb-2">
                        Link Proyek (opsional, maks 3)
                    </label>
                    @for($i = 0; $i < 3; $i++)
                        <input type="url" name="project_links[]" id="project_link_{{ $i }}"
                            placeholder="https://example.com/project"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm mb-2
                            focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('project_links.'.$i) }}">
                    @endfor
                    <p class="mt-1 text-sm text-gray-500">
                        Contoh: GitHub, GitHub Pages, Google Drive (Public)
                    </p>
                </div>

                {{-- Activities (Kegiatan Magang) --}}
                <div class="mb-6 max-w-md mx-auto">
                    <label for="activities_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Kegiatan Selama Magang (opsional)
                    </label>
                    <textarea name="activities[0][description]" id="activities_description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                        focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Deskripsikan kegiatan harian/mingguan yang relevan untuk laporan akhir...">{{ old('activities.0.description') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">
                        Opsional: Masukkan ringkasan kegiatan selama magang.
                    </p>
                </div>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    <i class="fas fa-upload mr-2"></i>Upload Laporan
                </button>
            </form>
        </div>

        @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function(){
            // Custom file input functions
            function updateFileDisplay(input) {
                const display = document.getElementById('fileDisplay');
                if (input.files && input.files[0]) {
                    display.value = input.files[0].name;
                    display.classList.remove('text-gray-700');
                    display.classList.add('text-blue-700');
                }
            }

            function clearFile() {
                const display = document.getElementById('fileDisplay');
                const input = document.getElementById('fileInput');
                display.value = '{{ $report?->file_name }}';
                input.value = '';
                display.classList.remove('text-blue-700');
                display.classList.add('text-gray-700');
            }

            function updateProjectDisplay(input) {
                const display = document.getElementById('projectDisplay');
                if (!display) return;
                if (input.files && input.files.length) {
                    if (input.files.length > 3) {
                        alert('Maksimal 3 file proyek. Silakan pilih ulang.');
                        input.value = '';
                        return;
                    }
                    const names = Array.from(input.files).map(f => f.name).join(', ');
                    display.value = names;
                    display.classList.remove('text-gray-700', 'text-gray-500');
                    display.classList.add('text-blue-700');
                }
            }

            function clearProject() {
                const display = document.getElementById('projectDisplay');
                const inputUpdate = document.getElementById('projectInput');
                const inputCreate = document.getElementById('project_file');
                const orig = '{{ $report?->project_file ? ($report?->project_file_name ?? basename($report?->project_file)) : 'Belum ada file proyek' }}';
                if (display) display.value = orig;
                if (inputUpdate) inputUpdate.value = '';
                if (inputCreate) inputCreate.value = '';
                if (display) {
                    display.classList.remove('text-blue-700');
                    display.classList.add('text-gray-700');
                }
            }

            // Attach to global if elements exist
            const fileInput = document.getElementById('fileInput');
            const projectInput = document.getElementById('projectInput');
            const projectCreateInput = document.getElementById('project_file');
            if (fileInput) {
                fileInput.addEventListener('change', function() { updateFileDisplay(this); });
            }
            if (projectInput) {
                projectInput.addEventListener('change', function() { updateProjectDisplay(this); });
            }
            if (projectCreateInput) {
                projectCreateInput.addEventListener('change', function() { updateProjectDisplay(this); });
            }

            // Clear buttons
            const clearFileBtn = document.querySelector('button[onclick="clearFile()"]');
            const clearProjectBtn = document.querySelector('button[onclick="clearProject()"]');
            if (clearFileBtn) clearFileBtn.addEventListener('click', clearFile);
            if (clearProjectBtn) clearProjectBtn.addEventListener('click', clearProject);
        });
        </script>
        @endpush

        @endif


    </div>
</div>

@endsection
