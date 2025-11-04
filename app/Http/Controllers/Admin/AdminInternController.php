<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AdminInternController extends Controller
{
    public function index(Request $request)
    {
        $query = Intern::with(['user', 'mentor']);
        
        // Filter by team
        if ($request->filled('team')) {
            $query->where('team', $request->team);
        }
        
        // Filter by mentor
        if ($request->filled('mentor_id')) {
            $query->where('mentor_id', $request->mentor_id);
        }
        
        // Filter by active status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }
        
        $interns = $query->orderBy('name')->paginate(15)->withQueryString();
        $mentors = \App\Models\Mentor::orderBy('name')->get();
        
        return view('admin.intern.index', compact('interns', 'mentors'));
    }

    public function create()
    {
        return view('admin.intern.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'education_level' => ['required', 'in:SMA/SMK,S1/D4'],
            'major' => ['nullable', 'string', 'max:255'],
            'student_id' => ['nullable', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'mentor_id' => ['nullable', 'exists:mentors,id'],
            'team' => ['nullable', 'string', 'in:TIM DEA,TIM GTA,TIM VSGA,TIM TA,TIM Microskill,TIM Media,TIM Tata Usaha'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'photo' => ['required', 'image', 'max:2048'],
            'password' => ['required', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'intern',
        ]);

        // Handle photo upload
        $photo = $request->file('photo');
        if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
            try {
                $extension = $photo->getClientOriginalExtension() ?: ($photo->guessExtension() ?: 'jpg');
                $filename = 'photo_' . time() . '_' . uniqid() . '.' . $extension;
                $destinationPath = storage_path('app/public/photos');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                if ($photo->move($destinationPath, $filename) && file_exists($fullPath)) {
                    $photoPath = 'photos/' . $filename;
                } else {
                    return back()->withErrors(['photo' => 'Gagal menyimpan foto.'])->withInput();
                }
            } catch (\Exception $e) {
                return back()->withErrors(['photo' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
            }
        } else {
            return back()->withErrors(['photo' => 'File foto tidak valid.'])->withInput();
        }

        // Use custom institution if provided
        $institution = $validated['institution'];
        if ($institution === '__custom__' && !empty($validated['custom_institution'])) {
            $institution = $validated['custom_institution'];
        }

        Intern::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'education_level' => $validated['education_level'],
            'major' => $validated['major'],
            'student_id' => $validated['student_id'],
            'institution' => $institution,
            'mentor_id' => $validated['mentor_id'] ?? null,
            'team' => $validated['team'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'photo_path' => $photoPath,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.intern.index')
            ->with('success', 'Data anak magang berhasil ditambahkan.');
    }

    public function show(Intern $intern)
    {
        $intern->load(['attendances' => function ($query) {
            $query->orderBy('date', 'desc')->take(30);
        }, 'logbooks' => function ($query) {
            $query->orderBy('date', 'desc')->take(10);
        }, 'finalReport', 'mentor']);

        $stats = [
            'total_hadir' => $intern->attendances()->where('status', 'hadir')->count(),
            'total_izin' => $intern->attendances()->where('status', 'izin')->count(),
            'total_sakit' => $intern->attendances()->where('status', 'sakit')->count(),
            'total_logbooks' => $intern->logbooks()->count(),
            'has_report' => $intern->finalReport !== null,
        ];

        return view('admin.intern.show', compact('intern', 'stats'));
    }

    public function edit(Intern $intern)
    {
        return view('admin.intern.edit', compact('intern'));
    }

    public function update(Request $request, Intern $intern)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $intern->user_id],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'education_level' => ['required', 'in:SMA/SMK,S1/D4'],
            'major' => ['nullable', 'string', 'max:255'],
            'student_id' => ['nullable', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'mentor_id' => ['nullable', 'exists:mentors,id'],
            'team' => ['nullable', 'string', 'in:TIM DEA,TIM GTA,TIM VSGA,TIM TA,TIM Microskill,TIM Media,TIM Tata Usaha'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', Password::defaults()],
            'is_active' => ['boolean'],
        ]);

        $intern->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (isset($validated['password'])) {
            $intern->user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Use custom institution if provided
        $institution = $validated['institution'];
        if ($institution === '__custom__' && !empty($validated['custom_institution'])) {
            $institution = $validated['custom_institution'];
        }

        $data = [
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'education_level' => $validated['education_level'],
            'major' => $validated['major'],
            'student_id' => $validated['student_id'],
            'institution' => $institution,
            'mentor_id' => $validated['mentor_id'] ?? null,
            'team' => $validated['team'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                try {
                    // Delete old photo
                    if ($intern->photo_path) {
                        $oldPath = storage_path('app/public/' . $intern->photo_path);
                        if (file_exists($oldPath)) {
                            @unlink($oldPath);
                        }
                    }
                    
                    $extension = $photo->getClientOriginalExtension() ?: ($photo->guessExtension() ?: 'jpg');
                    $filename = 'photo_' . time() . '_' . uniqid() . '.' . $extension;
                    $destinationPath = storage_path('app/public/photos');
                    
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                    if ($photo->move($destinationPath, $filename) && file_exists($fullPath)) {
                        $data['photo_path'] = 'photos/' . $filename;
                    }
                } catch (\Exception $e) {
                    return back()->withErrors(['photo' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
                }
            }
        }

        $intern->update($data);

        return redirect()->route('admin.intern.show', $intern)
            ->with('success', 'Data anak magang berhasil diperbarui.');
    }

    public function destroy(Intern $intern)
    {
        if ($intern->photo_path) {
            Storage::disk('public')->delete($intern->photo_path);
        }

        $userId = $intern->user_id;
        $intern->delete();
        User::find($userId)->delete();

        return redirect()->route('admin.intern.index')
            ->with('success', 'Data anak magang berhasil dihapus.');
    }
}