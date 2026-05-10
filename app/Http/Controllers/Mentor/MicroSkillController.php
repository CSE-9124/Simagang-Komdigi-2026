<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\MicroSkillSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MicroSkillController extends Controller
{
    public function index(Request $request)
    {
        $mentor = Auth::user()->mentor;

        $query = MicroSkillSubmission::with('intern')
            ->when($mentor, function ($q) use ($mentor) {
                $q->whereIn('intern_id', $mentor->interns()->pluck('id'));
            });

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('intern_id')) {
            $query->where('intern_id', $request->integer('intern_id'));
        }

        $submissions = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        $interns = $mentor ? $mentor->interns()->orderBy('name')->get() : collect();

        return view('mentor.microskill.index', compact('submissions', 'interns'));
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


