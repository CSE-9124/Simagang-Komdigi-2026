<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Intern;
use App\Models\MicroSkillSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $intern = $user->intern;

        if (!$intern) {
            // If user doesn't have intern record, logout and redirect to register
            Auth::logout();
            return redirect()->route('register')->withErrors(['error' => 'Data profil Anda tidak lengkap. Silakan daftar ulang.']);
        }

        // Today's attendance status
        $todayAttendance = Attendance::where('intern_id', $intern->id)
            ->whereDate('date', today())
            ->first();

        // Statistics
        $totalHadir = Attendance::where('intern_id', $intern->id)
            ->where('status', 'hadir')
            ->count();

        $totalIzin = Attendance::where('intern_id', $intern->id)
            ->where('status', 'izin')
            ->count();

        $totalSakit = Attendance::where('intern_id', $intern->id)
            ->where('status', 'sakit')
            ->count();

        $hasFinalReport = $intern->finalReport !== null;
        
        // Micro skill summary
        $microSkillTotal = $intern->microSkills()->count();
        $microSkillApproved = $intern->microSkills()->where('status', 'approved')->count();

        // Leaderboard (Top 10 global, termasuk yang 0)
        $topMicroSkills = Intern::leftJoin('micro_skill_submissions', 'interns.id', '=', 'micro_skill_submissions.intern_id')
            ->select('interns.id as intern_id', 'interns.name', 'interns.institution', 'interns.photo_path', DB::raw('COUNT(micro_skill_submissions.id) as total'))
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

        return view('intern.dashboard', compact(
            'intern',
            'todayAttendance',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'hasFinalReport',
            'microSkillTotal',
            'microSkillApproved',
            'topMicroSkills'
        ));
    }
}