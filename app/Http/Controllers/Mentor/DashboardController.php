<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\MicroSkillSubmission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mentor = $user->mentor;

        $interns = $mentor ? $mentor->interns()->withCount(['attendances', 'microSkills'])->with(['attendances' => function ($q) {
            $q->whereDate('date', now()->toDateString());
        }])->get() : collect();

        $today = now()->toDateString();
        $todayAttendances = Attendance::whereIn('intern_id', $interns->pluck('id') ?: [0])
            ->whereDate('date', $today)
            ->with('intern')
            ->orderBy('created_at', 'desc')
            ->get();

        // Micro skill summary for mentor's interns
        $internIds = $interns->pluck('id');
        $microPending = MicroSkillSubmission::whereIn('intern_id', $internIds)->where('status', 'pending')->count();
        $microTotal = MicroSkillSubmission::whereIn('intern_id', $internIds)->count();

        // Leaderboard for mentor's interns (semua, termasuk yang 0)
        $topMicroSkills = \App\Models\Intern::leftJoin('micro_skill_submissions', 'interns.id', '=', 'micro_skill_submissions.intern_id')
            ->whereIn('interns.id', $internIds)
            ->select('interns.id as intern_id', 'interns.name', 'interns.institution', 'interns.photo_path', \DB::raw('COUNT(micro_skill_submissions.id) as total'))
            ->groupBy('interns.id', 'interns.name', 'interns.institution', 'interns.photo_path')
            ->orderByDesc('total')
            ->orderBy('interns.name')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                return [
                    'intern_id' => $row->intern_id,
                    'name' => $row->name,
                    'institution' => $row->institution,
                    'photo_path' => $row->photo_path,
                    'total' => (int)$row->total,
                ];
            });

        return view('mentor.dashboard', compact('mentor', 'interns', 'todayAttendances', 'microPending', 'microTotal', 'topMicroSkills'));
    }
}


