<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MicroSkillSubmission;
use App\Models\MicroSkill;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminMicroSkillController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $query = MicroSkill::leftJoin('micro_skill_submissions', 'micro_skill_submissions.title', '=', 'micro_skills.judul_micro')
            ->select('micro_skills.*', DB::raw('COUNT(micro_skill_submissions.id) as total'))
            ->groupBy(
                'micro_skills.id',
                'micro_skills.judul_micro',
                'micro_skills.link_micro',
                'micro_skills.created_at',
                'micro_skills.updated_at'
            );

        if ($request->filled('q')) {
            $like = '%' . $q . '%';
            $query->where('micro_skills.judul_micro', 'like', $like)->orWhere('micro_skills.link_micro', 'like', $like);
        }

        $microskills = $query->orderByDesc('micro_skills.created_at')->paginate(20)->withQueryString();

        return view('admin.microskill.index', compact('microskills'));
    }

    public function show($id, Request $request)
    {
        $micro = MicroSkill::findOrFail($id);

        $subQuery = MicroSkillSubmission::with('intern')
            ->where('title', $micro->judul_micro);

        $submissions = $subQuery->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.microskill.show', compact('micro', 'submissions'));
    }

    public function servePhoto(string $filename)
    {
        if ($filename !== basename($filename)) {
            abort(404, 'File not found');
        }

        $photoPath = 'private/micro-skills/' . $filename;

        $submission = MicroSkillSubmission::where('photo_path', $photoPath)->firstOrFail();

        $this->authorize('view', $submission);

        $fullPath = storage_path('app/' . $photoPath);

        if (!file_exists($fullPath)) {
            abort(404, 'File not found');
        }

        return response()->file($fullPath, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, private',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function create()
    {
        return view('admin.microskill.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_micro' => 'required|string|max:255',
            'link_micro' => 'required|url',
        ]);

        MicroSkill::create([
            'judul_micro' => $request->judul_micro,
            'link_micro' => $request->link_micro,
        ]);

        return redirect()->route('admin.microskill.index')->with('success', 'Microskill berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $microskill = MicroSkill::findOrFail($id);
        $microskill->delete();

        return redirect()->route('admin.microskill.index')->with('success', 'Microskill berhasil dihapus.');
    }
}


