@extends('layouts.app')

@section('title', 'Mikro Skill - Sistem Magang')

@section('content')
<div class="min-h-screen bg-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($errors->any())
            <div class="bg-red-100 border-t-4 border-red-500 text-red-700 px-6 py-4 mb-8 rounded-lg" role="alert">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle mr-3 mt-1"></i>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-blue-600 mb-1">Mikro Skill Saya</h1>
                    <p class="text-gray-600">Kelola pengumpulan mikro skill Anda</p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                    <form method="GET" action="{{ route('intern.microskill.index') }}" class="flex items-center w-full sm:w-auto gap-2">
                        <label for="q" class="sr-only">Cari mikro skill</label>
                        <input id="q" name="q" value="{{ request('q') }}" type="text" placeholder="Cari judul..." 
                               class="flex-1 text-sm px-4 py-3 rounded-full border border-blue-100 bg-white placeholder-gray-400 focus:outline-none" />

                        @if(request('q'))
                            <a href="{{ route('intern.microskill.index') }}" aria-label="Bersihkan pencarian" class="w-11 h-11 rounded-full bg-white border border-gray-200 text-gray-600 flex items-center justify-center hover:bg-gray-50">
                                <i class="fas fa-times"></i>
                            </a>
                        @else
                            <button type="submit" aria-label="Cari" class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700">
                                <i class="fas fa-search"></i>
                            </button>
                        @endif
                    </form>

                    <a href="{{ route('intern.microskill.create') }}" 
                       class="inline-flex items-center justify-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow transition-all duration-200 w-full sm:w-auto">
                        <i class="fas fa-upload mr-2"></i>
                        <span>Upload Bukti</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Microskill Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-star mr-3"></i>
                    Data Mikro Skill
                </h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto overflow-y-auto max-h-[500px] scrollbar-thin scrollbar-thumb-blue-400 scrollbar-track-blue-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-blue-50">
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">Judul</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Dikirim</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Bukti</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($submissions as $s)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        <div class="flex items-center justify-start min-w-0">
                                            <span class="text-sm font-medium text-gray-900 truncate">{{ $s->title }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($s->status == 'approved') bg-green-100 text-green-800
                                            @elseif($s->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($s->status == 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            @if($s->status == 'approved')
                                            @elseif($s->status == 'pending')
                                            @elseif($s->status == 'rejected')
                                            @endif
                                            {{ ucfirst($s->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                        @if($s->submitted_at)
                                            <div class="flex items-center justify-center">
                                                {{ \Carbon\Carbon::parse($s->submitted_at)->setTimezone('Asia/Makassar')->format('d/m/Y') }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($s->photo_path)
                                            <img src="{{ asset('storage/'.$s->photo_path) }}" 
                                                 alt="Bukti" 
                                                 class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all shadow-sm mx-auto" 
                                                 onclick="window.open('{{ asset('storage/'.$s->photo_path) }}', '_blank')"
                                                 title="Klik untuk melihat full size">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <div class="flex space-x-2 justify-center">
                                            <a href="{{ route('intern.microskill.edit', $s->id) }}" 
                                               class="inline-flex items-center justify-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-all duration-200"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('intern.microskill.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mikro skill ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center justify-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-all duration-200"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fas fa-inbox text-5xl mb-3 text-gray-300"></i>
                                            <p class="text-lg font-medium">Belum ada pengumpulan.</p>
                                            <a href="{{ route('intern.microskill.create') }}" 
                                               class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300">
                                                <i class="fas fa-upload mr-2"></i>Upload Bukti
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($submissions->count() > 0)
                    <div class="mt-6">
                        {{ $submissions->appends(request()->except('page'))->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection