@extends('layouts.app')

@section('title', 'Absensi Baru - Sistem Magang')

@section('content')
    <div class="min-h-screen bg-blue-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-blue-600 mb-2">Absensi Baru</h1>
                <p class="text-gray-600">Catat kehadiran Anda hari ini</p>
            </div>

            <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clipboard-check mr-3"></i>
                        Form Absensi
                    </h2>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('intern.attendance.store') }}" enctype="multipart/form-data"
                        id="attendanceForm">
                        @csrf

                        <!-- Status Absensi -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-info-circle mr-1 text-blue-500"></i> Status Absensi
                            </label>
                            <select name="status" id="status" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option value="">Pilih Status</option>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                        class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hadir Section -->
                        <div id="hadirSection" class="hidden">
                            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6 mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-4">
                                    <i class="fas fa-camera mr-1 text-blue-500"></i> Foto Bukti Kehadiran
                                </label>

                                <!-- Camera Display -->
                                <div class="mb-4">
                                    <video id="video" width="100%" height="auto"
                                        class="border-2 border-blue-300 rounded-lg hidden shadow-md transform -scale-x-100"
                                        autoplay playsinline></video>
                                    <canvas id="canvas" class="hidden"></canvas>
                                    <img id="capturedImage"
                                        class="w-full max-w-md mx-auto border-2 border-green-300 rounded-lg hidden mb-4 shadow-md"
                                        alt="Captured image">
                                </div>

                                <!-- Camera Controls -->
                                <div class="flex flex-wrap gap-3 mb-4">
                                    <button type="button" id="startCamera"
                                        class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                        <i class="fas fa-camera mr-2"></i>Buka Kamera
                                    </button>
                                    <button type="button" id="capturePhoto"
                                        class="hidden inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                        <i class="fas fa-camera-retro mr-2"></i>Ambil Foto
                                    </button>
                                    <button type="button" id="stopCamera"
                                        class="hidden inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                        <i class="fas fa-stop mr-2"></i>Stop Kamera
                                    </button>
                                </div>

                                <input type="file" name="photo" id="photo" accept="image/*" class="hidden">
                                <input type="hidden" name="photo_data" id="photo_data" value="">
                                @error('photo')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror

                                <div class="mt-4 bg-blue-100 border border-blue-300 rounded-lg p-3">
                                    <p class="text-xs text-blue-800 flex items-start">
                                        <i class="fas fa-info-circle mr-2 mt-0.5"></i>
                                        <span>Pastikan wajah Anda terlihat jelas pada foto. Foto akan digunakan sebagai
                                            bukti kehadiran.</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Izin/Sakit Section -->
                        <div id="izinSakitSection" class="hidden">
                            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6 mb-6">
                                <!-- Keterangan -->
                                <div class="mb-6">
                                    <label for="note" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-edit mr-1 text-yellow-500"></i> Keterangan
                                    </label>
                                    <textarea name="note" id="note" rows="4" placeholder="Jelaskan alasan izin/sakit Anda..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all"></textarea>
                                    @error('note')
                                        <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Upload Document -->
                                <div>
                                    <label for="document" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-file-upload mr-1 text-yellow-500"></i> Upload Dokumen Pendukung
                                    </label>
                                    <div class="relative">
                                        <input type="file" name="document" id="document"
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-100 file:text-yellow-700 hover:file:bg-yellow-200">
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Format: PDF, DOC, DOCX, JPG, PNG (Maks: 5MB)
                                    </p>
                                    @error('document')
                                        <p class="mt-2 text-sm text-red-600 flex items-center"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4 bg-yellow-100 border border-yellow-300 rounded-lg p-3">
                                    <p class="text-xs text-yellow-800 flex items-start">
                                        <i class="fas fa-exclamation-triangle mr-2 mt-0.5"></i>
                                        <span>Untuk izin, wajib melampirkan dokumen pendukung. Untuk sakit, dokumen opsional
                                            tetapi disarankan.</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div
                            class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('intern.attendance.index') }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                            </a>
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                                <i class="fas fa-save mr-2"></i>Simpan Absensi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <!-- Hadir Info -->
                <div
                    class="bg-white rounded-xl shadow-md border border-green-200 p-4 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-check text-green-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-gray-900">Hadir</h3>
                            <p class="text-xs text-gray-600 mt-1">Wajib upload foto kehadiran</p>
                        </div>
                    </div>
                </div>

                <!-- Izin Info -->
                <div
                    class="bg-white rounded-xl shadow-md border border-yellow-200 p-4 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-times text-yellow-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-gray-900">Izin</h3>
                            <p class="text-xs text-gray-600 mt-1">Wajib keterangan & dokumen</p>
                        </div>
                    </div>
                </div>

                <!-- Sakit Info -->
                <div
                    class="bg-white rounded-xl shadow-md border border-red-200 p-4 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-minus text-red-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-gray-900">Sakit</h3>
                            <p class="text-xs text-gray-600 mt-1">Wajib keterangan, dokumen opsional</p>
                        </div>
                    </div>
                </div>
            </div>

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
                        video: {
                            facingMode: 'user'
                        },
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
                const ctx = canvas.getContext('2d');
                // Flip horizontally to undo the video mirror
                ctx.scale(-1, 1);
                ctx.drawImage(video, -video.videoWidth, 0);

                const imageData = canvas.toDataURL('image/png');
                capturedImage.src = imageData;
                capturedImage.classList.remove('hidden');
                photoData.value = imageData;

                // Convert base64 to blob and create file
                fetch(imageData)
                    .then(res => res.blob())
                    .then(blob => {
                        const file = new File([blob], 'attendance-photo.png', {
                            type: 'image/png'
                        });
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
