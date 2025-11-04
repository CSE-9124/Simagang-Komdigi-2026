<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\MicroSkillSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MicroSkillController extends Controller
{
    public function index()
    {
        $intern = Auth::user()->intern;
        $submissions = MicroSkillSubmission::where('intern_id', $intern->id)
            ->orderByDesc('created_at')
            ->paginate(15);
        return view('intern.microskill.index', compact('submissions'));
    }

    public function create()
    {
        return view('intern.microskill.create');
    }

    public function store(Request $request)
    {
        $intern = Auth::user()->intern;

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'photo' => ['required', 'image', 'max:4096'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                $extension = $photo->getClientOriginalExtension() ?: ($photo->guessExtension() ?: 'jpg');
                $filename = 'microskill_' . time() . '_' . uniqid() . '.' . $extension;
                $destinationPath = storage_path('app/public/micro-skills');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                if ($photo->move($destinationPath, $filename) && file_exists($fullPath)) {
                    $photoPath = 'micro-skills/' . $filename;
                } else {
                    return back()->withErrors(['photo' => 'Gagal menyimpan foto.'])->withInput();
                }
            } else {
                return back()->withErrors(['photo' => 'File foto tidak valid.'])->withInput();
            }
        }

        MicroSkillSubmission::create([
            'intern_id' => $intern->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'photo_path' => $photoPath,
            // Langsung dianggap selesai/terkumpul
            'status' => 'approved',
            'submitted_at' => now(),
        ]);

        return redirect()->route('intern.microskill.index')->with('success', 'Bukti Mikro Skill berhasil diunggah.');
    }
}


