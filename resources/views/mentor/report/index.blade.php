@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Laporan Akhir Anak Bimbingan</h1>

            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
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
                    <label class="block text-sm text-gray-600 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded">
                        <option value="">Semua</option>
                        <option value="pending" @selected(request('status')==='pending')>Pending</option>
                        <option value="approved" @selected(request('status')==='approved')>Approved</option>
                        <option value="rejected" @selected(request('status')==='rejected')>Rejected</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Perlu Revisi?</label>
                    <select name="needs_revision" class="w-full px-3 py-2 border rounded">
                        <option value="">Semua</option>
                        <option value="1" @selected(request('needs_revision')==='1')>Ya</option>
                        <option value="0" @selected(request('needs_revision')==='0')>Tidak</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Filter</button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revisi?</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dikirim</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reports as $r)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $r->intern->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ url('storage/'.$r->file_path) }}" target="_blank" class="text-blue-600 hover:underline">{{ $r->file_name }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $r->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($r->grade)
                                    <span class="font-semibold">{{ $r->grade }}</span>
                                    @if($r->score)
                                        <span class="text-gray-500 text-xs">({{ $r->score }})</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $r->needs_revision ? 'Ya' : 'Tidak' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $r->submitted_at ? \Carbon\Carbon::parse($r->submitted_at)->format('d M Y H:i') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(!$r->grade)
                                    <a href="{{ route('mentor.report.show', $r) }}" class="text-indigo-600 hover:underline">Beri Nilai</a>
                                @else
                                    <a href="{{ route('mentor.report.show', $r) }}" class="text-blue-600 hover:underline">Lihat</a>
                                @endif
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
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


