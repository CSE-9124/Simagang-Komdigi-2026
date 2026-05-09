<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\MicroSkillSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

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

        $cekaktif = $intern && $intern->is_active;

        return view('intern.microskill.index', compact('submissions', 'cekaktif'));
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
            'description' => ['nullable', 'string', 'max:1000'],
            // 'photo' => ['required', 'image', 'max:4096'],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:4096'
            ],
        ]); 

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            $allowedMimeTypes = [
                'image/jpeg',
                'image/png',
            ];

            if (!in_array($photo->getMimeType(), $allowedMimeTypes)) {
                return back()->withErrors([
                    'photo' => 'Tipe file tidak valid.'
                ])->withInput();
            }

            if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                try {
                    // $extension = $photo->guessExtension() ?: 'jpg';

                    $filename = Str::uuid() . '.jpg';

                    $destinationPath = storage_path('app/private/micro-skills');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $manager = new ImageManager(new Driver());

                    $image = $manager->read($photo)
                        ->toJpeg(80);

                    Storage::disk('local')->put(
                        'private/micro-skills/' . $filename,
                        (string) $image
                    );

                    $photoPath = 'private/micro-skills/' . $filename;
                } catch (\Exception $e) {
                    return back()->withErrors([
                        'photo' => 'Gagal upload foto.'
                    ])->withInput();
                }
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
            'description' => ['nullable', 'string', 'max:1000'],
            // 'photo' => ['nullable', 'image', 'max:4096'],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:4096'
             ],
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($submission->photo_path) {
                $oldPath = storage_path('app/private/' . $submission->photo_path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $photo = $request->file('photo');

            $allowedMimeTypes = [
                'image/jpeg',
                'image/png',
            ];

            if (!in_array($photo->getMimeType(), $allowedMimeTypes)) {
                return back()->withErrors([
                    'photo' => 'Tipe file tidak valid.'
                ])->withInput();
            }

            if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                try {
                    // $extension = $photo->guessExtension() ?: 'jpg';

                    $filename = Str::uuid() . '.jpg';

                    $destinationPath = storage_path('app/private/micro-skills');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $manager = new ImageManager(new Driver());

                    $image = $manager->read($photo)
                        ->toJpeg(80);

                    Storage::disk('local')->put(
                        'private/micro-skills/' . $filename,
                        (string) $image
                    );

                    $validated['photo_path'] = 'private/micro-skills/' . $filename;

                } catch (\Exception $e) {
                    return back()->withErrors([
                        'photo' => 'Gagal upload foto.'
                    ])->withInput();
                }
                
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
            $photoPath = storage_path('app/private/' . $submission->photo_path);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $submission->delete();

        return redirect()->route('intern.microskill.index')->with('success', 'Bukti Mikro Skill berhasil dihapus.');
    }

    /**
     * Serve private microskill photo with permission check
     */
    public function servePhoto($filename)
    {
        $intern = Auth::user()->intern;
        $filePath = storage_path('app/private/micro-skills/' . $filename);

        // Validate the file path to prevent directory traversal
        if (!str_starts_with(realpath($filePath) ?: '', realpath(storage_path('app/private/micro-skills')) ?: '')) {
            abort(403, 'Unauthorized');
        }

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // Check if microskill submission belongs to authenticated user
        $submission = MicroSkillSubmission::where('intern_id', $intern->id)
            ->where('photo_path', 'private/micro-skills/' . $filename)
            ->first();

        if (!$submission) {
            abort(403, 'Unauthorized');
        }

        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}