<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Services\HolidayService;
use App\Services\TimeService;

class AttendanceController extends Controller
{
    public function index()
    {
        $intern = Auth::user()->intern;
        $nowWita = TimeService::nowWita();
        $todayWita = $nowWita->toDateString();

        $totalHadir      = Attendance::where('intern_id', $intern->id)->where('status', 'hadir')->count();
        $totalIzin       = Attendance::where('intern_id', $intern->id)->where('status', 'izin')->count();
        $totalSakit      = Attendance::where('intern_id', $intern->id)->where('status', 'sakit')->count();
        $totalTidakHadir = Attendance::where('intern_id', $intern->id)->where('status', 'alfa')->count();
        $attendances     = Attendance::where('intern_id', $intern->id)
            ->orderBy('date', 'desc')
            ->paginate(15);


        $todayVirtualAbsent = false;
        $isWorkday = !HolidayService::isHoliday($nowWita);
        $hasTodayRecord = Attendance::where('intern_id', $intern->id)
            ->whereDate('date', $todayWita)
            ->exists();

        if ($isWorkday && !$hasTodayRecord) {
            $todayVirtualAbsent = true;
        }

        return view('intern.attendance.index', compact(
            'attendances', 'totalHadir', 'totalIzin', 'totalSakit', 'totalTidakHadir',
            'todayVirtualAbsent', 'todayWita'
        ));
    }

    public function create()
    {
        $intern = Auth::user()->intern;

        $nowWita = TimeService::nowWita();
        $todayWita = $nowWita->toDateString();

        if (HolidayService::isWeekend($nowWita)) {
            $dayName = $nowWita->isSaturday() ? 'Sabtu' : 'Minggu';
            return redirect()->route('intern.attendance.index')
                ->with('info', "Hari ini {$dayName} — hari libur, tidak ada absensi.");
        }

        if (HolidayService::isNationalHoliday($nowWita)) {
            $holidayName = HolidayService::getHolidayName($nowWita) ?? 'Hari Libur Nasional';
            return redirect()->route('intern.attendance.index')
                ->with('info', "Hari ini libur nasional ({$holidayName}), tidak ada absensi.");
        }

        $checkInStart = env('ATTENDANCE_CHECKIN_START', '08:00');
        $checkInEnd = env('ATTENDANCE_CHECKIN_END', '12:00');
        $currentTime = $nowWita->format('H:i');

        if ($currentTime < $checkInStart || $currentTime > $checkInEnd) {
            return redirect()->route('intern.attendance.index')
                ->with('info', 'Form absensi masuk hanya tersedia pukul ' . $checkInStart . ' - ' . $checkInEnd . ' WITA.');
        }

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

        $nowWita = TimeService::nowWita();
        $todayWita = $nowWita->toDateString();

        if (HolidayService::isWeekend($nowWita)) {
            $dayName = $nowWita->isSaturday() ? 'Sabtu' : 'Minggu';
            return back()->withErrors(['error' => "Hari ini {$dayName} — hari libur, tidak bisa melakukan absensi."]);
        }

        if (HolidayService::isNationalHoliday($nowWita)) {
            $holidayName = HolidayService::getHolidayName($nowWita) ?? 'Hari Libur Nasional';
            return back()->withErrors(['error' => "Hari ini libur nasional ({$holidayName}), tidak bisa melakukan absensi."]);
        }

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
            'date' => $todayWita,
            'status' => $validated['status'],
        ];

        if ($validated['status'] === 'hadir') {
            $checkInStart = env('ATTENDANCE_CHECKIN_START', '08:00');
            $checkInEnd = env('ATTENDANCE_CHECKIN_END', '12:00');
            $currentTime = $nowWita->format('H:i');

            if ($currentTime < $checkInStart || $currentTime > $checkInEnd) {
                return back()->withErrors(['error' => 'Absensi masuk hanya diperbolehkan antara ' . $checkInStart . ' - ' . $checkInEnd . ' WITA.'])->withInput();
            }
            $photoPath = null;
            
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                    try {
                        $extension = $photo->getClientOriginalExtension();
                        if (empty($extension)) {
                            $extension = $photo->guessExtension() ?: 'jpg';
                        }
                        $filename = 'attendance_' . time() . '_' . uniqid() . '.' . $extension;
                        $destinationPath = storage_path('app/private/attendance-photos');
                        
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }
                        
                        $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                        if ($photo->move($destinationPath, $filename) && file_exists($fullPath)) {
                            $photoPath = 'private/attendance-photos/' . $filename;
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
                $imageData = $request->input('photo_data');
                if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                    $imageData = substr($imageData, strpos($imageData, ',') + 1);
                    $type = strtolower($type[1]);
                    $imageData = base64_decode($imageData);
                    
                    if ($imageData === false) {
                        return back()->withErrors(['photo' => 'Invalid image data.']);
                    }
                    
                    $fileName = 'attendance_' . time() . '_' . uniqid() . '.' . $type;
                    $destinationPath = storage_path('app/private/attendance-photos');
                    
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $fileName;
                    if (file_put_contents($fullPath, $imageData) !== false && file_exists($fullPath)) {
                        $photoPath = 'private/attendance-photos/' . $fileName;
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
                        $destinationPath = storage_path('app/private/attendance-documents');
                        
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }
                        
                        $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                        if ($document->move($destinationPath, $filename) && file_exists($fullPath)) {
                            $data['document_path'] = 'private/attendance-documents/' . $filename;
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

        if ($nowWita->format('H:i') < '16:00') {
            return back()->withErrors(['error' => 'Absensi keluar hanya bisa mulai pukul 16:45 WITA.']);
        }

        $photoCheckoutPath = null;
        
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                try {
                    $extension = $photo->getClientOriginalExtension();
                    if (empty($extension)) {
                        $extension = $photo->guessExtension() ?: 'jpg';
                    }
                    $filename = 'checkout_' . time() . '_' . uniqid() . '.' . $extension;
                    $destinationPath = storage_path('app/private/attendance-photos');
                    
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                    if ($photo->move($destinationPath, $filename) && file_exists($fullPath)) {
                        $photoCheckoutPath = 'private/attendance-photos/' . $filename;
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
            $imageData = $request->input('photo_data');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);
                $imageData = base64_decode($imageData);
                
                if ($imageData === false) {
                    return back()->withErrors(['photo' => 'Invalid image data.']);
                }
                
                $fileName = 'checkout_' . time() . '_' . uniqid() . '.' . $type;
                $destinationPath = storage_path('app/private/attendance-photos');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $fileName;
                if (file_put_contents($fullPath, $imageData) !== false && file_exists($fullPath)) {
                    $photoCheckoutPath = 'private/attendance-photos/' . $fileName;
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
            'check_out' => $nowWita,
            'photo_checkout' => $photoCheckoutPath,
        ]);

        return redirect()->route('intern.attendance.index')
            ->with('success', 'Absensi keluar berhasil disimpan.');
    }

    /**
     * Serve private attendance photo with permission check
     */
    public function servePhoto(Request $request, $filename)
    {
        $intern = Auth::user()->intern;
        $filePath = storage_path('app/private/attendance-photos/' . $filename);

        if ($filename !== basename($filename)) {
            abort(404, 'File not found');
        }

        $token = $request->query('token');
        if ($token) {
            $cacheKey = "intern-photo-token:{$token}";
            $tokenData = Cache::get($cacheKey);

            if (
                !$tokenData ||
                ($tokenData['user_id'] ?? null) !== Auth::id() ||
                ($tokenData['filename'] ?? null) !== $filename
            ) {
                abort(404, 'File not found');
            }

            // Token is valid, don't consume it - keep it in cache for the TTL duration
        } else {
            // No token provided, fall back to ownership check
            $attendance = Attendance::where('intern_id', $intern->id)
                ->where(function($query) use ($filename) {
                    $query->where('photo_path', 'private/attendance-photos/' . $filename)
                          ->orWhere('photo_checkout', 'private/attendance-photos/' . $filename);
                })
                ->first();

            if (!$attendance) {
                abort(403, 'Unauthorized');
            }
        }

        // Validate the file path to prevent directory traversal
        if (!str_starts_with(realpath($filePath) ?: '', realpath(storage_path('app/private/attendance-photos')) ?: '')) {
            abort(403, 'Unauthorized');
        }

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->file($filePath, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, private',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * Serve private attendance document with permission check
     */
    public function serveDocument($filename)
    {
        $intern = Auth::user()->intern;
        $filePath = storage_path('app/private/attendance-documents/' . $filename);

        // Validate the file path to prevent directory traversal
        if (!str_starts_with(realpath($filePath) ?: '', realpath(storage_path('app/private/attendance-documents')) ?: '')) {
            abort(403, 'Unauthorized');
        }

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // Check if document belongs to authenticated user
        $attendance = Attendance::where('intern_id', $intern->id)
            ->where('document_path', 'private/attendance-documents/' . $filename)
            ->first();

        if (!$attendance) {
            abort(403, 'Unauthorized');
        }

        return response()->download($filePath);
    }
}