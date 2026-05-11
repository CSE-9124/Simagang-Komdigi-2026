@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Daftar Peserta: {{ $micro->judul_micro }}</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-blue-50">
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 uppercase">Institusi</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 uppercase">Dikirim</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 uppercase">Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($submissions as $s)
                            <tr>
                                <td class="px-6 py-4">{{ $s->intern->name }}</td>
                                <td class="px-6 py-4">{{ $s->intern->institution }}</td>
                                <td class="px-6 py-4">{{ $s->submitted_at ? \Carbon\Carbon::parse($s->submitted_at)->format('d/m/Y H:i') : '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($s->photo_path)
                                        @php $microSkillFilename = basename($s->photo_path); @endphp
                                        @php $microSkillUrl = URL::temporarySignedRoute('mentor.microskill.photo', now()->addSeconds(30), ['filename' => $microSkillFilename]); @endphp
                                        <a href="{{ $microSkillUrl }}" target="_blank" class="text-blue-600">Lihat Bukti</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada peserta yang mengerjakan micro skill ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $submissions->links() }}</div>
            <div class="mt-4">
                <a href="{{ route('mentor.microskill.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Kembali ke daftar micro skill</a>
            </div>
        </div>
    </div>
</div>
@endsection
