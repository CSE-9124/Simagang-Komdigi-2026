<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $mentor = Auth::user()->mentor;

        $query = Attendance::query()
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
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $attendances = $query->orderByDesc('date')->paginate(20)->withQueryString();

        $interns = $mentor ? $mentor->interns()->orderBy('name')->get() : collect();

        return view('mentor.attendance.index', compact('mentor', 'attendances', 'interns'));
    }
}


