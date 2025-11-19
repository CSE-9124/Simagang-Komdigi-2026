@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Anak Magang Bimbingan</h1>

            <!-- Search Section -->
            <form method="GET" action="{{ route('mentor.intern.index') }}" class="mb-4">
                <div class="flex gap-2">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                        placeholder="Cari nama..." 
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    @if(request()->filled('search'))
                        <a href="{{ route('mentor.intern.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Institusi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Logbook</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Absensi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mikro Skill</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($interns as $intern)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($intern->photo_path)
                                    <img src="{{ url('storage/'.$intern->photo_path) }}" class="w-10 h-10 rounded-full object-cover border" />
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a class="text-blue-600 hover:underline" href="{{ route('mentor.intern.show', $intern) }}">{{ $intern->name }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $intern->institution }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $intern->logbooks_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $intern->attendances_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $intern->micro_skills_count }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada anak magang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                @if(method_exists($interns, 'links'))
                    {{ $interns->links() }}
                @endif
            </div>
        </div>
    </div>
    <div class="mt-4 flex space-x-3">
        <a href="{{ route('mentor.attendance.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lihat Absensi</a>
        <a href="{{ route('mentor.logbook.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Lihat Logbook</a>
        <a href="{{ route('mentor.report.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">Lihat Laporan</a>
    </div>
</div>
@endsection


