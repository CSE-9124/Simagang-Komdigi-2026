@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">Leaderboard Mikro Skill (Bimbingan)</h1>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="space-y-3">
                @forelse($rows as $index => $row)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold mr-3">{{ ($rows->firstItem() + $index) }}</span>
                            @if($row->photo_path)
                                <img src="{{ url('storage/'.$row->photo_path) }}" class="w-10 h-10 rounded-full object-cover border mr-3" />
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 mr-3"></div>
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900">{{ $row->name }}</div>
                                <div class="text-xs text-gray-500">{{ $row->institution }}</div>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold">{{ $row->total }} course</span>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada data.</p>
                @endforelse
            </div>

            <div class="mt-4">{{ $rows->links() }}</div>
        </div>
    </div>
</div>
@endsection


