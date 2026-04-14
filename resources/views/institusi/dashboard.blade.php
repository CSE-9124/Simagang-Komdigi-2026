@extends('layouts.app')

@section('title', 'Dashboard - Sistem Magang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Profile Header --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">

                    {{-- Avatar --}}
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center border-4 border-white shadow-lg flex-shrink-0">
                        <i class="fas fa-user text-4xl text-white"></i>
                    </div>

                    {{-- Info --}}
                    <div class="text-center md:text-left">
                        <h1 class="text-2xl font-semibold text-white mb-2">{{$institusi->user->name}}</h1>
                        <p class="text-blue-100 font-semibold text-lg mb-1">{{ $institusi->nama_institusi }}</p>
                        <p class="text-blue-100 text-sm mb-1">{{ $institusi->nomor_identitas }}</p>
                        <p class="text-blue-100 text-sm mb-1">{{ $institusi->no_hp }}</p>

                        @if ($institusi->jenis_institusi === 'kampus')
                            <p class="text-blue-100 text-sm mb-4">
                                {{ $institusi->fakultas }} - {{ $institusi->departemen }}
                            </p>
                        @endif

                        <a href="#" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-all duration-300 shadow-md mt-3">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

            @php
                $stats = [
                    ['label' => 'Total Pengajuan', 'value' => 20, 'color' => 'blue',   'icon' => 'fa-calendar-check'],
                    ['label' => 'Disetujui',        'value' => 12, 'color' => 'yellow', 'icon' => 'fa-calendar-times'],
                    ['label' => 'Menunggu Approval','value' => 8,  'color' => 'red',    'icon' => 'fa-calendar-minus'],
                    ['label' => 'Ditolak',          'value' => 0,  'color' => 'green',  'icon' => 'fa-file-alt'],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-4 sm:p-6 flex items-center justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-700 truncate">{{ $stat['label'] }}</p>
                            <p class="text-xl font-semibold text-gray-900 truncate">{{ $stat['value'] }}</p>
                        </div>
                        <div class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-{{ $stat['color'] }}-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas {{ $stat['icon'] }} text-white text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                    <div class="h-1 bg-{{ $stat['color'] }}-500"></div>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection