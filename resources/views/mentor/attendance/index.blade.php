@extends('layouts.app')

@section('title', 'Absensi Anak Bimbingan - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">


            <div class="mb-4 sm:mb-8">
                <h1 class="text-4xl font-bold text-blue-600 mb-3">
                    Absensi Anak Bimbingan
                </h1>
                <p class="text-sm sm:text-base text-gray-600">Pantau dan kelola data kehadiran anak magang</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden mb-4 sm:mb-6">
                <div class="bg-blue-600 px-4 sm:px-6 py-3 sm:py-4">
                    <h2 class="text-lg sm:text-xl font-bold text-white flex items-center">
                        <i class="fas fa-filter mr-2 sm:mr-3 text-sm sm:text-base"></i>
                        <span class="text-base sm:text-xl">Filter Data</span>
                    </h2>
                </div>
                <div class="p-4 sm:p-6">
                    <form method="GET" action="{{ route('mentor.attendance.index') }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4 mb-3 sm:mb-4">

                            <div class="sm:col-span-2 lg:col-span-1">
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user mr-1 text-blue-500 text-xs sm:text-sm"></i>
                                    <span class="text-xs sm:text-sm">Anak Magang</span>
                                </label>
                                <select name="intern_id"
                                    class="w-full px-2 sm:px-3 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <option value="">Semua</option>
                                    @foreach ($interns as $intern)
                                        <option value="{{ $intern->id }}" @selected(request('intern_id') == $intern->id)>{{ $intern->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-1 text-green-500 text-xs sm:text-sm"></i>
                                    <span class="text-xs sm:text-sm">Dari Tanggal</span>
                                </label>
                                <input type="date" name="date_from" value="{{ request('date_from') }}"
                                    class="w-full px-2 sm:px-3 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" />
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-check mr-1 text-purple-500 text-xs sm:text-sm"></i>
                                    <span class="text-xs sm:text-sm">Hingga Tanggal</span>
                                </label>
                                <input type="date" name="date_to" value="{{ request('date_to') }}"
                                    class="w-full px-2 sm:px-3 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" />
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-info-circle mr-1 text-yellow-500 text-xs sm:text-sm"></i>
                                    <span class="text-xs sm:text-sm">Status</span>
                                </label>
                                <select name="status"
                                    class="w-full px-2 sm:px-3 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <option value="">Semua</option>
                                    <option value="hadir" @selected(request('status') === 'hadir')>Hadir</option>
                                    <option value="izin" @selected(request('status') === 'izin')>Izin</option>
                                    <option value="sakit" @selected(request('status') === 'sakit')>Sakit</option>
                                    <option value="alfa" @selected(request('status') === 'alfa')>Alfa</option>
                                </select>
                            </div>

                            <div class="flex items-end space-x-2 sm:col-span-2 lg:col-span-1">
                                <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center px-3 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white text-sm sm:text-base font-semibold rounded-xl hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300">
                                    <i class="fas fa-search mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                                    <span class="text-xs sm:text-base">Filter</span>
                                </button>
                                @if (request()->anyFilled(['intern_id', 'date_from', 'date_to', 'status']))
                                    <a href="{{ route('mentor.attendance.index') }}"
                                        class="inline-flex items-center justify-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold py-2 sm:py-3 px-3 sm:px-6 rounded-xl transition duration-200">
                                        <i class="fas fa-times text-xs sm:text-sm"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 sm:px-6 py-3 sm:py-4">
                    <h2 class="text-lg sm:text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clipboard-list mr-2 sm:mr-3 text-sm sm:text-base"></i>
                        <span class="text-base sm:text-xl">Data Absensi</span>
                    </h2>
                </div>
                <div class="p-3 sm:p-6">
                    <div class="overflow-x-auto -mx-3 sm:mx-0">
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-blue-50">
                                        <th
                                            class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tl-lg whitespace-nowrap">
                                            Tanggal</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider whitespace-nowrap">
                                            Nama</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider whitespace-nowrap">
                                            Status</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider whitespace-nowrap">
                                            Check In</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider whitespace-nowrap">
                                            Check Out</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider whitespace-nowrap">
                                            Foto In</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider rounded-tr-lg whitespace-nowrap">
                                            Foto Out</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($attendances as $a)
                                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <div class="flex items-center text-xs sm:text-sm text-gray-900">
                                                    <i class="fas fa-calendar mr-1 sm:mr-2 text-gray-400 text-xs"></i>
                                                    <span
                                                        class="hidden sm:inline">{{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}</span>
                                                    <span
                                                        class="sm:hidden">{{ \Carbon\Carbon::parse($a->date)->format('d/m/y') }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if ($a->intern->photo_path)
                                                        <img src="{{ url('storage/' . $a->intern->photo_path) }}"
                                                            class="w-6 h-6 sm:w-8 sm:h-8 rounded-full object-cover border-2 border-blue-200 mr-2 sm:mr-3 flex-shrink-0"
                                                            alt="{{ $a->intern->name }}" />
                                                    @else
                                                        <div
                                                            class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                                                            <i class="fas fa-user text-white text-xs"></i>
                                                        </div>
                                                    @endif
                                                    <span
                                                        class="text-xs sm:text-sm font-medium text-gray-900 truncate max-w-[100px] sm:max-w-none">{{ $a->intern->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 sm:px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                                @if ($a->status == 'hadir') bg-green-100 text-green-800
                                                @elseif($a->status == 'izin') bg-yellow-100 text-yellow-800
                                                @elseif($a->status == 'sakit') bg-red-100 text-red-800
                                                @else bg-gray-200 text-gray-800 @endif">
                                                    {{ $a->status }}
                                                </span>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                                                    <i class="fas fa-sign-in-alt mr-1 sm:mr-2 text-green-500 text-xs"></i>
                                                    {{ $a->check_in ? \Carbon\Carbon::parse($a->check_in)->format('H:i') : '-' }}
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                                                    <i class="fas fa-sign-out-alt mr-1 sm:mr-2 text-red-500 text-xs"></i>
                                                    {{ $a->check_out ? \Carbon\Carbon::parse($a->check_out)->format('H:i') : '-' }}
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                @if ($a->photo_path)
                                                    <img src="{{ url('storage/' . $a->photo_path) }}" alt="Check In"
                                                        class="w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all shadow-sm"
                                                        onclick="window.open('{{ url('storage/' . $a->photo_path) }}', '_blank')"
                                                        title="Klik untuk melihat full size" />
                                                @else
                                                    <span class="text-gray-400 text-xs sm:text-sm">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                @if ($a->photo_checkout)
                                                    <img src="{{ url('storage/' . $a->photo_checkout) }}" alt="Check Out"
                                                        class="w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:border-blue-400 transition-all shadow-sm"
                                                        onclick="window.open('{{ url('storage/' . $a->photo_checkout) }}', '_blank')"
                                                        title="Klik untuk melihat full size" />
                                                @else
                                                    <span class="text-gray-400 text-xs sm:text-sm">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-3 sm:px-6 py-6 sm:py-8 text-center">
                                                <div class="flex flex-col items-center justify-center text-gray-500">
                                                    <i
                                                        class="fas fa-inbox text-4xl sm:text-5xl mb-2 sm:mb-3 text-gray-300"></i>
                                                    <p class="text-xs sm:text-sm font-medium">Tidak ada data absensi.</p>
                                                    <p class="text-xs text-gray-400 mt-1">Coba ubah filter untuk melihat
                                                        data lainnya</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-6">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
