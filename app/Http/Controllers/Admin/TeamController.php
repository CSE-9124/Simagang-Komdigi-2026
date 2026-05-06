<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_teams');
    }

    public function index()
    {
        $teams = Team::withCount(['mentors', 'interns'])
            ->orderBy('name')
            ->paginate(10);

        return view('admin.team.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:teams,name'],
        ]);

        Team::create($validated);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team berhasil ditambahkan.');
    }

    public function edit(Team $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:teams,name,' . $team->id],
        ]);

        $team->update($validated);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team berhasil diperbarui.');
    }

    public function destroy(Team $team)
    {
        // // Cegah hapus jika masih punya mentor / intern
        // if ($team->mentors()->count() > 0 || $team->interns()->count() > 0) {
        //     return back()->withErrors([
        //         'error' => 'Team tidak bisa dihapus karena masih memiliki mentor atau intern.'
        //     ]);
        // }

        // Set mentor & intern jadi tanpa tim
        $team->mentors()->update(['team_id' => null]);
        $team->interns()->update(['team_id' => null]);

        $team->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'Team berhasil dihapus.');
    }
}