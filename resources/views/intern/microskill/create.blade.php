@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Upload Bukti Mikro Skill</h1>
            <form method="POST" action="{{ route('intern.microskill.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border rounded">
                    @error('title')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (opsional)</label>
                    <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded">{{ old('description') }}</textarea>
                    @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Bukti</label>
                    <input type="file" name="photo" accept="image/*" required class="w-full">
                    @error('photo')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('intern.microskill.index') }}" class="px-4 py-2 rounded border">Batal</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


