@extends('layouts.app')

@section('title', 'Absensi Baru - Sistem Magang')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Absensi Baru</h1>

        <form method="POST" action="{{ route('intern.attendance.store') }}" enctype="multipart/form-data" id="attendanceForm">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Absensi</label>
                <select name="status" id="status" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Status</option>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                </select>
                @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Hadir Section -->
            <div id="hadirSection" class="hidden mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Bukti Kehadiran</label>
                <div class="mb-4">
                    <video id="video" width="100%" height="auto" class="border rounded-lg hidden" autoplay playsinline></video>
                    <canvas id="canvas" class="hidden"></canvas>
                    <img id="capturedImage" class="w-full max-w-md mx-auto border rounded-lg hidden mb-4" alt="Captured image">
                </div>
                <div class="flex space-x-4 mb-4">
                    <button type="button" id="startCamera" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-camera mr-2"></i>Buka Kamera
                    </button>
                    <button type="button" id="capturePhoto" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded hidden">
                        <i class="fas fa-camera-retro mr-2"></i>Ambil Foto
                    </button>
                    <button type="button" id="stopCamera" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded hidden">
                        <i class="fas fa-stop mr-2"></i>Stop Kamera
                    </button>
                </div>
                <input type="file" name="photo" id="photo" accept="image/*" class="hidden">
                <input type="hidden" name="photo_data" id="photo_data" value="">
                @error('photo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Izin/Sakit Section -->
            <div id="izinSakitSection" class="hidden mb-6">
                <div class="mb-4">
                    <label for="note" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea name="note" id="note" rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('note')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="document" class="block text-sm font-medium text-gray-700 mb-2">Upload Dokumen Pendukung</label>
                    <input type="file" name="document" id="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Format: PDF, DOC, DOCX, JPG, PNG (Maks: 5MB)</p>
                    @error('document')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('intern.attendance.index') }}" class="text-blue-600 hover:text-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const statusSelect = document.getElementById('status');
    const hadirSection = document.getElementById('hadirSection');
    const izinSakitSection = document.getElementById('izinSakitSection');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const capturedImage = document.getElementById('capturedImage');
    const startCameraBtn = document.getElementById('startCamera');
    const capturePhotoBtn = document.getElementById('capturePhoto');
    const stopCameraBtn = document.getElementById('stopCamera');
    const photoInput = document.getElementById('photo');
    const photoData = document.getElementById('photo_data');
    let stream = null;

    statusSelect.addEventListener('change', function() {
        if (this.value === 'hadir') {
            hadirSection.classList.remove('hidden');
            izinSakitSection.classList.add('hidden');
            document.getElementById('note').removeAttribute('required');
            document.getElementById('document').removeAttribute('required');
        } else if (this.value === 'izin' || this.value === 'sakit') {
            hadirSection.classList.add('hidden');
            izinSakitSection.classList.remove('hidden');
            photoInput.removeAttribute('required');
            if (this.value === 'izin') {
                document.getElementById('note').setAttribute('required', 'required');
                document.getElementById('document').setAttribute('required', 'required');
            } else {
                document.getElementById('note').setAttribute('required', 'required');
                document.getElementById('document').removeAttribute('required');
            }
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
        } else {
            hadirSection.classList.add('hidden');
            izinSakitSection.classList.add('hidden');
        }
    });

    startCameraBtn.addEventListener('click', async function() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'user' },
                audio: false 
            });
            video.srcObject = stream;
            video.classList.remove('hidden');
            startCameraBtn.classList.add('hidden');
            capturePhotoBtn.classList.remove('hidden');
            stopCameraBtn.classList.remove('hidden');
        } catch (err) {
            alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
            console.error(err);
        }
    });

    capturePhotoBtn.addEventListener('click', function() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        
        const imageData = canvas.toDataURL('image/png');
        capturedImage.src = imageData;
        capturedImage.classList.remove('hidden');
        photoData.value = imageData;
        
        // Convert base64 to blob and create file
        fetch(imageData)
            .then(res => res.blob())
            .then(blob => {
                const file = new File([blob], 'attendance-photo.png', { type: 'image/png' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                photoInput.files = dataTransfer.files;
            });
    });

    stopCameraBtn.addEventListener('click', function() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        video.classList.add('hidden');
        startCameraBtn.classList.remove('hidden');
        capturePhotoBtn.classList.add('hidden');
        stopCameraBtn.classList.add('hidden');
    });

    document.getElementById('attendanceForm').addEventListener('submit', function(e) {
        if (statusSelect.value === 'hadir' && !photoData.value) {
            e.preventDefault();
            alert('Silakan ambil foto terlebih dahulu.');
            return false;
        }
        
        if (statusSelect.value === 'hadir' && stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    });
</script>
@endpush
@endsection
