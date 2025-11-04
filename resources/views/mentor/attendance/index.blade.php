@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Absensi Anak Bimbingan</h1>

            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Anak Magang</label>
                    <select name="intern_id" class="w-full px-3 py-2 border rounded">
                        <option value="">Semua</option>
                        @foreach($interns as $intern)
                            <option value="{{ $intern->id }}" @selected(request('intern_id')==$intern->id)>{{ $intern->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 border rounded" />
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Hingga Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-3 py-2 border rounded" />
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded">
                        <option value="">Semua</option>
                        <option value="hadir" @selected(request('status')==='hadir')>Hadir</option>
                        <option value="izin" @selected(request('status')==='izin')>Izin</option>
                        <option value="sakit" @selected(request('status')==='sakit')>Sakit</option>
                        <option value="alfa" @selected(request('status')==='alfa')>Alfa</option>
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Filter</button>
                    <a href="{{ route('mentor.attendance.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Reset</a>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Out</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto Out</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($attendances as $a)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $a->intern->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $a->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $a->check_in ? \Carbon\Carbon::parse($a->check_in)->format('H:i') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $a->check_out ? \Carbon\Carbon::parse($a->check_out)->format('H:i') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($a->photo_path)
                                    <img src="{{ url('storage/'.$a->photo_path) }}" class="w-10 h-10 object-cover rounded border cursor-pointer" onclick="window.open('{{ url('storage/'.$a->photo_path) }}','_blank')" />
                                @else - @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($a->photo_checkout)
                                    <img src="{{ url('storage/'.$a->photo_checkout) }}" class="w-10 h-10 object-cover rounded border cursor-pointer" onclick="window.open('{{ url('storage/'.$a->photo_checkout) }}','_blank')" />
                                @else - @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


