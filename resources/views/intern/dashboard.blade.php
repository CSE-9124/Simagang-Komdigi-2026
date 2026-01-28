@extends('layouts.app')

@section('title', 'Dashboard - Sistem Magang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Profile Header -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
                    @if($intern->photo_path)
                        <img src="{{ url('storage/' . $intern->photo_path) }}" alt="{{ $intern->name }}" 
                            class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center border-4 border-white shadow-lg">
                            <i class="fas fa-user text-4xl text-white"></i>
                        </div>
                    @endif
                    <div class="text-center md:text-left flex-1">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $intern->name }}</h1>
                        <p class="text-blue-100 mb-1">{{ $intern->institution }}</p>
                        <p class="text-blue-100 text-sm mb-4">{{ $intern->education_level }} - {{ $intern->major }}</p>
                        <div class="flex flex-col md:flex-row gap-3">
                            <a href="{{ route('intern.profile.edit') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-all duration-300 shadow-md">
                                <i class="fas fa-edit mr-2"></i>Edit Profile
                            </a>
                            @if (
                                $certificate &&
                                ($certificate->issue_date->isToday() || $certificate->issue_date->isPast())
                            )
                                <a href="{{ route('intern.certificates.print', $certificate->id) }}" target="_blank"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-yellow-400 text-gray-900 font-semibold rounded-lg hover:bg-yellow-300 transition-all duration-300 shadow-md">
                                    <i class="fas fa-certificate mr-2"></i>Lihat Sertifikat
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Card 1: Hari Hadir -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 truncate">Hari Hadir</p>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalHadir }}</dd>
                        </div>
                        <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar-check text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-blue-500"></div>
            </div>

            <!-- Card 2: Izin -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 truncate">Izin</p>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalIzin }}</dd>
                        </div>
                        <div class="w-16 h-16 bg-yellow-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar-times text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-yellow-500"></div>
            </div>

            <!-- Card 3: Sakit -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 truncate">Sakit</p>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalSakit }}</dd>
                        </div>
                        <div class="w-16 h-16 bg-red-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar-minus text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-red-500"></div>
            </div>

            <!-- Card 4: Laporan -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 truncate">Laporan</p>
                            <dd class="text-lg font-medium text-gray-900">{{ $hasFinalReport ? 'Sudah' : 'Belum' }}</dd>
                        </div>
                        <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-alt text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-green-500"></div>
            </div>

            <!-- Card 5: Mikro Skill -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 truncate">Mikro Skill</p>
                            <dd class="text-lg font-medium text-gray-900">{{ $microSkillApproved }} / {{ $microSkillTotal }}</dd>
                        </div>
                        <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-graduation-cap text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-purple-500"></div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Today's Attendance Status -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clipboard-check mr-3"></i>
                        Status Absensi Hari Ini
                    </h2>
                </div>
                <div class="p-6">
                    @if($todayAttendance)
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">Status:</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($todayAttendance->status == 'hadir') bg-green-100 text-green-800
                                    @elseif($todayAttendance->status == 'izin') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($todayAttendance->status) }}
                                </span>
                            </div>
                            @if($todayAttendance->status == 'hadir')
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Check In:</span>
                                    <span class="text-gray-900 font-medium">{{ $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') : '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Check Out:</span>
                                    <span class="text-gray-900 font-medium">{{ $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') : '-' }}</span>
                                </div>
                                @if(!$todayAttendance->check_out)
                                    <button onclick="document.getElementById('checkoutModal').classList.remove('hidden')" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                                        Check Out
                                    </button>
                                @endif
                                
                                @if($todayAttendance->photo_path)
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-600 mb-2">Foto Check In:</p>
                                        <img src="{{ url('storage/' . $todayAttendance->photo_path) }}" alt="Check In Photo" class="w-full max-w-xs border rounded-lg">
                                    </div>
                                @endif
                                
                                @if($todayAttendance->photo_checkout)
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-600 mb-2">Foto Check Out:</p>
                                        <img src="{{ url('storage/' . $todayAttendance->photo_checkout) }}" alt="Check Out Photo" class="w-full max-w-xs border rounded-lg">
                                    </div>
                                @endif
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <p class="text-sm text-gray-500 mb-6">Anda belum melakukan absensi hari ini.</p>
                            <a href="{{ route('intern.attendance.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all duration-300">
                                <i class="fas fa-calendar-plus mr-2"></i>Absensi Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-link mr-3"></i>
                        Quick Links
                    </h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('intern.attendance.index') }}" class="block w-full p-3 bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium rounded-lg transition-all duration-300 border border-blue-200 hover:border-blue-300">
                        <i class="fas fa-calendar-check mr-2"></i>Riwayat Absensi
                    </a>
                    <a href="{{ route('intern.logbook.index') }}" class="block w-full p-3 bg-green-50 hover:bg-green-100 text-green-700 font-medium rounded-lg transition-all duration-300 border border-green-200 hover:border-green-300">
                        <i class="fas fa-book mr-2"></i>Logbook Harian
                    </a>
                    <a href="{{ route('intern.report.index') }}" class="block w-full p-3 bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium rounded-lg transition-all duration-300 border border-purple-200 hover:border-purple-300">
                        <i class="fas fa-file-alt mr-2"></i>Laporan Akhir
                    </a>
                </div>
            </div>
        </div>

        <!-- Leaderboard Mikro Skill -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-trophy mr-3"></i>
                    Leaderboard Mikro Skill (Top 10)
                </h2>
            </div>
            <div class="p-6">
                @if(isset($topMicroSkills) && $topMicroSkills->count())
                    <div class="space-y-3">
                        @foreach($topMicroSkills as $index => $row)
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:shadow-md transition-all duration-300 border border-blue-100">
                                <div class="flex items-center">
                                    <!-- Rank Badge -->
                                    <div class="relative">
                                        <span class="w-8 h-8 rounded-full 
                                            @if($index == 0) bg-yellow-500
                                            @elseif($index == 1) bg-gray-400
                                            @elseif($index == 2) bg-orange-500
                                            @else bg-indigo-500
                                            @endif
                                            text-white flex items-center justify-center font-bold text-sm shadow-lg mr-3">
                                            {{ $index + 1 }}
                                        </span>
                                        @if($index < 3)
                                            <i class="fas fa-crown absolute -top-2 -right-1 text-yellow-500 text-xs"></i>
                                        @endif
                                    </div>
                                    
                                    <!-- Photo -->
                                    @if(!empty($row['photo_path']))
                                        <img src="{{ url('storage/'.$row['photo_path']) }}" 
                                             class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-md mr-3" />
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-3 shadow-md">
                                            <i class="fas fa-user text-gray-500 text-xs"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Info -->
                                    <div>
                                        <div class="font-semibold text-gray-900 text-sm">{{ $row['name'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $row['institution'] }}</div>
                                    </div>
                                </div>
                                
                                <!-- Score Badge -->
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-star mr-1"></i>
                                    {{ $row['total'] }} course
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 text-center">
                        <a href="{{ route('intern.microskill.leaderboard') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all duration-300">
                            <span>Lihat Selengkapnya</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                        <i class="fas fa-chart-line text-4xl mb-3 text-gray-300"></i>
                        <p class="text-sm">Belum ada data.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Check Out dengan Foto</h3>
            <form action="{{ route('intern.attendance.checkout') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                @csrf
                <div class="mb-4">
                    <video id="checkoutVideo" width="100%" height="auto" class="border rounded-lg hidden" autoplay playsinline></video>
                    <canvas id="checkoutCanvas" class="hidden"></canvas>
                    <img id="checkoutCapturedImage" class="w-full max-w-md mx-auto border rounded-lg hidden mb-4" alt="Captured image">
                </div>
                <div class="flex space-x-4 mb-4">
                    <button type="button" id="checkoutStartCamera" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-camera mr-2"></i>Buka Kamera
                    </button>
                    <button type="button" id="checkoutCapturePhoto" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded hidden">
                        <i class="fas fa-camera-retro mr-2"></i>Ambil Foto
                    </button>
                    <button type="button" id="checkoutStopCamera" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded hidden">
                        <i class="fas fa-stop mr-2"></i>Stop
                    </button>
                </div>
                <input type="file" name="photo" id="checkoutPhoto" accept="image/*" class="hidden">
                <input type="hidden" name="photo_data" id="checkoutPhotoData" value="">
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('checkoutModal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Check Out
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const checkoutVideo = document.getElementById('checkoutVideo');
    const checkoutCanvas = document.getElementById('checkoutCanvas');
    const checkoutCapturedImage = document.getElementById('checkoutCapturedImage');
    const checkoutStartCameraBtn = document.getElementById('checkoutStartCamera');
    const checkoutCapturePhotoBtn = document.getElementById('checkoutCapturePhoto');
    const checkoutStopCameraBtn = document.getElementById('checkoutStopCamera');
    const checkoutPhotoInput = document.getElementById('checkoutPhoto');
    const checkoutPhotoData = document.getElementById('checkoutPhotoData');
    let checkoutStream = null;

    checkoutStartCameraBtn.addEventListener('click', async function() {
        try {
            checkoutStream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'user' },
                audio: false 
            });
            checkoutVideo.srcObject = checkoutStream;
            checkoutVideo.classList.remove('hidden');
            checkoutStartCameraBtn.classList.add('hidden');
            checkoutCapturePhotoBtn.classList.remove('hidden');
            checkoutStopCameraBtn.classList.remove('hidden');
        } catch (err) {
            alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
            console.error(err);
        }
    });

    checkoutCapturePhotoBtn.addEventListener('click', function() {
        checkoutCanvas.width = checkoutVideo.videoWidth;
        checkoutCanvas.height = checkoutVideo.videoHeight;
        checkoutCanvas.getContext('2d').drawImage(checkoutVideo, 0, 0);
        
        const imageData = checkoutCanvas.toDataURL('image/png');
        checkoutCapturedImage.src = imageData;
        checkoutCapturedImage.classList.remove('hidden');
        checkoutPhotoData.value = imageData;
        
        fetch(imageData)
            .then(res => res.blob())
            .then(blob => {
                const file = new File([blob], 'checkout-photo.png', { type: 'image/png' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                checkoutPhotoInput.files = dataTransfer.files;
            });
    });

    checkoutStopCameraBtn.addEventListener('click', function() {
        if (checkoutStream) {
            checkoutStream.getTracks().forEach(track => track.stop());
            checkoutStream = null;
        }
        checkoutVideo.classList.add('hidden');
        checkoutStartCameraBtn.classList.remove('hidden');
        checkoutCapturePhotoBtn.classList.add('hidden');
        checkoutStopCameraBtn.classList.add('hidden');
    });

    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        if (!checkoutPhotoData.value && !checkoutPhotoInput.files.length) {
            e.preventDefault();
            alert('Silakan ambil foto terlebih dahulu.');
            return false;
        }
        
        if (checkoutStream) {
            checkoutStream.getTracks().forEach(track => track.stop());
        }
    });
</script>
@endpush
@endsection