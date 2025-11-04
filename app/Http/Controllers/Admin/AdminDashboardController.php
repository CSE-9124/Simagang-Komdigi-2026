<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Intern;
use App\Models\MicroSkillSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $activeInterns = Intern::where('is_active', true)->count();
        $totalInterns = Intern::count();
        
        $totalHadir = Attendance::where('status', 'hadir')->count();
        $totalIzin = Attendance::where('status', 'izin')->count();
        $totalSakit = Attendance::where('status', 'sakit')->count();
        $totalAlfa = Attendance::where('status', 'alfa')->count();

        // Micro Skill summary
        $microTotal = MicroSkillSubmission::count();
        
        $todayAttendances = Attendance::whereDate('date', today())
            ->with('intern')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Leaderboard Mikro Skill (Top 10 all interns, termasuk yang 0)
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

        return view('admin.dashboard', compact(
            'activeInterns',
            'totalInterns',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlfa',
            'microTotal',
            'todayAttendances',
            'topMicroSkills'
        ));
    }
}