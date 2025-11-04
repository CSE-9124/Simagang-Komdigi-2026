@extends('layouts.app')

@section('title', 'Kelola Anak Magang - Sistem Magang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-900">Kelola Anak Magang</h1>
            <a href="{{ route('admin.intern.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i>Tambah Anak Magang
            </a>
        </div>

        <!-- Filter Section -->
        <form method="GET" action="{{ route('admin.intern.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="team" class="block text-sm font-medium text-gray-700 mb-1">Filter TIM</label>
                <select name="team" id="team" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua TIM</option>
                    <option value="TIM DEA" {{ request('team') == 'TIM DEA' ? 'selected' : '' }}>TIM DEA</option>
                    <option value="TIM GTA" {{ request('team') == 'TIM GTA' ? 'selected' : '' }}>TIM GTA</option>
                    <option value="TIM VSGA" {{ request('team') == 'TIM VSGA' ? 'selected' : '' }}>TIM VSGA</option>
                    <option value="TIM TA" {{ request('team') == 'TIM TA' ? 'selected' : '' }}>TIM TA</option>
                    <option value="TIM Microskill" {{ request('team') == 'TIM Microskill' ? 'selected' : '' }}>TIM Microskill</option>
                    <option value="TIM Media" {{ request('team') == 'TIM Media' ? 'selected' : '' }}>TIM Media</option>
                    <option value="TIM Tata Usaha" {{ request('team') == 'TIM Tata Usaha' ? 'selected' : '' }}>TIM Tata Usaha</option>
                </select>
            </div>
            <div>
                <label for="mentor_id" class="block text-sm font-medium text-gray-700 mb-1">Filter Mentor</label>
                <select name="mentor_id" id="mentor_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Mentor</option>
                    @foreach($mentors as $mentor)
                        <option value="{{ $mentor->id }}" {{ request('mentor_id') == $mentor->id ? 'selected' : '' }}>{{ $mentor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Filter Status</label>
                <select name="is_active" id="is_active" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                @if(request()->anyFilled(['team', 'mentor_id', 'is_active']))
                    <a href="{{ route('admin.intern.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Institusi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">TIM</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mentor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($interns as $intern)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($intern->photo_path)
                                    <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ url('storage/' . $intern->photo_path) }}" alt="{{ $intern->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                @endif
                                <div class="text-sm font-medium text-gray-900">{{ $intern->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $intern->user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $intern->institution }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                {{ $intern->team ?: '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $intern->mentor ? $intern->mentor->name : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $intern->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $intern->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.intern.show', $intern) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.intern.edit', $intern) }}" class="text-green-600 hover:text-green-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.intern.destroy', $intern) }}" method="POST" class="inline" 
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data anak magang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $interns->links() }}
    </div>
</div>
@endsection
