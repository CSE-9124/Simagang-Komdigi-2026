@extends('layouts.app')

@section('title', 'Leaderboard Mikro Skill - Sistem Magang')

@section('content')
<div class="min-h-screen bg-blue-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-blue-600">
                Leaderboard Mikro Skill
            </h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">
                Lihat peringkat peserta berdasarkan jumlah course yang telah diselesaikan.
            </p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 mb-6 border-t-4 border-blue-500">
            <!-- Filter & Search -->
            <form method="GET" action="{{ route('intern.microskill.leaderboard') }}"
                class="grid grid-cols-1 md:grid-cols-12 gap-4">

                <!-- Search -->
                <div class="md:col-span-5">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                        Cari Nama
                    </label>
                    <input type="text" name="search" id="search"
                        value="{{ request('search') }}"
                        placeholder="Masukkan nama..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Status -->
                <div class="md:col-span-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Filter Status
                    </label>
                    <select name="status" id="status"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>
                    </select>
                </div>

                <!-- Button -->
                <div class="md:col-span-3 flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition-all">
                        <i class="fas fa-filter mr-2"></i>
                        Filter
                    </button>

                    @if(request('search') || request('status'))
                        <a href="{{ route('intern.microskill.leaderboard') }}"
                            class="inline-flex items-center justify-center w-11 h-[42px] bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-all flex-shrink-0"
                            title="Reset Filter">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>

            </form>    
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">

            <!-- Card Header -->
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-trophy mr-3"></i>
                    Leaderboard Mikro Skill
                </h2>
            </div>

            <div class="p-6">

                <!-- List -->
                <div class="max-h-[540px] overflow-y-auto pr-1 space-y-3">

                    @forelse($rows as $index => $row)
                        @php
                            $rank = $rows->firstItem() + $index;
                        @endphp

                        <div class="flex items-center justify-between bg-white border border-blue-100 rounded-xl p-4 hover:shadow-md transition-all duration-200">

                            <!-- Left -->
                            <div class="flex items-center min-w-0">

                                <!-- Rank -->
                                <div class="mr-4 relative">
                                    <span class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white
                                        @if($rank == 1) bg-yellow-500
                                        @elseif($rank == 2) bg-gray-400
                                        @elseif($rank == 3) bg-orange-500
                                        @else bg-blue-600
                                        @endif">
                                        {{ $rank }}
                                    </span>

                                    @if($rank <= 3)
                                        <i class="fas fa-crown absolute -top-2 -right-1 text-yellow-500 text-xs"></i>
                                    @endif
                                </div>

                                <!-- Avatar -->
                                @if($row->photo_path)
                                    <img src="{{ url('storage/' . $row->photo_path) }}"
                                        alt="{{ $row->name }}"
                                        class="w-12 h-12 rounded-full object-cover border-2 border-white shadow mr-4">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                @endif

                                <!-- Info -->
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">
                                        {{ $row->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ $row->institution }}
                                    </p>
                                </div>
                            </div>

                            <!-- Score -->
                            <div class="ml-4 flex-shrink-0">
                                <span class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-sm font-semibold">
                                    {{ $row->total }} course
                                </span>
                            </div>
                        </div>

                    @empty
                        <div class="py-12 text-center text-gray-500">
                            <i class="fas fa-chart-line text-4xl text-gray-300 mb-3"></i>
                            <p>Belum ada data leaderboard.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Footer -->
                <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <a href="{{ route('intern.dashboard') }}"
                        class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>

                    @if($rows->hasPages())
                        <div>
                            {{ $rows->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection