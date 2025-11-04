<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LogbookController extends Controller
{
    public function index()
    {
        $intern = Auth::user()->intern;
        $logbooks = Logbook::where('intern_id', $intern->id)
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('intern.logbook.index', compact('logbooks'));
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
            'activity' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'intern_id' => $intern->id,
            'date' => $validated['date'],
            'activity' => $validated['activity'],
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                try {
                    $extension = $photo->getClientOriginalExtension() ?: ($photo->guessExtension() ?: 'jpg');
                    $filename = 'logbook_' . time() . '_' . uniqid() . '.' . $extension;
                    $destinationPath = storage_path('app/public/logbook-photos');
                    
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                    if ($photo->move($destinationPath, $filename) && file_exists($fullPath)) {
                        $data['photo_path'] = 'logbook-photos/' . $filename;
                    }
                } catch (\Exception $e) {
                    // Skip photo upload if fails, continue without it
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
            'activity' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'date' => $validated['date'],
            'activity' => $validated['activity'],
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            if ($photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                try {
                    // Delete old photo
                    if ($logbook->photo_path) {
                        $oldPath = storage_path('app/public/' . $logbook->photo_path);
                        if (file_exists($oldPath)) {
                            @unlink($oldPath);
                        }
                    }
                    
                    $extension = $photo->getClientOriginalExtension() ?: ($photo->guessExtension() ?: 'jpg');
                    $filename = 'logbook_' . time() . '_' . uniqid() . '.' . $extension;
                    $destinationPath = storage_path('app/public/logbook-photos');
                    
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                    if ($photo->move($destinationPath, $filename) && file_exists($fullPath)) {
                        $data['photo_path'] = 'logbook-photos/' . $filename;
                    }
                } catch (\Exception $e) {
                    // Skip photo upload if fails, continue without it
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
            Storage::disk('public')->delete($logbook->photo_path);
        }

        $logbook->delete();

        return redirect()->route('intern.logbook.index')
            ->with('success', 'Logbook berhasil dihapus.');
    }
}