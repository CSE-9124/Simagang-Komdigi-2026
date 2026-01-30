@extends('layouts.app')

@section('title', 'Leaderboard Mikro Skill - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1
                    class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                    Leaderboard Mikro Skill
                </h1>
                <p class="text-sm sm:text-base text-gray-600">Peringkat pencapaian keterampilan anak magang bimbingan Anda
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-blue-100 overflow-hidden">
                <div class="bg-blue-600 px-4 sm:px-6 py-3 sm:py-4">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-4">
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-white">Leaderboard Mikro Skill</h2>
                            <p class="text-blue-100 text-xs sm:text-sm">Anak magang dengan pencapaian terbaik</p>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-blue-100 text-xs uppercase tracking-wide">Total Participants</p>
                            <p class="text-white text-lg sm:text-xl font-bold">{{ $rows->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-6">
                    <div class="space-y-2 sm:space-y-3">
                        @forelse($rows as $index => $row)
                            @php
                                $actualRank = $rows->firstItem() + $index;
                            @endphp
                            <div
                                class="flex items-center justify-between p-3 sm:p-4 bg-blue-50 rounded-xl hover:shadow-lg transition-all duration-300 border border-blue-100 group gap-2">
                                <div class="flex items-center flex-1 min-w-0">
                                    <div class="relative mr-2 sm:mr-3 flex-shrink-0">
                                        <span
                                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br 
                                        @if ($actualRank == 1) from-yellow-400 to-yellow-600 shadow-lg
                                        @elseif($actualRank == 2) from-gray-300 to-gray-500 shadow-lg
                                        @elseif($actualRank == 3) from-orange-400 to-orange-600 shadow-lg
                                        @else from-blue-500 to-blue-600 @endif
                                        text-white flex items-center justify-center font-bold text-sm sm:text-lg transform group-hover:scale-110 transition-transform duration-300">
                                            {{ $actualRank }}
                                        </span>
                                        @if ($actualRank <= 3)
                                            <i class="fas fa-crown absolute -top-1 -right-1 text-yellow-500 text-xs"></i>
                                        @endif
                                    </div>

                                    <div class="mr-2 sm:mr-3 flex-shrink-0">
                                        @if ($row->photo_path)
                                            <img src="{{ url('storage/' . $row->photo_path) }}"
                                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover object-center border-2 border-white shadow-lg ring-2 cursor-pointer hover:shadow-xl transition-all duration-300 aspect-square
                                             @if ($actualRank == 1) ring-yellow-400
                                             @elseif($actualRank == 2) ring-gray-400
                                             @elseif($actualRank == 3) ring-orange-400
                                             @else ring-blue-300 @endif"
                                                alt="{{ $row->name }}"
                                                onclick="window.open('{{ url('storage/' . $row->photo_path) }}', '_blank')"
                                                title="Klik untuk melihat full size" />
                                        @else
                                            <div
                                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center shadow-lg ring-2 ring-blue-300 aspect-square">
                                                <i class="fas fa-user text-white text-sm sm:text-lg"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-1 mb-0.5 sm:mb-1">
                                            <h3 class="font-bold text-gray-900 text-sm sm:text-lg truncate">
                                                {{ $row->name }}</h3>
                                
                                        </div>
                                        <div class="flex items-center text-xs sm:text-sm text-gray-600 truncate">
                                            <span class="truncate">{{ $row->institution }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Score Badge -->
                                <div class="flex-shrink-0">
                                    <span
                                        class="px-2 sm:px-3 py-0.5 sm:py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold flex-shrink-0 whitespace-nowrap">
                                        <i class="fas fa-star mr-0.5 sm:mr-1"></i>
                                        {{ $row->total }} course
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-16 text-gray-500">
                                <div
                                    class="w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-chart-line text-5xl text-blue-300"></i>
                                </div>
                                <p class="text-lg font-semibold text-gray-700">Belum ada data leaderboard</p>
                                <p class="text-sm text-gray-500 mt-2">Data akan muncul ketika anak magang mulai
                                    menyelesaikan course</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($rows->hasPages())
                        <div class="mt-6 pt-6 border-t border-blue-100">
                            {{ $rows->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                <!-- Top Performer -->
                @if ($rows->count() > 0 && $rows->currentPage() == 1)
                    <div class="bg-white rounded-xl shadow-md border border-yellow-200 p-4 sm:p-6">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Top Performer</p>
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 truncate">{{ $rows->first()->name }}
                                </h3>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ $rows->first()->total }} courses</p>
                            </div>
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-crown text-white text-lg sm:text-xl"></i>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-md border border-blue-100 p-4 sm:p-6">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Rata-rata Course</p>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900">
                                @if ($rows->count() > 0)
                                    {{ number_format($rows->avg('total'), 1) }}
                                @else
                                    0
                                @endif
                            </h3>
                        </div>
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-chart-bar text-white text-lg sm:text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-blue-100 p-4 sm:p-6">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Total Course</p>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $rows->sum('total') }}</h3>
                        </div>
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-book text-white text-lg sm:text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('mentor.dashboard') }}"
                    class="inline-flex items-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 shadow-md hover:shadow-lg transition-all duration-300 text-sm sm:text-base">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
@endsection
