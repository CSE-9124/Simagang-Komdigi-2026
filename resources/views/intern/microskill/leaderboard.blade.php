@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Leaderboard Mikro Skill</h1>
            <a href="{{ route('intern.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Leaderboard Card -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-blue-600 px-6 py-3">
            <h2 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-trophy mr-3"></i>
                Leaderboard Mikro Skill
            </h2>
        </div>
        <div class="p-6">
            @forelse($rows as $index => $row)
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:shadow-md transition-all duration-300 border border-blue-100 mb-3">
                    <div class="flex items-center">
                        <!-- Rank Badge -->
                        <div class="relative">
                            <span class="w-8 h-8 rounded-full 
                                @if(($rows->firstItem() + $index) == 1) bg-yellow-500
                                @elseif(($rows->firstItem() + $index) == 2) bg-gray-400
                                @elseif(($rows->firstItem() + $index) == 3) bg-orange-500
                                @else bg-indigo-500
                                @endif
                                text-white flex items-center justify-center font-bold text-sm shadow-lg mr-3">
                                {{ ($rows->firstItem() + $index) }}
                            </span>
                            @if(($rows->firstItem() + $index) < 4)
                                <i class="fas fa-crown absolute -top-2 -right-1 text-yellow-500 text-xs"></i>
                            @endif
                        </div>
                        
                        <!-- Photo -->
                        @if($row->photo_path)
                            <img src="{{ url('storage/'.$row->photo_path) }}" 
                                 class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-md mr-3" />
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-3 shadow-md">
                                <i class="fas fa-user text-gray-500 text-xs"></i>
                            </div>
                        @endif
                        
                        <!-- Info -->
                        <div>
                            <div class="font-semibold text-gray-900 text-sm">{{ $row->name }}</div>
                            <div class="text-xs text-gray-500">{{ $row->institution }}</div>
                        </div>
                    </div>
                    
                    <!-- Score Badge -->
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-semibold">
                        {{ $row->total }} course
                    </span>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                    <i class="fas fa-chart-line text-4xl mb-3 text-gray-300"></i>
                    <p class="text-sm">Belum ada data.</p>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($rows->hasPages())
                <div class="mt-4">
                    {{ $rows->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection