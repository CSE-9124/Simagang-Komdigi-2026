@extends('layouts.app')

@section('title', 'Detail Laporan Akhir - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1
                        class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                        Detail Laporan Akhir
                    </h1>
                    <p class="text-gray-600">Review dan berikan penilaian untuk laporan akhir</p>
                </div>
                <a href="{{ route('mentor.report.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 shadow-md hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden mb-6">
                
                <div class="bg-blue-600 px-6 py-6">
                    <div class="flex items-center">
                        @if ($report->intern->photo_path)
                            <img src="{{ url('storage/' . $report->intern->photo_path) }}"
                                class="w-16 h-16 rounded-full object-cover border-4 border-white shadow-lg mr-4"
                                alt="{{ $report->intern->name }}" />
                        @else
                            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-user text-blue-600 text-2xl"></i>
                            </div>
                        @endif
                        <div class="text-white">
                            <h2 class="text-2xl font-bold">{{ $report->intern->name }}</h2>
                            <p class="text-blue-100 flex items-center mt-1">
                                <i class="fas fa-university mr-2"></i>
                                {{ $report->intern->institution }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-6">
                    <!-- File Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Nama File</p>
                                <p class="text-sm font-semibold text-gray-900 break-all">{{ $report?->file_name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Tanggal Upload</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $report->submitted_at ? $report->submitted_at->format('d F Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-info-circle text-green-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Status</p>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-medium
                                    @if ($report->status == 'approved') bg-green-100 text-green-800
                                    @elseif($report->status == 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                        @if ($report->status == 'approved')
                                            ✓ Approved
                                        @elseif($report->status == 'rejected')
                                            ✗ Rejected
                                        @else
                                            ⏳ Pending
                                        @endif
                                    </span>
                                    @if ($report->needs_revision)
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                            ⚠️ Perlu Revisi
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($report->grade)
                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-star text-blue-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Nilai</p>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="text-4xl font-bold 
                                        @if ($report->grade == 'A') text-green-600
                                        @elseif($report->grade == 'B') text-blue-600
                                        @else text-yellow-600 @endif">
                                            {{ $report->grade }}
                                        </span>
                                        @if ($report->score)
                                            <span class="text-lg text-gray-600">({{ $report->score }})</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($report->admin_note)
                        <div>
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-sticky-note text-gray-600"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Catatan</h3>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $report->admin_note }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="pt-4 border-t border-gray-200">
                        <a href="{{ route('download', ['path' => $report->file_path]) }}" target="_blank"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-download mr-2"></i>
                            Download Laporan
                        </a>
                    </div>

                    @php
                        $projectFilesDisplay = $report->project_files ?? null;
                        $projectLinksDisplay = $report->project_links ?? null;
                    @endphp

                    @if (
                        (!empty($projectFilesDisplay) && is_array($projectFilesDisplay)) ||
                            (!empty($projectLinksDisplay) && is_array($projectLinksDisplay)) ||
                            $report->project_file ||
                            $report->project_link)
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-project-diagram text-blue-600"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Proyek</h3>
                            </div>
                            <div class="space-y-4">
                                @if (!empty($projectFilesDisplay) && is_array($projectFilesDisplay))
                                    @foreach ($projectFilesDisplay as $pf)
                                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                            <p class="text-sm text-gray-700 font-medium mb-2">
                                                <i class="fas fa-file-archive text-gray-500 mr-2"></i>
                                                File Proyek {{ $loop->iteration }}:
                                                {{ data_get($pf, 'name') ?? basename(data_get($pf, 'path', '')) }}
                                            </p>
                                            <a href="{{ route('download', ['path' => data_get($pf, 'path')]) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 shadow-sm hover:shadow-md transition-all duration-300">
                                                <i class="fas fa-download mr-2"></i>Download File Proyek
                                            </a>
                                        </div>
                                    @endforeach
                                @elseif($report->project_file)
                                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                        <p class="text-sm text-gray-700 font-medium mb-2">
                                            <i class="fas fa-file-archive text-gray-500 mr-2"></i>
                                            File Proyek:
                                            {{ $report?->project_file_name ?? basename($report?->project_file ?? '') }}
                                        </p>
                                        <a href="{{ route('download', ['path' => $report->project_file]) }}"
                                            target="_blank"
                                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 shadow-sm hover:shadow-md transition-all duration-300">
                                            <i class="fas fa-download mr-2"></i>Download File Proyek
                                        </a>
                                    </div>
                                @endif

                                @if (!empty($projectLinksDisplay) && is_array($projectLinksDisplay))
                                    @foreach ($projectLinksDisplay as $pl)
                                        @if (!empty($pl))
                                            <div class="p-4 bg-blue-50 rounded-xl border border-blue-200">
                                                <p class="text-sm text-gray-700 font-medium mb-2">
                                                    <i class="fas fa-link text-blue-500 mr-2"></i>
                                                    Link Proyek {{ $loop->iteration }}
                                                </p>
                                                <a href="{{ $pl }}" target="_blank" rel="noopener"
                                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 shadow-sm hover:shadow-md transition-all duration-300">
                                                    <i class="fas fa-external-link-alt mr-2"></i>Buka Link Proyek
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                @elseif($report->project_link)
                                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-200">
                                        <p class="text-sm text-gray-700 font-medium mb-2">
                                            <i class="fas fa-link text-blue-500 mr-2"></i>
                                            Link Proyek
                                        </p>
                                        <a href="{{ $report->project_link }}" target="_blank" rel="noopener"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 shadow-sm hover:shadow-md transition-all duration-300">
                                            <i class="fas fa-external-link-alt mr-2"></i>Buka Link Proyek
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($report->activities && is_array($report->activities) && count($report->activities) > 0)
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-tasks text-green-600"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Kegiatan Selama Magang</h3>
                            </div>
                            <div class="space-y-3">
                                @foreach ($report->activities as $activity)
                                    <div class="p-4 bg-green-50 rounded-xl border border-green-200">
                                        <div class="flex items-start">
                                            <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                            <p class="text-gray-900 flex-1">{{ $activity['description'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if (!$report->grade)
                <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                    <div class="bg-blue-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-star mr-3"></i>
                            Beri Nilai Laporan
                        </h2>
                    </div>
                    <div class="p-8">
                        <form method="POST" action="{{ route('mentor.report.grade', $report) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-6">
                                <label for="score" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-award text-blue-600 mr-2"></i>
                                    Nilai (0-100)
                                </label>
                                <input type="number" name="score" id="score" min="0" max="100"
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg font-semibold"
                                    placeholder="Masukkan nilai 0-100" oninput="updateGradePreview(this.value)">
                                <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="text-sm text-blue-800 font-medium">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <strong>Kriteria Penilaian:</strong> A = 85-100 | B = 70-84 | C = 0-69
                                    </p>
                                </div>
                                <p class="mt-2 text-sm font-bold" id="gradePreview"></p>
                            </div>

                            <div class="mb-6">
                                <label for="mentor_note" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-comment-alt text-blue-600 mr-2"></i>
                                    Catatan Mentor (Opsional)
                                </label>
                                <textarea name="mentor_note" id="mentor_note" rows="5"
                                    placeholder="Berikan feedback konstruktif untuk laporan ini..."
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('mentor_note') }}</textarea>
                            </div>

                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('mentor.report.index') }}"
                                    class="inline-flex items-center px-6 py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 shadow-md hover:shadow-lg transition-all duration-300">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Nilai
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @push('scripts')
                    <script>
                        function updateGradePreview(score) {
                            const preview = document.getElementById('gradePreview');
                            if (!score || score < 0 || score > 100) {
                                preview.textContent = '';
                                return;
                            }
                            let grade = 'C';
                            if (score >= 85) {
                                grade = 'A';
                            } else if (score >= 70) {
                                grade = 'B';
                            }
                            preview.innerHTML = '<i class="fas fa-trophy mr-2"></i>Nilai yang akan diberikan: <span class="text-lg">' +
                                grade + '</span>';
                            preview.className = 'mt-2 text-sm font-bold ' +
                                (grade === 'A' ? 'text-green-600' :
                                    grade === 'B' ? 'text-blue-600' : 'text-yellow-600');
                        }
                    </script>
                @endpush
            @endif

        </div>
    </div>
@endsection
