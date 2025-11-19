<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternController extends Controller
{
    public function index(Request $request)
    {
        $mentor = Auth::user()->mentor;

        $query = $mentor ? $mentor->interns() : Intern::query()->whereRaw('1 = 0');
        
        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $interns = $query
            ->withCount(['attendances', 'logbooks', 'microSkills'])
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('mentor.intern.index', compact('mentor', 'interns'));
    }

    public function show(Intern $intern)
    {
        $mentor = Auth::user()->mentor;
        if (!$mentor || $intern->mentor_id !== $mentor->id) {
            abort(403, 'Unauthorized');
        }

        $intern->load([
            'attendances' => function ($q) {
                $q->orderByDesc('date')->take(30);
            },
            'logbooks' => function ($q) {
                $q->orderByDesc('date')->take(15);
            },
            'finalReport'
        ]);

        return view('mentor.intern.show', compact('mentor', 'intern'));
    }
}


