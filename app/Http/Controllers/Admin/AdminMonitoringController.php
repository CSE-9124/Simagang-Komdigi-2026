<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminMonitoringController extends Controller
{
    public function index(Request $request)
    {
        // Default to current month
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        $selectedYear = $request->input('year', now()->year);
        
        // Parse month and year
        $month = Carbon::createFromFormat('Y-m', $selectedMonth);
        $startOfMonth = $month->copy()->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();

        // Get interns that started in this month (masuk)
        $internsMasuk = Intern::whereBetween('start_date', [$startOfMonth, $endOfMonth])
            ->with(['mentor', 'user'])
            ->get();

        // Get interns that ended in this month (keluar/pelepasan)
        $internsKeluar = Intern::whereBetween('end_date', [$startOfMonth, $endOfMonth])
            ->with(['mentor', 'user'])
            ->get();

        // Get active interns (still active in this month)
        $internsAktif = Intern::where('is_active', true)
            ->where('start_date', '<=', $endOfMonth)
            ->where(function($query) use ($startOfMonth) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $startOfMonth);
            })
            ->with(['mentor', 'user'])
            ->get();

        // Get interns that completed (pelepasan) in this month
        $internsPelepasan = Intern::where('is_active', false)
            ->whereBetween('end_date', [$startOfMonth, $endOfMonth])
            ->with(['mentor', 'user'])
            ->get();

        // Group by institution (kampus) for active interns
        $groupByInstitution = $internsAktif->groupBy('institution')->map(function ($interns, $institution) {
            return [
                'institution' => $institution,
                'count' => $interns->count(),
                'interns' => $interns->map(function ($intern) {
                    return [
                        'name' => $intern->name,
                        'mentor' => $intern->mentor ? $intern->mentor->name : 'Belum ada mentor',
                    ];
                })->values(),
            ];
        })->values();

        // Group by mentor for active interns
        $groupByMentor = $internsAktif->filter(function ($intern) {
            return $intern->mentor !== null;
        })->groupBy('mentor_id')->map(function ($interns, $mentorId) {
            $mentor = $interns->first()->mentor;
            return [
                'mentor_id' => $mentorId,
                'mentor_name' => $mentor->name,
                'count' => $interns->count(),
                'interns' => $interns->map(function ($intern) {
                    return [
                        'name' => $intern->name,
                        'institution' => $intern->institution,
                    ];
                })->values(),
            ];
        })->values();

        // Statistics for last 12 months (for chart)
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $checkMonth = now()->subMonths($i);
            $checkStart = $checkMonth->copy()->startOfMonth();
            $checkEnd = $checkMonth->copy()->endOfMonth();

            $monthlyStats[] = [
                'month' => $checkMonth->format('M Y'),
                'masuk' => Intern::whereBetween('start_date', [$checkStart, $checkEnd])->count(),
                'keluar' => Intern::whereBetween('end_date', [$checkStart, $checkEnd])
                    ->where('is_active', false)
                    ->count(),
                'aktif' => Intern::where('is_active', true)
                    ->where('start_date', '<=', $checkEnd)
                    ->where(function($query) use ($checkStart) {
                        $query->whereNull('end_date')
                            ->orWhere('end_date', '>=', $checkStart);
                    })
                    ->count(),
            ];
        }

        // Get all mentors for filter
        $mentors = Mentor::where('is_active', true)->orderBy('name')->get();

        // Top Institutions (All time, ranked by total interns)
        $topInstitutions = Intern::select('institution', DB::raw('count(*) as total'))
            ->groupBy('institution')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        // Top Institutions for selected month
        $topInstitutionsThisMonth = Intern::whereBetween('start_date', [$startOfMonth, $endOfMonth])
            ->select('institution', DB::raw('count(*) as total'))
            ->groupBy('institution')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        return view('admin.monitoring.index', compact(
            'selectedMonth',
            'selectedYear',
            'internsMasuk',
            'internsKeluar',
            'internsAktif',
            'internsPelepasan',
            'groupByInstitution',
            'groupByMentor',
            'monthlyStats',
            'mentors',
            'topInstitutions',
            'topInstitutionsThisMonth'
        ));
    }
}
