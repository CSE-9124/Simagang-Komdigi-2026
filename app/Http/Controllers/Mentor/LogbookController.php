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
        $mentor = Auth::user()->mentor;
        if (!$mentor || $logbook->intern->mentor_id !== $mentor->id) {
            abort(403, 'Unauthorized');
        }
        $logbook->load('intern');
        return view('mentor.logbook.show', compact('logbook'));
    }
}


