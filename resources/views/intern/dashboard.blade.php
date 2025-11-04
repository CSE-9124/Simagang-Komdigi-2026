@extends('layouts.app')

@section('title', 'Dashboard - Sistem Magang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
            @if($intern->photo_path)
                <img src="{{ url('storage/' . $intern->photo_path) }}" alt="{{ $intern->name }}" 
                    class="w-32 h-32 rounded-full object-cover border-4 border-blue-500">
            @else
                <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-user text-4xl text-gray-500"></i>
                </div>
            @endif
            <div class="text-center md:text-left flex-1">
                <h1 class="text-3xl font-bold text-gray-900">{{ $intern->name }}</h1>
                <p class="text-gray-600 mt-2">{{ $intern->institution }}</p>
                <p class="text-gray-500 text-sm mt-1">{{ $intern->education_level }} - {{ $intern->major }}</p>
                <div class="mt-3">
                    <a href="{{ route('intern.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Hari Hadir</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalHadir }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <i class="fas fa-calendar-times text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Izin</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalIzin }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <i class="fas fa-calendar-minus text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Sakit</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalSakit }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <i class="fas fa-file-alt text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Laporan</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $hasFinalReport ? 'Sudah' : 'Belum' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Mikro Skill</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $microSkillApproved }} / {{ $microSkillTotal }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Status Absensi Hari Ini</h2>
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
                <p class="text-gray-500 mb-4">Anda belum melakukan absensi hari ini.</p>
                <a href="{{ route('intern.attendance.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Absensi Sekarang
                </a>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Links</h2>
            <div class="space-y-3">
                <a href="{{ route('intern.attendance.index') }}" class="block w-full bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium py-3 px-4 rounded-lg transition">
                    <i class="fas fa-calendar-check mr-2"></i> Riwayat Absensi
                </a>
                <a href="{{ route('intern.logbook.index') }}" class="block w-full bg-green-50 hover:bg-green-100 text-green-700 font-medium py-3 px-4 rounded-lg transition">
                    <i class="fas fa-book mr-2"></i> Logbook Harian
                </a>
                <a href="{{ route('intern.report.index') }}" class="block w-full bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium py-3 px-4 rounded-lg transition">
                    <i class="fas fa-file-alt mr-2"></i> Laporan Akhir
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Leaderboard Mikro Skill (Top 10)</h2>
        @if(isset($topMicroSkills) && $topMicroSkills->count())
            <div class="space-y-3">
                @foreach($topMicroSkills as $index => $row)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold mr-3">{{ $index + 1 }}</span>
                            @if(!empty($row['photo_path']))
                                <img src="{{ url('storage/'.$row['photo_path']) }}" class="w-10 h-10 rounded-full object-cover border mr-3" />
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 mr-3"></div>
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900">{{ $row['name'] }}</div>
                                <div class="text-xs text-gray-500">{{ $row['institution'] }}</div>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold">{{ $row['total'] }} course</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Belum ada data.</p>
        @endif
        <div class="mt-4">
            <a href="{{ route('intern.microskill.leaderboard') }}" class="text-indigo-600 hover:underline">Lihat selengkapnya</a>
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
