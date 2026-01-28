@extends('layouts.app')

@section('title', 'Monitoring Bulanan - Sistem Magang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Alert Messages -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 alert alert-success">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 alert alert-error">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Monitoring Bulanan Anak Magang</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.monitoring.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

                <!-- Bulan -->
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 mb-1">
                        Pilih Bulan
                    </label>
                    <input
                        type="month"
                        name="month"
                        id="month"
                        value="{{ $selectedMonth }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status Anak Magang
                    </label>
                    <select
                        name="status"
                        id="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">Semua</option>
                        <option value="masuk" {{ $selectedStatus === 'masuk' ? 'selected' : '' }}>Masuk</option>
                        <option value="aktif" {{ $selectedStatus === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="akan_pelepasan" {{ $selectedStatus === 'akan_pelepasan' ? 'selected' : '' }}>Akan Pelepasan</option>
                        <option value="pelepasan" {{ $selectedStatus === 'pelepasan' ? 'selected' : '' }}>Pelepasan</option>
                    </select>
                </div>

                <!-- Mentor -->
                <div>
                    <label for="mentor_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Mentor
                    </label>
                    <select
                        name="mentor_id"
                        id="mentor_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">Semua Mentor</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id }}" {{ $selectedMentor == $mentor->id ? 'selected' : '' }}>
                                {{ $mentor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kampus -->
                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700 mb-1">
                        Kampus
                    </label>
                    <select
                        name="institution"
                        id="institution"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">Semua Kampus</option>
                        @foreach($institutions as $inst)
                            <option value="{{ $inst }}" {{ request('institution') === $inst ? 'selected' : '' }}>
                                {{ $inst }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="flex-1 h-[42px] bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>

                    <a
                        href="{{ route('admin.monitoring.index') }}"
                        class="flex-1 h-[42px] bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-md flex items-center justify-center">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </a>
                </div>

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
                    <p class="text-sm font-medium text-gray-500">Masuk {{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $masukCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <i class="fas fa-user-minus text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Keluar {{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $keluarCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Aktif {{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $aktifCount }}</p>
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

    <!-- Filtered Results / Default View - Always Shown -->
    <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold text-gray-900">
        @if($selectedStatus === 'masuk')
            <i class="fas fa-user-plus mr-2 text-blue-500"></i>
        @elseif($selectedStatus === 'aktif')
            <i class="fas fa-users mr-2 text-green-500"></i>
        @elseif($selectedStatus === 'akan_pelepasan')
            <i class="fas fa-clock mr-2 text-yellow-500"></i>
        @elseif($selectedStatus === 'pelepasan')
            <i class="fas fa-graduation-cap mr-2 text-orange-500"></i>
        @else
            <i class="fas fa-search mr-2 text-blue-500"></i>
        @endif

        Anak Magang

        @if($selectedStatus !== 'all')
            <span class="text-sm font-normal text-gray-500">
                (Status:
                @if($selectedStatus === 'masuk')
                    Masuk
                @elseif($selectedStatus === 'aktif')
                    Aktif
                @elseif($selectedStatus === 'akan_pelepasan')
                    Akan Pelepasan
                @elseif($selectedStatus === 'pelepasan')
                    Pelepasan
                @endif
                )
            </span>
        @endif

        @if($selectedMentor)
            <span class="text-sm font-normal text-gray-500">(Mentor: Terpilih)</span>
        @endif
    </h2>

    <form method="GET" action="{{ route('admin.monitoring.export') }}">
        <input type="hidden" name="month" value="{{ request('month') }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="hidden" name="mentor_id" value="{{ request('mentor_id') }}">
        <input type="hidden" name="institution" value="{{ request('institution') }}">
        <input type="hidden" name="final_project" value="{{ request('final_project') }}">

        <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded whitespace-nowrap">
            <i class="fas fa-download mr-2"></i>Export Excel
        </button>
    </form>
</div>


        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kampus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mentor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Mulai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Rencana Pelepasan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($filteredInterns->count() > 0)
                        @foreach($filteredInterns as $index => $intern)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $filteredInterns->firstItem() + $index }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $intern->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($intern->is_active)
                                        @if(\Carbon\Carbon::now()->toDateString() <= $intern->end_date && $intern->end_date <= \Carbon\Carbon::now()->addDays(30)->toDateString())
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Akan Pelepasan
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @endif
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Pelepasan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $intern->institution }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $intern->mentor ? $intern->mentor->name : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $intern->start_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $intern->end_date ? \Carbon\Carbon::parse($intern->end_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 flex gap-2">
                                    <a href="{{ route('admin.intern.show', $intern->id) }}" class="text-blue-600 hover:text-blue-900 inline-block" title="Lihat detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($intern->is_active)
                                        <!-- Button untuk menandai sebagai pelepasan -->
                                        <button onclick="confirmRelease({{ $intern->id }}, '{{ $intern->name }}')" class="text-orange-600 hover:text-orange-900 inline-block" title="Tandai sebagai pelepasan">
                                            <i class="fas fa-graduation-cap"></i>
                                        </button>
                                        <form id="form-release-{{ $intern->id }}" action="{{ route('admin.monitoring.mark-released', $intern->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                    @else
                                        <!-- Button untuk mengembalikan status aktif -->
                                        <button onclick="confirmActive({{ $intern->id }}, '{{ $intern->name }}')" class="text-green-600 hover:text-green-900 inline-block" title="Kembalikan menjadi aktif">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                        <form id="form-active-{{ $intern->id }}" action="{{ route('admin.monitoring.mark-active', $intern->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <p class="text-gray-500 text-lg">
                                    <i class="fas fa-search mr-2"></i>Tidak ada data yang sesuai dengan filter Anda.
                                </p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($filteredInterns->count() > 0)
            <div class="mt-4">
                {{ $filteredInterns->links() }}
            </div>
        @endif
    </div>

    <!-- Chart Section -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Statistik 12 Bulan Terakhir</h2>
        <canvas id="monthlyChart" height="80"></canvas>
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

    // Confirmation function for releasing intern
    function confirmRelease(internId, internName) {
        if (confirm(`Yakin ingin menandai "${internName}" sebagai pelepasan?`)) {
            document.getElementById(`form-release-${internId}`).submit();
        }
    }

    // Confirmation function for marking active
    function confirmActive(internId, internName) {
        if (confirm(`Yakin ingin mengembalikan "${internName}" menjadi aktif?`)) {
            document.getElementById(`form-active-${internId}`).submit();
        }
    }

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    });
</script>
@endpush
@endsection