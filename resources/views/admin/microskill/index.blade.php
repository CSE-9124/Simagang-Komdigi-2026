@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">Mikro Skill Intern</h1>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Cari (nama/institusi)</label>
            <input type="text" name="q" value="{{ request('q') }}" class="w-full px-3 py-2 border rounded" placeholder="Ketik untuk mencari..." />
        </div>
        <div class="flex items-end">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Filter</button>
        </div>
    </form>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Institusi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dikirim</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($submissions as $s)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $s->intern->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $s->intern->institution }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $s->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $s->submitted_at ? \Carbon\Carbon::parse($s->submitted_at)->format('d M Y H:i') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ url('storage/'.$s->photo_path) }}" class="w-12 h-12 object-cover rounded border cursor-pointer" onclick="window.open('{{ url('storage/'.$s->photo_path) }}','_blank')">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $submissions->links() }}</div>
        </div>
    </div>
</div>
@endsection


