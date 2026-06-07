<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use App\Models\Intern;
use Illuminate\Http\Request;

class AdminMonitoringIndustriController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_interns');
    }

    public function index(Request $request)
    {
        $industris = Industri::where('nama_industri', '!=', 'BBLSDM Komdigi Makassar')
            ->get()
            ->map(function ($industri) {
                $internQuery = Intern::whereHas('pengajuanDetail.pengajuan.lowongan', function ($q) use ($industri) {
                    $q->where('industri_id', $industri->id);
                });

                $industri->total_intern  = $internQuery->count();
                $industri->active_intern = (clone $internQuery)->where('is_active', true)->count();
                $industri->alumni_intern = (clone $internQuery)->where('is_active', false)->count();

                return $industri;
            });

        $totalIndustri = $industris->count();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $industris = $industris->filter(fn($i) => str_contains(strtolower($i->nama_industri), $search));
        }

        return view('admin.monitoring.industri.index', compact('industris', 'totalIndustri'));
    }

    public function show(Request $request, Industri $industri)
    {
        if ($industri->nama_industri === 'BBLSDM Komdigi Makassar') {
            return redirect()->route('admin.intern.index');
        }

        $baseQuery = Intern::with(['attendances', 'logbooks'])
            ->whereHas('pengajuanDetail.pengajuan.lowongan', function ($q) use ($industri) {
                $q->where('industri_id', $industri->id);
            });

        if ($request->filled('search')) {
            $baseQuery->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $baseQuery->where('is_active', $request->status === 'active');
        }

        $interns = $baseQuery->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $interns->getCollection()->transform(function ($intern) {
            $total = $intern->attendances->count();
            $hadir = $intern->attendances->where('status', 'hadir')->count();
            $intern->attendance_pct   = $total > 0 ? round(($hadir / $total) * 100) : 0;
            $intern->total_logbooks   = $intern->logbooks->count();
            $intern->total_microskill = $intern->microskills()->count();
            return $intern;
        });

        $stats = [
            'total'  => $baseQuery->count(),
            'active' => (clone $baseQuery)->where('is_active', true)->count(),
            'alumni' => (clone $baseQuery)->where('is_active', false)->count(),
        ];

        return view('admin.monitoring.industri.show', compact('industri', 'interns', 'stats'));
    }
}