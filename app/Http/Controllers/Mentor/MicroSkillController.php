<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\MicroSkillSubmission;
use App\Models\MicroSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MicroSkillController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q'));

        $mentor = Auth::user()->mentor;

        $internIds = $mentor
            ? $mentor->interns()->pluck('id')
            : collect();

        $query = MicroSkill::query()
            ->leftJoin('micro_skill_submissions', function ($join) use ($internIds) {
                $join->on(
                    'micro_skill_submissions.title',
                    '=',
                    'micro_skills.judul_micro'
                );

                if ($internIds->isNotEmpty()) {
                    $join->whereIn('micro_skill_submissions.intern_id', $internIds);
                } else {
                    $join->whereRaw('1 = 0');
                }
            })
            ->select(
                'micro_skills.*',
                DB::raw('COUNT(micro_skill_submissions.id) as total')
            );

        if (!empty($q)) {
            $like = '%' . $q . '%';

            $query->where(function ($sub) use ($like) {
                $sub->where('micro_skills.judul_micro', 'like', $like);
            });
        }

        $query->groupBy(
            'micro_skills.id',
            'micro_skills.judul_micro',
            'micro_skills.link_micro',
            'micro_skills.created_at',
            'micro_skills.updated_at'
        );

        $microskills = $query
            ->orderByDesc('total')
            ->orderByDesc('micro_skills.created_at')
            ->paginate(20)
            ->withQueryString();

        return view('mentor.microskill.index', compact('microskills'));
    }

    public function show($id, Request $request)
{
    $micro = MicroSkill::findOrFail($id);

    $mentor = Auth::user()->mentor;

    $internIds = $mentor
        ? $mentor->interns()->pluck('id')
        : collect();

    $subQuery = MicroSkillSubmission::with('intern')
        ->where('title', $micro->judul_micro);

    if ($internIds->isNotEmpty()) {
        $subQuery->whereIn('intern_id', $internIds);
    } else {
        $subQuery->whereRaw('1 = 0');
    }

    $submissions = $subQuery
        ->orderByDesc('created_at')
        ->paginate(20)
        ->withQueryString();

    return view('mentor.microskill.show', compact('micro', 'submissions'));
}

    /**
     * Serve private microskill photo for mentor's interns
     */
    public function servePhoto($filename)
    {
        $filePath = storage_path('app/private/micro-skills/' . $filename);

        if (!str_starts_with(realpath($filePath) ?: '', realpath(storage_path('app/private/micro-skills')) ?: '')) {
            abort(403, 'Unauthorized');
        }

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        $submission = MicroSkillSubmission::where('photo_path', 'private/micro-skills/' . $filename)
            ->first();

        if (!$submission) {
            abort(403, 'Unauthorized');
        }

        $this->authorize('view', $submission);

        return response()->file($filePath, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}


