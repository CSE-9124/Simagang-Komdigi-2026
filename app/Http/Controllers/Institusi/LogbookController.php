<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogbookController extends Controller
{
    private function getInstitusiInternIds(): \Illuminate\Support\Collection
    {
        $institusi = Auth::user()->institusi;

        if (!$institusi) {
            return collect();
        }

        return DB::table('interns')
            ->join('users', 'users.id', '=', 'interns.user_id')
            ->join('pengajuan_details', 'pengajuan_details.email', '=', 'users.email')
            ->join('pengajuans', 'pengajuans.id', '=', 'pengajuan_details.pengajuan_id')
            ->where('pengajuans.institusi_id', $institusi->id)
            ->where('interns.is_active', true)
            ->pluck('interns.id');
    }

    public function index(Request $request)
    {
        $institusi = Auth::user()->institusi;
        $internIds = $this->getInstitusiInternIds();

        $query = Logbook::query()
            ->with('intern')
            ->whereIn('intern_id', $internIds);

        if ($request->filled('intern_id')) {
            $query->where('intern_id', $request->integer('intern_id'));
        }
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date('date_to'));
        }

        $logbooks = $query->orderByDesc('date')->paginate(20)->withQueryString();

        $interns = $internIds->isNotEmpty()
            ? Intern::whereIn('id', $internIds)->orderBy('name')->get()
            : collect();

        return view('institusi.logbook.index', compact('institusi', 'logbooks', 'interns'));
    }

    public function show(Logbook $logbook)
    {
        $internIds = $this->getInstitusiInternIds();

        abort_unless(
            $internIds->contains($logbook->intern_id),
            403,
            'Anda tidak memiliki akses ke data logbook ini.'
        );

        $logbook->load('intern');

        return view('institusi.logbook.show', compact('logbook'));
    }
}