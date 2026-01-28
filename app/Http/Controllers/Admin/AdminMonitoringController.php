<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use App\Models\Mentor;
use App\Exports\MonitoringExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AdminMonitoringController extends Controller
{
    public function index(Request $request)
    {
        // Get filter inputs
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        $selectedStatus = $request->input('status', 'all');
        $selectedMentor = $request->input('mentor_id', null);
        $selectedYear = Carbon::createFromFormat('Y-m', $selectedMonth)->year;
        
        // Parse month
        $month = Carbon::createFromFormat('Y-m', $selectedMonth);
        $startOfMonth = $month->copy()->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();

        // Get interns that started in this month (masuk)
        $internsMasuk = Intern::whereBetween('start_date', [$startOfMonth, $endOfMonth])
            ->with(['mentor', 'user'])
            ->orderBy('start_date', 'asc')
            ->get();

        // Get interns that ended in this month (keluar/pelepasan)
        $internsKeluar = Intern::whereBetween('end_date', [$startOfMonth, $endOfMonth])
            ->with(['mentor', 'user'])
            ->orderBy('end_date', 'asc')
            ->get();

        // Get active interns (still active in this month) - ordered by end_date (earliest first)
        $internsAktif = Intern::where('is_active', true)
            ->where('start_date', '<=', $endOfMonth)
            ->where(function($query) use ($startOfMonth) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $startOfMonth);
            })
            ->with(['mentor', 'user'])
            ->orderBy('end_date', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        // Get interns that will be released (akan pelepasan) - end_date in the selected month
        $internsAkanPelepasan = Intern::where('is_active', true)
            ->whereBetween('end_date', [$startOfMonth, $endOfMonth])
            ->with(['mentor', 'user'])
            ->orderBy('end_date', 'asc')
            ->get();

        // Get interns that completed (pelepasan) in this month - based on when status was changed
        $internsPelepasan = Intern::where('is_active', false)
            ->whereYear('updated_at', $month->year)
            ->whereMonth('updated_at', $month->month)
            ->with(['mentor', 'user'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Apply filter based on status selection
        $hasFilter = false;
        $filteredInterns = collect();

        // Check if any filter is actually applied (not default values)
        // $isFilterApplied = ($selectedStatus !== 'all' || $selectedMentor !== null || $request->has('status') || $request->has('mentor_id'));
        $isFilterApplied = (($request->filled('status') && $selectedStatus !== 'all') || ($request->filled('mentor_id') && $selectedMentor !== '')|| ($request->filled('institution') && $request->institution !== 'all'));
        
        if ($isFilterApplied) {
            $hasFilter = true;
            $query = Intern::with(['mentor', 'user']);

            // Filter by status
            if ($selectedStatus === 'masuk') {
                // Interns that entered in the selected month (based on start_date)
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth]);
            } elseif ($selectedStatus === 'aktif') {
                // Active interns during the selected month
                $query->where('is_active', true);
            } elseif ($selectedStatus === 'akan_pelepasan') {
                // Will be released in the selected month (based on end_date)
                $query->where('is_active', true)
                    ->whereBetween('end_date', [$startOfMonth, $endOfMonth]);
            } elseif ($selectedStatus === 'pelepasan') {
                // Released in the selected month (based on updated_at - when status was changed)
                $query->where('is_active', false)
                    ->whereYear('updated_at', $month->year)
                    ->whereMonth('updated_at', $month->month);
            }

            // Filter by mentor
            if ($selectedMentor !== null && $selectedMentor !== '') {
                $query->where('mentor_id', $selectedMentor);
            }

            // Filter by institution (kampus)
            if ($request->filled('institution') && $request->institution !== 'all') {
                $query->where('institution', $request->institution);
            }


            $filteredInterns = $query->orderBy('end_date', 'asc')
                ->orderBy('name', 'asc')
                ->paginate(15);


        } else {
            // Default: show all interns with activity in the selected month
            // Urutan: Akan Pelepasan → Aktif → Pelepasan (di bawah)
            $filteredInterns = Intern::where(function($query) use ($startOfMonth, $endOfMonth, $month) {
                // Interns active during this month
                $query->where(function($q) use ($startOfMonth, $endOfMonth) {
                    $q->where('is_active', true)
                        ->where('start_date', '<=', $endOfMonth)
                        ->where(function($q2) use ($startOfMonth) {
                            $q2->whereNull('end_date')
                                ->orWhere('end_date', '>=', $startOfMonth);
                        });
                })
                // OR interns that were released in this month
                ->orWhere(function($q) use ($month) {
                    $q->where('is_active', false)
                        ->whereYear('updated_at', $month->year)
                        ->whereMonth('updated_at', $month->month);
                });
            })
                ->with(['mentor', 'user'])
                ->orderByRaw('CASE WHEN is_active = true THEN 0 ELSE 1 END')
                ->orderBy('end_date', 'asc')
                ->orderBy('name', 'asc')
                ->paginate(15);
        }

        // Get interns released this month for monitoring section
        $releasedThisMonth = Intern::where('is_active', false)
            ->whereBetween('end_date', [$startOfMonth, $endOfMonth])
            ->with(['mentor', 'user'])
            ->orderBy('end_date', 'desc')
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

        // Statistics based on SELECTED MONTH (not current month)
        // Masuk: start_date in selected month
        $masukCount = Intern::whereBetween('start_date', [$startOfMonth, $endOfMonth])->count();
        
        // Keluar/Pelepasan: end_date (rencana pelepasan) in selected month
        $keluarCount = Intern::whereBetween('end_date', [$startOfMonth, $endOfMonth])->count();
        
        // Aktif: is_active=true during selected month
        $aktifCount = Intern::where('is_active', true)
            ->where('start_date', '<=', $endOfMonth)
            ->where(function($query) use ($startOfMonth) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $startOfMonth);
            })
            ->count();

        // Statistics for last 12 months (for chart) - Based on selected month baseline
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $checkMonth = now()->subMonths($i);
            $checkStart = $checkMonth->copy()->startOfMonth();
            $checkEnd = $checkMonth->copy()->endOfMonth();

            // Masuk: start_date in this month
            $masuk = Intern::whereBetween('start_date', [$checkStart, $checkEnd])->count();
            
            // Keluar: is_active changed to false (updated_at) in this month
            $keluar = Intern::where('is_active', false)
                ->whereYear('updated_at', $checkMonth->year)
                ->whereMonth('updated_at', $checkMonth->month)
                ->count();
            
            // Aktif: is_active=true during this month
            $aktif = Intern::where('is_active', true)
                ->where('start_date', '<=', $checkEnd)
                ->where(function($query) use ($checkStart) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', $checkStart);
                })
                ->count();

            $monthlyStats[] = [
                'month' => $checkMonth->format('M Y'),
                'masuk' => $masuk,
                'keluar' => $keluar,
                'aktif' => $aktif,
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

        //kampus
        $institutions = Intern::select('institution')
            ->whereNotNull('institution')
            ->distinct()
            ->orderBy('institution')
            ->pluck('institution');


        return view('admin.monitoring.index', compact(
            'selectedMonth',
            'selectedYear',
            'selectedStatus',
            'selectedMentor',
            'hasFilter',
            'filteredInterns',
            'releasedThisMonth',
            'internsMasuk',
            'internsKeluar',
            'internsAktif',
            'internsPelepasan',
            'internsAkanPelepasan',
            'groupByInstitution',
            'groupByMentor',
            'monthlyStats',
            'mentors',
            'topInstitutions',
            'institutions',
            'topInstitutionsThisMonth',
            'masukCount',
            'keluarCount',
            'aktifCount'
        ));
    }

    /**
     * Mark an intern as released (pelepasan)
     */
    public function markAsReleased(Intern $intern)
    {
        try {
            $intern->update([
                'is_active' => false,
            ]);

            return redirect()->back()->with('success', 'Mahasiswa ' . $intern->name . ' berhasil ditandai sebagai pelepasan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah status mahasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Mark an intern as active again
     */
    public function markAsActive(Intern $intern)
    {
        try {
            $intern->update([
                'is_active' => true,
            ]);

            return redirect()->back()->with('success', 'Mahasiswa ' . $intern->name . ' berhasil ditandai sebagai aktif.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah status mahasiswa: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        // Prepare filters
        $filters = [
            'institution' => $request->input('institution'),
            'mentor_id' => $request->input('mentor_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'is_active' => $request->input('is_active', '1'), // Default to active
        ];

        // Generate filename with timestamp
        $filename = 'Laporan_Monitoring_' . now()->format('Y-m-d_His') . '.xlsx';

        // Export
        // return Excel::download(new MonitoringExport($filters), $filename);
        return Excel::download(
            new MonitoringExport([
                'month'       => $request->month,
                'status'      => $request->status,
                'mentor_id'   => $request->mentor_id,
                'institution' => $request->institution,
            ]),
            $filename
        );
    }
}
