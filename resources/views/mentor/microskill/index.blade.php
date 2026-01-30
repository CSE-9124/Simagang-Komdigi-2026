@extends('layouts.app')

@section('title', 'Mikro Skill Anak Bimbingan - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-blue-600 mb-3"> Mikro Skill Anak Bimbingan
                </h1>
                <p class="text-sm sm:text-base text-gray-600">Pantau pencapaian dan pengembangan keterampilan anak magang</p>
            </div>

            <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <div
                    class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-blue-100">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Total Submissions</p>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $submissions->total() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-blue-100">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Unique Interns</p>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">
                                    {{ $submissions->pluck('intern_id')->unique()->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-blue-100 sm:col-span-2 lg:col-span-1">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-600 mb-1">Showing Page</p>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $submissions->currentPage() }} /
                                    {{ $submissions->lastPage() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-xl border border-blue-200 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 sm:px-6 py-3 sm:py-5">
                    <h2 class="text-lg sm:text-xl font-bold text-white">
                        Filter Data
                    </h2>
                </div>
                <div class="p-4 sm:p-6">
                    <form method="GET" action="{{ route('mentor.microskill.index') }}">
                        <div class="flex flex-col sm:flex-row justify-between gap-3 sm:gap-5">
                            <!-- Anak Magang -->
                            <div class="flex-1 flex flex-col">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <span>Anak Magang</span>
                                </label>
                                <select name="intern_id"
                                    class="px-3 sm:px-4 py-2 sm:py-2.5 border-2 border-gray-300 rounded-xl text-sm sm:text-base text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-blue-400 appearance-none bg-white cursor-pointer shadow-sm hover:shadow-md">
                                    <option value="">-- Semua Anak Magang --</option>
                                    @foreach ($interns as $intern)
                                        <option value="{{ $intern->id }}" @selected(request('intern_id') == $intern->id)>{{ $intern->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-end gap-2 flex-shrink-0">
                                <button type="submit"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm sm:text-base rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 transition-all duration-300">
                                    <i class="fas fa-search mr-1 sm:mr-2"></i>
                                    <span>Cari</span>
                                </button>
                                @if (request()->filled('intern_id'))
                                    <a href="{{ route('mentor.microskill.index') }}"
                                        class="inline-flex items-center justify-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold py-2 sm:py-2.5 px-3 sm:px-4 rounded-xl transition duration-200 shadow-md hover:shadow-lg transform hover:scale-105 active:scale-95">
                                        <i class="fas fa-times text-lg"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 sm:px-6 py-3 sm:py-5">
                    <h2 class="text-lg sm:text-xl font-bold text-white">
                        Data Mikro Skill
                    </h2>
                </div>
                <div class="p-3 sm:p-6 overflow-x-auto">
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-600 to-indigo-600">
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-5 text-left text-xs font-bold text-white uppercase tracking-widest">
                                        Nama</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-5 text-left text-xs font-bold text-white uppercase tracking-widest">
                                        Judul Course</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-5 text-left text-xs font-bold text-white uppercase tracking-widest">
                                        Waktu Submit</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 sm:py-5 text-left text-xs font-bold text-white uppercase tracking-widest">
                                        Dokumentasi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($submissions as $s)
                                    <tr
                                        class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 border-b border-gray-200">
                                        <td class="px-3 sm:px-6 py-3 sm:py-5 whitespace-nowrap">
                                            <div class="flex items-center gap-2 sm:gap-3">
                                                @if ($s->intern->photo_path)
                                                    <img src="{{ url('storage/' . $s->intern->photo_path) }}"
                                                        class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover object-center border-2 border-blue-300 shadow-md ring-2 ring-blue-100 flex-shrink-0 aspect-square"
                                                        alt="{{ $s->intern->name }}" />
                                                @else
                                                    <div
                                                        class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center shadow-md ring-2 ring-blue-100 flex-shrink-0 aspect-square">
                                                        <i class="fas fa-user text-white text-sm sm:text-base"></i>
                                                    </div>
                                                @endif
                                                <span
                                                    class="text-xs sm:text-sm font-semibold text-gray-900 truncate">{{ $s->intern->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-5">
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ Str::limit($s->title, 40) }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-5 whitespace-nowrap">
                                            <div class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm">
                                                <span
                                                    class="text-gray-700 font-medium">{{ $s->submitted_at ? \Carbon\Carbon::parse($s->submitted_at)->format('d M Y') : '-' }}</span>
                                                <span
                                                    class="text-gray-500 text-xs hidden sm:inline">{{ $s->submitted_at ? \Carbon\Carbon::parse($s->submitted_at)->format('H:i') : '' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-5 whitespace-nowrap">
                                            @if ($s->photo_path)
                                                <img src="{{ url('storage/' . $s->photo_path) }}" alt="Documentation"
                                                    class="w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all shadow-sm hover:shadow-lg transform hover:scale-110 aspect-square"
                                                    onclick="window.open('{{ url('storage/' . $s->photo_path) }}', '_blank')"
                                                    title="Klik untuk melihat full size" />
                                            @else
                                                <div
                                                    class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 rounded-lg border-2 border-gray-200">
                                                    <i class="fas fa-image text-gray-300 text-sm sm:text-lg"></i>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 sm:px-6 py-8 sm:py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div
                                                    class="w-16 h-16 sm:w-24 sm:h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-3 sm:mb-5 shadow-md">
                                                    <i class="fas fa-certificate text-3xl sm:text-5xl text-gray-300"></i>
                                                </div>
                                                <p class="text-base sm:text-lg font-bold text-gray-700 mb-1 sm:mb-2">Tidak
                                                    ada data mikro skill</p>
                                                <p class="text-xs sm:text-sm text-gray-500">Data akan muncul ketika anak
                                                    magang mensubmit course</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
