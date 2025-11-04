<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Support\Facades\DB;

class AdminMicroSkillLeaderboardController extends Controller
{
    public function index()
    {
        $rows = Intern::leftJoin('micro_skill_submissions', 'interns.id', '=', 'micro_skill_submissions.intern_id')
            ->select('interns.id as intern_id', 'interns.name', 'interns.institution', 'interns.photo_path', DB::raw('COUNT(micro_skill_submissions.id) as total'))
            ->groupBy('interns.id', 'interns.name', 'interns.institution', 'interns.photo_path')
            ->orderByDesc('total')
            ->orderBy('interns.name')
            ->paginate(20);

        return view('admin.microskill.leaderboard', compact('rows'));
    }
}


