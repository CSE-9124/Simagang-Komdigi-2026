<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Services\TimeService;

class AttendanceController extends Controller
{
    public function index()
    {
        $intern = Auth::user()->intern;
        $attendances = Attendance::where('intern_id', $intern->id)
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('intern.attendance.index', compact('attendances'));
    }

    public function create()
    {
        $intern = Auth::user()->intern;
        
        // Gunakan waktu server WITA (Asia/Makassar)
        $nowWita = TimeService::nowWita();
        $todayWita = $nowWita->toDateString();

        // Batasi akses form check-in sesuai waktu WITA (default 08:00-12:00)
        $checkInStart = env('ATTENDANCE_CHECKIN_START', '08:00');
        $checkInEnd = env('ATTENDANCE_CHECKIN_END', '12:00');
        $currentTime = $nowWita->format('H:i');

        if ($currentTime < $checkInStart || $currentTime > $checkInEnd) {
            return redirect()->route('intern.attendance.index')
                ->with('info', 'Form absensi masuk hanya tersedia pukul ' . $checkInStart . ' - ' . $checkInEnd . ' WITA.');
        }

        // Check if already has attendance today (berdasarkan tanggal WITA)
        $todayAttendance = Attendance::where('intern_id', $intern->id)
            ->whereDate('date', $todayWita)
            ->first();

        if ($todayAttendance) {
            return redirect()->route('intern.attendance.index')
                ->with('info', 'Anda sudah melakukan absensi hari ini.');
        }

        return view('intern.attendance.create');
    }

    public function store(Request $request)
    {
        $intern = Auth::user()->intern;

        // Gunakan waktu server WITA (Asia/Makassar)
        $nowWita = TimeService::nowWita();
        $todayWita = $nowWita->toDateString();

        // Check if already has attendance today (berdasarkan tanggal WITA)
        $todayAttendance = Attendance::where('intern_id', $intern->id)
            ->whereDate('date', $todayWita)
            ->first();

        if ($todayAttendance) {
            return back()->withErrors(['error' => 'Anda sudah melakukan absensi hari ini.']);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:hadir,izin,sakit'],
            'photo' => ['required_if:status,hadir', 'nullable', 'image', 'max:2048'],
            'photo_data' => ['required_if:status,hadir', 'nullable', 'string'],
            'note' => ['required_if:status,izin', 'required_if:status,sakit', 'nullable', 'string'],
            'document' => ['required_if:status,izin', 'nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
        ]);

        $data = [
            'intern_id' => $intern->id,
            // Simpan tanggal WITA agar konsisten
            'date' => $todayWita,
            'status' => $validated['status'],
        ];

        if ($validated['status'] === 'hadir') {
            // Validasi jam masuk hanya boleh dalam rentang tertentu (default 08:00-12:00 WITA)
            $checkInStart = env('ATTENDANCE_CHECKIN_START', '08:00');
            $checkInEnd = env('ATTENDANCE_CHECKIN_END', '12:00');
            $currentTime = $nowWita->format('H:i');

            if ($currentTime < $checkInStart || $currentTime > $checkInEnd) {
                return back()->withErrors(['error' => 'Absensi masuk hanya diperbolehkan antara ' . $checkInStart . ' - ' . $checkInEnd . ' WITA.'])->withInput();
            }
            $photoPath = null;
            
            if ($request->hasFile('photo')) {
                // Handle file upload
                $photo = $request->file('photo');
                if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                    try {
                        $extension = $photo->getClientOriginalExtension();
                        if (empty($extension)) {
                            $extension = $photo->guessExtension() ?: 'jpg';
                        }
                        $filename = 'attendance_' . time() . '_' . uniqid() . '.' . $extension;
                        $destinationPath = storage_path('app/public/attendance-photos');
                        
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }
                        
                        $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                        if ($photo->move($destinationPath, $filename) && file_exists($fullPath)) {
                            $photoPath = 'attendance-photos/' . $filename;
                        } else {
                            return back()->withErrors(['photo' => 'Gagal menyimpan foto.'])->withInput();
                        }
                    } catch (\Exception $e) {
                        return back()->withErrors(['photo' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
                    }
                } else {
                    return back()->withErrors(['photo' => 'File foto tidak valid.'])->withInput();
                }
            } elseif ($request->filled('photo_data')) {
                // Handle base64 image from camera
                $imageData = $request->input('photo_data');
                if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                    $imageData = substr($imageData, strpos($imageData, ',') + 1);
                    $type = strtolower($type[1]);
                    $imageData = base64_decode($imageData);
                    
                    if ($imageData === false) {
                        return back()->withErrors(['photo' => 'Invalid image data.']);
                    }
                    
                    $fileName = 'attendance_' . time() . '_' . uniqid() . '.' . $type;
                    $destinationPath = storage_path('app/public/attendance-photos');
                    
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $fileName;
                    if (file_put_contents($fullPath, $imageData) !== false && file_exists($fullPath)) {
                        $photoPath = 'attendance-photos/' . $fileName;
                    } else {
                        return back()->withErrors(['photo' => 'Gagal menyimpan foto dari kamera.']);
                    }
                } else {
                    return back()->withErrors(['photo' => 'Invalid image format.']);
                }
            } else {
                return back()->withErrors(['photo' => 'Foto wajib diisi untuk status hadir.']);
            }
            
            if ($photoPath) {
                $data['photo_path'] = $photoPath;
                // Simpan waktu check-in berdasarkan WITA
                $data['check_in'] = $nowWita;
            } else {
                return back()->withErrors(['photo' => 'Gagal menyimpan foto.'])->withInput();
            }
        } else {
            $data['note'] = $validated['note'] ?? null;
            if ($request->hasFile('document')) {
                $document = $request->file('document');
                if ($document->isValid() && $document->getError() === UPLOAD_ERR_OK) {
                    try {
                        $extension = $document->getClientOriginalExtension();
                        if (empty($extension)) {
                            $extension = $document->guessExtension() ?: 'pdf';
                        }
                        $filename = 'document_' . time() . '_' . uniqid() . '.' . $extension;
                        $destinationPath = storage_path('app/public/attendance-documents');
                        
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }
                        
                        $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                        if ($document->move($destinationPath, $filename) && file_exists($fullPath)) {
                            $data['document_path'] = 'attendance-documents/' . $filename;
                        } else {
                            return back()->withErrors(['document' => 'Gagal menyimpan dokumen.'])->withInput();
                        }
                    } catch (\Exception $e) {
                        return back()->withErrors(['document' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
                    }
                } else {
                    return back()->withErrors(['document' => 'File dokumen tidak valid.'])->withInput();
                }
            }
            $data['document_status'] = 'pending';
        }

        Attendance::create($data);

        return redirect()->route('intern.attendance.index')
            ->with('success', 'Absensi berhasil disimpan.');
    }

    public function checkOut(Request $request)
    {
        // Gunakan waktu server WITA (Asia/Makassar)
        $nowWita = TimeService::nowWita();

        $validated = $request->validate([
            'photo' => ['required_without:photo_data', 'nullable', 'image', 'max:2048'],
            'photo_data' => ['required_without:photo', 'nullable', 'string'],
        ]);

        $intern = Auth::user()->intern;
        
        $todayAttendance = Attendance::where('intern_id', $intern->id)
            ->whereDate('date', $nowWita->toDateString())
            ->where('status', 'hadir')
            ->first();

        if (!$todayAttendance) {
            return back()->withErrors(['error' => 'Anda belum melakukan absensi masuk hari ini.']);
        }

        if ($todayAttendance->check_out) {
            return back()->withErrors(['error' => 'Anda sudah melakukan absensi keluar hari ini.']);
        }

        // Validasi jam keluar minimal 16:45 WITA
        if ($nowWita->format('H:i') < '16:45') {
            return back()->withErrors(['error' => 'Absensi keluar hanya bisa mulai pukul 16:45 WITA.']);
        }

        // Handle photo upload for checkout
        $photoCheckoutPath = null;
        
        if ($request->hasFile('photo')) {
            // Handle file upload
            $photo = $request->file('photo');
            if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                try {
                    $extension = $photo->getClientOriginalExtension();
                    if (empty($extension)) {
                        $extension = $photo->guessExtension() ?: 'jpg';
                    }
                    $filename = 'checkout_' . time() . '_' . uniqid() . '.' . $extension;
                    $destinationPath = storage_path('app/public/attendance-photos');
                    
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                    if ($photo->move($destinationPath, $filename) && file_exists($fullPath)) {
                        $photoCheckoutPath = 'attendance-photos/' . $filename;
                    } else {
                        return back()->withErrors(['photo' => 'Gagal menyimpan foto checkout.'])->withInput();
                    }
                } catch (\Exception $e) {
                    return back()->withErrors(['photo' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
                }
            } else {
                return back()->withErrors(['photo' => 'File foto tidak valid.'])->withInput();
            }
        } elseif ($request->filled('photo_data')) {
            // Handle base64 image from camera
            $imageData = $request->input('photo_data');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);
                $imageData = base64_decode($imageData);
                
                if ($imageData === false) {
                    return back()->withErrors(['photo' => 'Invalid image data.']);
                }
                
                $fileName = 'checkout_' . time() . '_' . uniqid() . '.' . $type;
                $destinationPath = storage_path('app/public/attendance-photos');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $fileName;
                if (file_put_contents($fullPath, $imageData) !== false && file_exists($fullPath)) {
                    $photoCheckoutPath = 'attendance-photos/' . $fileName;
                } else {
                    return back()->withErrors(['photo' => 'Gagal menyimpan foto dari kamera.']);
                }
            } else {
                return back()->withErrors(['photo' => 'Invalid image format.']);
            }
        } else {
            return back()->withErrors(['photo' => 'Foto checkout wajib diisi.']);
        }

        $todayAttendance->update([
            // Simpan waktu check-out berdasarkan WITA
            'check_out' => $nowWita,
            'photo_checkout' => $photoCheckoutPath,
        ]);

        return redirect()->route('intern.attendance.index')
            ->with('success', 'Absensi keluar berhasil disimpan.');
    }
}