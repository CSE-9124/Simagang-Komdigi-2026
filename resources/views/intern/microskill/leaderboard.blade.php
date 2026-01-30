@extends('layouts.app')

@section('title', 'Leaderboard Mikro Skill - Sistem Magang')

@section('content')
<div class="min-h-screen bg-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
                <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl sm:text-4xl font-bold text-blue-600">Leaderboard Mikro Skill</h1>
            </div>
        </div>
    
        <!-- Leaderboard Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-blue-600 px-6 py-3">
                <h2 class="text-base sm:text-lg font-bold text-white flex items-center">
                    <i class="fas fa-trophy mr-3"></i>
                    Leaderboard Mikro Skill
                </h2>
            </div>
    
                <div class="p-6">
                    <div class="max-h-[500px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-blue-400 scrollbar-track-blue-100">
                    @forelse($rows as $index => $row)
                        <div class="w-full flex items-center justify-between p-2 sm:p-3 bg-blue-50 rounded-lg hover:shadow-md transition-all duration-300 border border-blue-100 mb-3 last:mb-0">
                            <div class="flex items-center flex-1 min-w-0">
                                <!-- Rank Badge -->
                                <div class="relative">
                                    <span class="w-8 h-8 rounded-full 
                                        @if(($rows->firstItem() + $index) == 1) bg-yellow-500
                                        @elseif(($rows->firstItem() + $index) == 2) bg-gray-400
                                        @elseif(($rows->firstItem() + $index) == 3) bg-orange-500
                                        @else bg-indigo-500
                                        @endif
                                        text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-lg mr-2 sm:mr-3">
                                        {{ ($rows->firstItem() + $index) }}
                                    </span>
                                    @if(($rows->firstItem() + $index) < 4)
                                        <i class="fas fa-crown absolute -top-2 -right-1 text-yellow-500 text-[10px] sm:text-xs"></i>
                                    @endif
                                </div>
    
                                <!-- Photo -->
                                @if($row->photo_path)
                                    <img src="{{ url('storage/'.$row->photo_path) }}" 
                                         class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border-2 border-white shadow-md mr-2 sm:mr-3" 
                                         alt="{{ $row->name }}">
                                @else
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-300 flex items-center justify-center mr-2 sm:mr-3 shadow-md">
                                        <i class="fas fa-user text-gray-500 text-xs"></i>
                                    </div>
                                @endif
    
                                <!-- Info -->
                                <div class="min-w-0 overflow-hidden ml-1">
                                    <div class="font-semibold text-gray-900 text-xs sm:text-sm truncate">
                                        {{ $row->name }}
                                    </div>
                                    <div class="text-[11px] sm:text-xs text-gray-500 truncate">
                                        {{ $row->institution }}
                                    </div>
                                </div>
                            </div>
    
                            <!-- Score Badge (fixed width to balance layout) -->
                            <span class="ml-3 flex-shrink-0 w-20 sm:w-24 flex items-center justify-center px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-[11px] sm:text-xs font-semibold whitespace-nowrap">
                                {{ $row->total }} course
                            </span>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                            <i class="fas fa-chart-line text-4xl mb-3 text-gray-300"></i>
                            <p class="text-sm">Belum ada data.</p>
                        </div>
                    @endforelse
                    </div>
                </div>
                
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('intern.dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors py-2 px-4 rounded">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
                
                <!-- Pagination -->
                @if($rows->hasPages())
                    <div class="mt-4">
                        {{ $rows->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection