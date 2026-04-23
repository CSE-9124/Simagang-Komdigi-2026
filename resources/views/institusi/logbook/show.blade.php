@extends('layouts.app')

@section('title', 'Detail Logbook - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <Detail class="text-3xl sm:text-4xl font-bold text-green-600 mb-3">Detail Logbook
                </h1>
                <p class="text-sm sm:text-base text-gray-600">Informasi lengkap catatan harian anak magang</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden">

                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-4 sm:px-6 py-4 sm:py-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        @if ($logbook->intern->photo_path)
                            <img src="{{ url('storage/' . $logbook->intern->photo_path) }}"
                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-full object-cover object-center border-4 border-white shadow-lg flex-shrink-0 aspect-square"
                                alt="{{ $logbook->intern->name }}" />
                        @else
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white flex items-center justify-center shadow-lg flex-shrink-0 aspect-square">
                                <i class="fas fa-user text-green-600 text-lg sm:text-2xl"></i>
                            </div>
                        @endif
                        <div class="text-white flex-1 min-w-0">
                            <h2 class="text-xl sm:text-2xl font-bold">{{ $logbook->intern->name }}</h2>
                            <p class="text-green-100 flex items-center mt-1 text-xs sm:text-sm truncate">
                                {{ $logbook->intern->institution }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-8">

                    <div class="mb-6 sm:mb-8">
                        <div
                            class="inline-flex items-center px-3 sm:px-4 py-2 bg-green-50 rounded-xl border border-green-200">
                            <div>
                                <p class="text-xs text-green-600 font-medium uppercase tracking-wide">Tanggal</p>
                                <p class="text-sm sm:text-base font-bold text-green-900">
                                    {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>


                    <div class="mb-6 sm:mb-8">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-tasks text-green-600 text-sm sm:text-lg"></i>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Aktivitas</h3>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 sm:p-6 border border-gray-200">
                            <p class="text-xs sm:text-sm text-gray-800 whitespace-pre-line leading-relaxed">
                                {{ $logbook->activity }}</p>
                        </div>
                    </div>

                    <div class="mb-6 sm:mb-8">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-camera text-grey-600 text-sm sm:text-lg"></i>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Foto Dokumentasi</h3>
                        </div>
                        @if ($logbook->photo_path)
                            <div class="relative group">
                                <img src="{{ url('storage/' . $logbook->photo_path) }}"
                                    class="w-full rounded-xl border-2 border-gray-200 shadow-lg cursor-pointer hover:shadow-2xl transition-all duration-300 max-h-96 object-cover"
                                    alt="Foto Logbook"
                                    onclick="window.open('{{ url('storage/' . $logbook->photo_path) }}', '_blank')" />
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-xl transition-all duration-300 flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="bg-white rounded-full p-3 shadow-lg">
                                            <i class="fas fa-search-plus text-green-600 text-lg sm:text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 text-center mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Klik untuk melihat ukuran penuh
                                </p>
                            </div>
                        @else
                            <div
                                class="flex flex-col items-center justify-center py-8 sm:py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                <i class="fas fa-image text-4xl sm:text-5xl text-gray-300 mb-2 sm:mb-3"></i>
                                <p class="text-xs sm:text-sm font-medium text-gray-500">Tidak ada foto.</p>
                            </div>
                        @endif
                    </div>

                    <div
                        class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3 pt-4 sm:pt-6 border-t border-gray-200">
                        <a href="{{ url()->previous() }}"
                            class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 shadow-md hover:shadow-lg transition-all duration-300 text-sm sm:text-base">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>

                        <a href="{{ route('institusi.logbook.index') }}"
                            class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 shadow-md hover:shadow-lg transition-all duration-300 text-sm sm:text-base">
                            <i class="fas fa-list mr-2"></i>
                            Lihat Semua Logbook
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
