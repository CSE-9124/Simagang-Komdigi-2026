<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\MicroSkillSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MicroSkillController extends Controller
{
    public function index(Request $request)
    {
        $intern = Auth::user()->intern;

        $query = MicroSkillSubmission::where('intern_id', $intern->id);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $submissions = $query->orderByDesc('created_at')->paginate(15);

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
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('micro_skill_submissions', 'title')
                    ->where(fn ($query) => $query->where('intern_id', $intern->id)),
            ],
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

    public function edit(MicroSkillSubmission $submission)
    {
        // Pastikan user hanya bisa edit data miliknya
        if ($submission->intern_id !== Auth::user()->intern->id) {
            abort(403);
        }

        return view('intern.microskill.edit', compact('submission'));
    }

    public function update(Request $request, MicroSkillSubmission $submission)
    {
        // Pastikan user hanya bisa update data miliknya
        if ($submission->intern_id !== Auth::user()->intern->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('micro_skill_submissions', 'title')
                    ->where(fn ($query) => $query->where('intern_id', $submission->intern_id))
                    ->ignore($submission->id),
            ],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($submission->photo_path) {
                Storage::disk('public')->delete($submission->photo_path);
            }

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
                    $validated['photo_path'] = 'micro-skills/' . $filename;
                } else {
                    return back()->withErrors(['photo' => 'Gagal menyimpan foto.'])->withInput();
                }
            } else {
                return back()->withErrors(['photo' => 'File foto tidak valid.'])->withInput();
            }
        }

        $submission->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'photo_path' => $validated['photo_path'] ?? $submission->photo_path,
        ]);

        return redirect()->route('intern.microskill.index')->with('success', 'Bukti Mikro Skill berhasil diperbarui.');
    }

    public function destroy(MicroSkillSubmission $submission)
    {
        // Pastikan user hanya bisa delete data miliknya
        if ($submission->intern_id !== Auth::user()->intern->id) {
            abort(403);
        }

        // Delete the photo if it exists
        if ($submission->photo_path) {
            Storage::disk('public')->delete($submission->photo_path);
        }

        $submission->delete();

        return redirect()->route('intern.microskill.index')->with('success', 'Bukti Mikro Skill berhasil dihapus.');
    }
}