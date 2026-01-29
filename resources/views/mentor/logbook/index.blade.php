@extends('layouts.app')

@section('title', 'Logbook Anak Bimbingan - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">

                <h1 class="text-4xl font-bold text-blue-600 mb-3">
                    Logbook Anak Bimbingan
                </h1>
                <p class="text-gray-600">Pantau dan kelola catatan harian aktivitas anak magang</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden mb-6">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-filter mr-3"></i>
                        Filter Data
                    </h2>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('mentor.logbook.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            <!-- Anak Magang -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user mr-1 text-blue-500"></i>
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

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-1 text-green-500"></i>
                                    Dari Tanggal
                                </label>
                                <input type="date" name="date_from" value="{{ request('date_from') }}"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-check mr-1 text-purple-500"></i>
                                    Hingga Tanggal
                                </label>
                                <input type="date" name="date_to" value="{{ request('date_to') }}"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" />
                            </div>

                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300">
                                    <i class="fas fa-search mr-2"></i>
                                    Filter
                                </button>
                                @if (request()->anyFilled(['intern_id', 'date_from', 'date_to']))
                                    <a href="{{ route('mentor.logbook.index') }}"
                                        class="inline-flex items-center justify-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold py-3 px-6 rounded-xl transition duration-200">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-book mr-3"></i>
                        Data Logbook
                    </h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-blue-50">
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Aktivitas</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Foto</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($logbooks as $l)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center text-sm text-gray-900">
                                                <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                                {{ \Carbon\Carbon::parse($l->date)->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if ($l->intern->photo_path)
                                                    <img src="{{ url('storage/' . $l->intern->photo_path) }}"
                                                        class="w-8 h-8 rounded-full object-cover border-2 border-blue-200 mr-3"
                                                        alt="{{ $l->intern->name }}" />
                                                @else
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center mr-3">
                                                        <i class="fas fa-user text-white text-xs"></i>
                                                    </div>
                                                @endif
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ $l->intern->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600 max-w-md">
                                                <i class="fas fa-tasks mr-2 text-blue-500"></i>
                                                {{ $l->activity }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($l->photo_path)
                                                <img src="{{ url('storage/' . $l->photo_path) }}" alt="Logbook Photo"
                                                    class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all shadow-sm"
                                                    onclick="window.open('{{ url('storage/' . $l->photo_path) }}', '_blank')"
                                                    title="Klik untuk melihat full size" />
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('mentor.logbook.show', $l) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 shadow-sm hover:shadow-md transition-all duration-300">
                                                <i class="fas fa-eye mr-2"></i>
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <i class="fas fa-book-open text-5xl mb-3 text-gray-300"></i>
                                                <p class="text-sm font-medium">Tidak ada data logbook.</p>
                                                <p class="text-xs text-gray-400 mt-1">Coba ubah filter untuk melihat data
                                                    lainnya</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $logbooks->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
