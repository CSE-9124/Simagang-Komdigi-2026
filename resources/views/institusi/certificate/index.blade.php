@extends('layouts.app')

@section('title', 'Nilai Sertifikat - Institusi')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-blue-600 mb-3">Nilai Sertifikat Anak Magang</h1>
                <p class="text-sm sm:text-base text-gray-600">Lihat dan cek nilai sertifikat untuk anak magang yang terdaftar di institusi Anda.</p>
            </div>

            <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-xl border border-blue-200 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 sm:px-6 py-3 sm:py-5">
                    <h2 class="text-lg sm:text-xl font-bold text-white">Cari Sertifikat</h2>
                </div>
                <div class="p-3 sm:p-6">
                    <form method="GET" action="{{ route('institusi.certificate.index') }}" class="mb-4 sm:mb-6">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama intern atau nomor sertifikat..."
                                class="flex-1 block w-full px-4 py-3 border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm" />
                            <button type="submit"
                                class="inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 whitespace-nowrap">
                                <i class="fas fa-search mr-2"></i>Cari
                            </button>
                        </div>
                    </form>

                    <div class="overflow-x-auto rounded-xl shadow-inner">
                        <table class="w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-left text-xs uppercase tracking-wider">
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Nama Anak Magang</th>
                                    <th class="px-4 py-3">No. Sertifikat</th>
                                    <th class="px-4 py-3">Terbit</th>
                                    <th class="px-4 py-3">Nilai Sertifikat</th>
                                    <th class="px-4 py-3">Grade Sertifikat</th>
                                    <th class="px-4 py-3">Nilai Laporan</th>
                                    <th class="px-4 py-3">Grade Laporan</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($certificates as $certificate)
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        <td class="px-4 py-4 text-sm text-gray-700">{{ $loop->iteration + ($certificates->currentPage() - 1) * $certificates->perPage() }}</td>
                                        <td class="px-4 py-4 text-sm font-semibold text-gray-900">{{ $certificate->intern->name }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-700">{{ $certificate->certificate_number }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-700">{{ optional($certificate->issue_date)->translatedFormat('d F Y') ?? '-' }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-700">
                                            @if($certificate->score)
                                                {{ $certificate->score->average }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700">
                                            @if($certificate->score)
                                                {{ scoreToGrade($certificate->score->average) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700">
                                            @if($certificate->intern->finalReport)
                                                {{ $certificate->intern->finalReport->score ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700">
                                            @if($certificate->intern->finalReport)
                                                {{ $certificate->intern->finalReport->grade ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700">
                                            <a href="{{ route('institusi.certificate.show', $certificate) }}"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition">
                                                <i class="fas fa-eye"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                                            Belum ada sertifikat tersedia atau tidak ditemukan untuk institusi Anda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($certificates->hasPages())
                        <div class="mt-6">
                            {{ $certificates->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
