@extends('layouts.app')

@section('title', 'Detail Laporan - Sistem Magang')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Laporan Akhir</h1>
            <a href="{{ route('admin.report.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Anak Magang</label>
                <p class="text-lg text-gray-900">{{ $report->intern->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama File</label>
                <p class="text-lg text-gray-900">{{ $report?->file_name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Upload</label>
                <p class="text-lg text-gray-900">{{ $report->submitted_at->format('d F Y H:i') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    @if($report->status == 'approved') bg-green-100 text-green-800
                    @elseif($report->status == 'rejected') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800
                    @endif">
                    {{ ucfirst($report->status) }}
                </span>
                @if($report->needs_revision)
                    <span class="ml-2 px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                        Perlu Revisi
                    </span>
                @endif
            </div>

            @if($report->grade)
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nilai</label>
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold 
                            @if($report->grade == 'A') text-green-600
                            @elseif($report->grade == 'B') text-blue-600
                            @else text-yellow-600
                            @endif">
                            {{ $report->grade }}
                        </span>
                        @if($report->score)
                            <span class="text-gray-600">(Score: {{ $report->score }})</span>
                        @endif
                    </div>
                </div>
            @endif

            @if($report->admin_note)
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Catatan Admin</label>
                    <div class="p-4 bg-gray-50 rounded-lg border">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $report->admin_note }}</p>
                    </div>
                </div>
            @endif

            <div>
                <a href="{{ route('download', ['path' => $report->file_path]) }}" target="_blank" 
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-download mr-2"></i>Download Laporan
                </a>
            </div>

            @php
                $projectFilesDisplay = $report->project_files ?? null;
                $projectLinksDisplay = $report->project_links ?? null;
            @endphp

            @if((!empty($projectFilesDisplay) && is_array($projectFilesDisplay)) || (!empty($projectLinksDisplay) && is_array($projectLinksDisplay)) || $report->project_file || $report->project_link)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Proyek</label>
                    <div class="space-y-3">
                        @if(!empty($projectFilesDisplay) && is_array($projectFilesDisplay))
                            @foreach($projectFilesDisplay as $pf)
                                <div>
                                    <p class="text-sm text-gray-700 font-medium">File Proyek {{ $loop->iteration }}: {{ data_get($pf,'name') ?? basename(data_get($pf,'path','')) }}</p>
                                    <a href="{{ route('download', ['path' => data_get($pf,'path')]) }}" target="_blank" class="inline-block mt-2 bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded">
                                        <i class="fas fa-file-archive mr-2"></i>Download File Proyek
                                    </a>
                                </div>
                            @endforeach
                        @elseif($report->project_file)
                            <div>
                                <p class="text-sm text-gray-700 font-medium">File Proyek: {{ $report?->project_file_name ?? basename($report?->project_file ?? '') }}</p>
                                <a href="{{ route('download', ['path' => $report->project_file]) }}" target="_blank" class="inline-block mt-2 bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded">
                                    <i class="fas fa-file-archive mr-2"></i>Download File Proyek
                                </a>
                            </div>
                        @endif

                        @if(!empty($projectLinksDisplay) && is_array($projectLinksDisplay))
                            @foreach($projectLinksDisplay as $pl)
                                @if(!empty($pl))
                                <div>
                                    <p class="text-sm text-gray-700 font-medium">Link Proyek {{ $loop->iteration }}</p>
                                    <a href="{{ $pl }}" target="_blank" rel="noopener" class="inline-block mt-2 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded">
                                        <i class="fas fa-external-link-alt mr-2"></i>Buka Link Proyek
                                    </a>
                                </div>
                                @endif
                            @endforeach
                        @elseif($report->project_link)
                            <div>
                                <p class="text-sm text-gray-700 font-medium">Link Proyek</p>
                                <a href="{{ $report->project_link }}" target="_blank" rel="noopener" class="inline-block mt-2 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded">
                                    <i class="fas fa-external-link-alt mr-2"></i>Buka Link Proyek
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($report->activities && count($report->activities))
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Kegiatan Selama Magang</label>
                    <div class="space-y-2">
                        @foreach($report->activities as $activity)
                            <div class="p-3 bg-gray-50 rounded border">
                                <p class="text-gray-900">{{ $activity['description'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.report.update-status', $report) }}" class="mt-6">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $report->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="revised" {{ $report->needs_revision ? 'selected' : '' }}>Perlu Revisi</option>
                        <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Note: Pemberian nilai dilakukan oleh mentor</p>
                </div>

                <div class="mb-4">
                    <label for="admin_note" class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                    <textarea name="admin_note" id="admin_note" rows="5" 
                        placeholder="Berikan catatan, feedback, atau poin revisi jika diperlukan..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('admin_note', $report->admin_note) }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Jika perlu revisi, tuliskan poin-poin yang perlu diperbaiki di catatan ini</p>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Simpan Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
