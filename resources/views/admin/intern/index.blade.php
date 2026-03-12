@extends('layouts.app')

@section('title', 'Kelola Anak Magang - Sistem Magang')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h1
                        class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2 pb-2">
                        Kelola Anak Magang
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Manajemen data anak magang dan monitoring aktif
                    </p>
                </div>

                <a href="{{ route('admin.intern.create') }}"
                    class="inline-flex items-center justify-center gap-2
                        bg-blue-600 hover:bg-blue-700
                        text-white font-semibold
                        px-6 py-3 rounded-xl
                        shadow-lg hover:shadow-xl
                        transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Anak Magang</span>
                </a>

            </div>


            <!-- Filter Section -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6 border-t-4 border-blue-500">
                <h2 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                    <i class="fas fa-filter mr-2 text-blue-600"></i>Filter & Pencarian
                </h2>
                <form method="GET" action="{{ route('admin.intern.index') }}"
                    class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-blue-900 mb-1">Cari Nama</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Cari nama..."
                            class="w-full px-3 py-2 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="team" class="block text-sm font-medium text-blue-900 mb-1">Filter TIM</label>
                        <select name="team_id" id="team"
                            class="w-full px-3 py-2 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua TIM</option>
                            @foreach($teams as $teamOption)
                                <option value="{{ $teamOption->id }}" {{ request('team_id') == $teamOption->id ? 'selected' : '' }}>
                                    {{ $teamOption->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="mentor_id" class="block text-sm font-medium text-blue-900 mb-1">Filter Mentor</label>
                        <select name="mentor_id" id="mentor_id"
                            class="w-full px-3 py-2 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Mentor</option>
                            @foreach ($mentors as $mentor)
                                <option value="{{ $mentor->id }}"
                                    {{ request('mentor_id') == $mentor->id ? 'selected' : '' }}>{{ $mentor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-blue-900 mb-1">Filter Status</label>
                        <select name="is_active" id="is_active"
                            class="w-full px-3 py-2 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Tidak Aktif
                            </option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200 flex-1">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                        @if (request()->anyFilled(['search', 'team_id', 'mentor_id', 'is_active']))
                            <a href="{{ route('admin.intern.index') }}"
                                class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-blue-100 overflow-hidden mb-8">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-users mr-3"></i>
                        Data Anak Magang
                    </h2>
                </div>

                <div class="p-6">
                    <div class="max-h-[500px] overflow-x-auto overflow-y-auto pr-2">
                        <table class="min-w-[1000px] w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-blue-50">
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">
                                        Nama</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Institusi</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        TIM</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Mentor</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">
                                        Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($interns as $intern)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if ($intern->photo_path)
                                                    <div
                                                        class="w-10 h-10 rounded-full overflow-hidden border-2 border-blue-200 mr-3 bg-gray-100 flex-shrink-0">
                                                        <img src="{{ url('storage/' . $intern->photo_path) }}"
                                                            alt="{{ $intern->name }}"
                                                            class="w-full h-full object-cover object-center">
                                                    </div>
                                                @else
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center border-2 border-blue-200 mr-3 flex-shrink-0">
                                                        <i class="fas fa-user text-blue-600"></i>
                                                    </div>
                                                @endif

                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ $intern->name }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $intern->user->email }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $intern->institution }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $intern->team ? $intern->team->name : '-' }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $intern->mentor ? $intern->mentor->name : '-' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                            {{ $intern->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $intern->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.intern.show', $intern) }}"
                                                class="text-green-600 hover:text-green-800 mr-3 transition" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.intern.edit', $intern) }}"
                                                class="text-blue-600 hover:text-blue-800 mr-3 transition" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.intern.destroy', $intern) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center text-gray-500">
                                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                                <p class="text-sm">Belum ada data anak magang.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                {{ $interns->links() }}
            </div>
        </div>
    </div>
@endsection