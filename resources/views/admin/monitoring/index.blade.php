@extends('layouts.app')

@section('title', 'Monitoring Bulanan - Sistem Magang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Monitoring Bulanan Anak Magang</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.monitoring.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 mb-2">Pilih Bulan</label>
                <input type="month" name="month" id="month" value="{{ $selectedMonth }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded w-full">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
            <div class="flex items-end">
                <a href="{{ route('admin.monitoring.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded w-full text-center">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Masuk Bulan Ini</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $internsMasuk->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <i class="fas fa-user-minus text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Keluar Bulan Ini</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $internsKeluar->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Aktif</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $internsAktif->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pelepasan</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $internsPelepasan->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Statistik 12 Bulan Terakhir</h2>
        <canvas id="monthlyChart" height="80"></canvas>
    </div>

    <!-- Data Masuk -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-user-plus mr-2 text-blue-500"></i>
            Anak Magang yang Masuk ({{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }})
        </h2>
        @if($internsMasuk->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kampus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mentor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Mulai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($internsMasuk as $index => $intern)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $intern->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $intern->institution }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $intern->mentor ? $intern->mentor->name : 'Belum ada mentor' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $intern->start_date->format('d/m/Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Tidak ada anak magang yang masuk di bulan ini.</p>
        @endif
    </div>

    <!-- Data Keluar/Pelepasan -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-graduation-cap mr-2 text-orange-500"></i>
            Anak Magang yang Keluar/Pelepasan ({{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }})
        </h2>
        @if($internsPelepasan->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kampus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mentor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($internsPelepasan as $index => $intern)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $intern->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $intern->institution }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $intern->mentor ? $intern->mentor->name : 'Tidak ada mentor' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $intern->end_date->format('d/m/Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Tidak ada anak magang yang keluar di bulan ini.</p>
        @endif
    </div>

    <!-- Group by Institution -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-university mr-2 text-green-500"></i>
            Data Anak Magang Aktif per Kampus ({{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }})
        </h2>
        @if($groupByInstitution->count() > 0)
            <div class="space-y-4">
                @foreach($groupByInstitution as $group)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $group['institution'] }}</h3>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                {{ $group['count'] }} orang
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($group['interns'] as $intern)
                                <div class="text-sm text-gray-700">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>
                                    <strong>{{ $intern['name'] }}</strong>
                                    <span class="text-gray-500 ml-2">- Mentor: {{ $intern['mentor'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Tidak ada data anak magang aktif.</p>
        @endif
    </div>

    <!-- Top Institutions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-trophy mr-2 text-yellow-500"></i>
                Top 10 Institusi (Semua Waktu)
            </h2>
            @if($topInstitutions->count() > 0)
                <div class="space-y-3">
                    @foreach($topInstitutions as $index => $inst)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <span class="w-8 h-8 rounded-full bg-yellow-500 text-white flex items-center justify-center font-bold mr-3">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-medium text-gray-900">{{ $inst->institution }}</span>
                            </div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                {{ $inst->total }} orang
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada data.</p>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-star mr-2 text-blue-500"></i>
                Top Institusi Bulan Ini
            </h2>
            @if($topInstitutionsThisMonth->count() > 0)
                <div class="space-y-3">
                    @foreach($topInstitutionsThisMonth as $index => $inst)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <span class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold mr-3">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-medium text-gray-900">{{ $inst->institution }}</span>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                {{ $inst->total }} orang
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Tidak ada data untuk bulan ini.</p>
            @endif
        </div>
    </div>

    <!-- Group by Mentor -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-chalkboard-teacher mr-2 text-purple-500"></i>
            Data Anak Magang Aktif per Mentor ({{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }})
        </h2>
        @if($groupByMentor->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($groupByMentor as $group)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $group['mentor_name'] }}</h3>
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                {{ $group['count'] }} orang
                            </span>
                        </div>
                        <div class="space-y-2">
                            @foreach($group['interns'] as $intern)
                                <div class="text-sm text-gray-700">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>
                                    <strong>{{ $intern['name'] }}</strong>
                                    <span class="text-gray-500 ml-2">({{ $intern['institution'] }})</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Tidak ada data mentor dengan anak magang aktif.</p>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($monthlyStats);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => item.month),
            datasets: [
                {
                    label: 'Masuk',
                    data: monthlyData.map(item => item.masuk),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Keluar',
                    data: monthlyData.map(item => item.keluar),
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Aktif',
                    data: monthlyData.map(item => item.aktif),
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Tren Masuk, Keluar, dan Aktif Per Bulan'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection

