@extends('layouts.app')

@section('title', 'Mikro Skill Anak Bimbingan - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
<h1 class="text-4xl font-bold text-blue-600 mb-3">
                    Mikro Skill Anak Bimbingan
                </h1>
                <p class="text-gray-600">Pantau pencapaian dan pengembangan keterampilan anak magang</p>
            </div>

            <!-- Filter Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden mb-6">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-filter mr-3"></i>
                        Filter Data
                    </h2>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('mentor.microskill.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Anak Magang -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user-graduate mr-1 text-blue-500"></i>
                                    Anak Magang
                                </label>
                                <select name="intern_id"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <option value="">Semua</option>
                                    @foreach ($interns as $intern)
                                        <option value="{{ $intern->id }}" @selected(request('intern_id') == $intern->id)>{{ $intern->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300">
                                    <i class="fas fa-search mr-2"></i>
                                    Filter
                                </button>
                                <a href="{{ route('mentor.microskill.index') }}"
                                    class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 shadow-md hover:shadow-lg transition-all duration-300">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-graduation-cap mr-3"></i>
                        Data Mikro Skill
                    </h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-blue-50">
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">
                                        Nama</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Judul Course</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Waktu Submit</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">
                                        Bukti Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($submissions as $s)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if ($s->intern->photo_path)
                                                    <img src="{{ url('storage/' . $s->intern->photo_path) }}"
                                                        class="w-8 h-8 rounded-full object-cover border-2 border-blue-200 mr-3"
                                                        alt="{{ $s->intern->name }}" />
                                                @else
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center mr-3">
                                                        <i class="fas fa-user text-white text-xs"></i>
                                                    </div>
                                                @endif
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ $s->intern->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <i class="fas fa-book-open text-blue-500 mr-2"></i>
                                                <span class="text-sm font-semibold text-gray-900">{{ $s->title }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <i class="fas fa-clock text-blue-500 mr-2"></i>
                                                {{ $s->submitted_at ? \Carbon\Carbon::parse($s->submitted_at)->format('d M Y H:i') : '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($s->photo_path)
                                                <div class="relative group">
                                                    <img src="{{ url('storage/' . $s->photo_path) }}" alt="Certificate"
                                                        class="w-16 h-16 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all shadow-sm hover:shadow-md"
                                                        onclick="window.open('{{ url('storage/' . $s->photo_path) }}', '_blank')"
                                                        title="Klik untuk melihat sertifikat" />
                                                    <div
                                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-300 flex items-center justify-center">
                                                        <i
                                                            class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <i class="fas fa-certificate text-5xl mb-3 text-gray-300"></i>
                                                <p class="text-sm font-medium">Tidak ada data mikro skill.</p>
                                                <p class="text-xs text-gray-400 mt-1">Data akan muncul ketika anak magang
                                                    submit course</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-md border border-blue-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Submissions</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $submissions->total() }}</h3>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-list-check text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-blue-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Unique Interns</p>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $submissions->pluck('intern_id')->unique()->count() }}</h3>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-blue-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Showing Page</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $submissions->currentPage() }} /
                                {{ $submissions->lastPage() }}</h3>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-file-alt text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
