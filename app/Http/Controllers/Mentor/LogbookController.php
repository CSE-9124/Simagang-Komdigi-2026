<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    public function index(Request $request)
    {
        $mentor = Auth::user()->mentor;

        $query = Logbook::query()
            ->with('intern')
            ->when($mentor, function ($q) use ($mentor) {
                $q->whereIn('intern_id', $mentor->interns()->pluck('id'));
            });

        if ($request->filled('intern_id')) {
            $query->where('intern_id', $request->integer('intern_id'));
        }
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date('date_to'));
        }

        $logbooks = $query->orderByDesc('date')->paginate(20)->withQueryString();

        $interns = $mentor ? $mentor->interns()->orderBy('name')->get() : collect();

        return view('mentor.logbook.index', compact('mentor', 'logbooks', 'interns'));
    }

    public function show(Logbook $logbook)
    {
        $this->authorize('view', $logbook);

        $logbook->load('intern');
        return view('mentor.logbook.show', compact('logbook'));
    }

    /**
     * Serve private logbook photo for mentor's interns
     */
    public function servePhoto($filename)
    {
        $filePath = storage_path('app/private/logbook-photos/' . $filename);

        if (!str_starts_with(realpath($filePath) ?: '', realpath(storage_path('app/private/logbook-photos')) ?: '')) {
            abort(403, 'Unauthorized');
        }

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        $logbook = Logbook::where('photo_path', 'private/logbook-photos/' . $filename)
            ->first();

        if (!$logbook) {
            abort(403, 'Unauthorized');
        }

        $this->authorize('view', $logbook);

        return response()->file($filePath, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}


