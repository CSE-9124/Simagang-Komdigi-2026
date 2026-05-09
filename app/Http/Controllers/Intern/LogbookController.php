<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class LogbookController extends Controller
{
    public function index()
    {
        $intern = Auth::user()->intern;
        $logbooks = Logbook::where('intern_id', $intern->id)
            ->orderBy('date', 'desc')
            ->paginate(15);

        // Aggregate counts across all logbook records for this intern
        $totalLogbooks = Logbook::where('intern_id', $intern->id)->count();
        $withPhotoCount = Logbook::where('intern_id', $intern->id)
            ->whereNotNull('photo_path')
            ->count();
        $thisMonthCount = Logbook::where('intern_id', $intern->id)
            ->where('date', '>=', now()->startOfMonth())
            ->count();

        $cekaktif = $intern && $intern->is_active;

        return view('intern.logbook.index', compact('logbooks', 'totalLogbooks', 'withPhotoCount', 'thisMonthCount', 'cekaktif'));
    }

    public function create()
    {
        return view('intern.logbook.create');
    }

    public function store(Request $request)
    {
        $intern = Auth::user()->intern;

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'activity' => ['required', 'string', 'max:1000'],
            // 'photo' => ['nullable', 'image', 'max:2048'],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048'
            ],
        ]);

        $data = [
            'intern_id' => $intern->id,
            'date' => $validated['date'],
            'activity' => $validated['activity'],
        ];

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

                    $destinationPath = storage_path('app/private/logbook-photos');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $manager = new ImageManager(new Driver());

                    $image = $manager->read($photo)
                        ->toJpeg(80);

                    Storage::disk('local')->put(
                        'private/logbook-photos/' . $filename,
                        (string) $image
                    );

                    $data['photo_path'] = 'private/logbook-photos/' . $filename;
                } catch (\Exception $e) {
                    return back()->withErrors([
                        'photo' => 'Gagal upload foto.'
                    ])->withInput();
                }
            }
        }

        Logbook::create($data);

        return redirect()->route('intern.logbook.index')
            ->with('success', 'Logbook berhasil disimpan.');
    }

    public function edit(Logbook $logbook)
    {
        // Ensure the logbook belongs to the authenticated intern
        if ($logbook->intern_id !== Auth::user()->intern->id) {
            abort(403);
        }

        return view('intern.logbook.edit', compact('logbook'));
    }

    public function update(Request $request, Logbook $logbook)
    {
        // Ensure the logbook belongs to the authenticated intern
        if ($logbook->intern_id !== Auth::user()->intern->id) {
            abort(403);
        }

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'activity' => ['required', 'string', 'max:1000'],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048'
            ],
        ]);

        $data = [
            'date' => $validated['date'],
            'activity' => $validated['activity'],
        ];

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
                    // Delete old photo
                    if ($logbook->photo_path) {
                        $oldPath = storage_path('app/private/' . $logbook->photo_path);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                    
                    // $extension = $photo->guessExtension() ?: 'jpg';

                    $filename = Str::uuid() . '.jpg';

                    $destinationPath = storage_path('app/private/logbook-photos');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $manager = new ImageManager(new Driver());

                    $image = $manager->read($photo)
                        ->toJpeg(80);

                    Storage::disk('local')->put(
                        'private/logbook-photos/' . $filename,
                        (string) $image
                    );

                    $data['photo_path'] = 'private/logbook-photos/' . $filename;
                } catch (\Exception $e) {
                    return back()->withErrors([
                        'photo' => 'Gagal upload foto.'
                    ])->withInput();
                }
            }
        }

        $logbook->update($data);

        return redirect()->route('intern.logbook.index')
            ->with('success', 'Logbook berhasil diperbarui.');
    }

    public function destroy(Logbook $logbook)
    {
        // Ensure the logbook belongs to the authenticated intern
        if ($logbook->intern_id !== Auth::user()->intern->id) {
            abort(403);
        }

        if ($logbook->photo_path) {
            $photoPath = storage_path('app/private/' . $logbook->photo_path);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $logbook->delete();

        return redirect()->route('intern.logbook.index')
            ->with('success', 'Logbook berhasil dihapus.');
    }

    /**
     * Serve private logbook photo with permission check
     */
    public function servePhoto($filename)
    {
        $intern = Auth::user()->intern;
        $filePath = storage_path('app/private/logbook-photos/' . $filename);

        // Validate the file path to prevent directory traversal
        if (!str_starts_with(realpath($filePath) ?: '', realpath(storage_path('app/private/logbook-photos')) ?: '')) {
            abort(403, 'Unauthorized');
        }

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // Check if logbook belongs to authenticated user
        $logbook = Logbook::where('intern_id', $intern->id)
            ->where('photo_path', 'private/logbook-photos/' . $filename)
            ->first();

        if (!$logbook) {
            abort(403, 'Unauthorized');
        }

        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}