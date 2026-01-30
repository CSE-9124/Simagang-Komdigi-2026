<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use App\Models\Mentor;
use App\Exports\MonitoringExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AdminMonitoringController extends Controller
{
    public function index(Request $request)
    {
        // ambil input, default ke sekarang hari 01
$rawMonth = $request->input('month', Carbon::now()->format('Y-m-01'));

// Normalisasi status/mentor seperti sebelumnya
$rawStatus = $request->input('status', 'all');
$selectedStatus = str_replace('-', '_', $rawStatus);
$selectedMentor = $request->input('mentor_id', null);

try {
    // Carbon::parse menerima: "2026-01", "2026-01-01", "2026-01-01 12:00:00", ISO8601, dsb.
    // lalu paksa ke awal bulan agar selalu ada day = 01
    $month = Carbon::parse($rawMonth)->startOfMonth();
} catch (\Exception $e) {
    // fallback aman kalau input rusak
    $month = Carbon::now()->startOfMonth();
}

$startOfMonth = $month->copy()->startOfMonth();
$endOfMonth = $month->copy()->endOfMonth();
$year = $month->year;
$mon = $month->month;

// jika butuh string dengan day 01
$selectedMonth = $month->format('Y-m-d'); // ex: "2026-01-01"

// atau kalau kamu butuh hanya "Y-m" untuk createFromFormat('Y-m', ...)
$selectedMonthYm = $month->format('Y-m');
$selectedYear = $month->year;


        // Debug: log selected month
        Log::debug('Monitoring selectedMonth', ['selectedMonth' => $selectedMonth, 'year' => $year, 'month' => $mon]);

        // Get interns that started in this month (masuk) - use year/month for robustness
        $internsMasuk = Intern::whereYear('start_date', $year)
            ->whereMonth('start_date', $mon)
            ->with(['mentor', 'user'])
            ->orderBy('start_date', 'asc')
            ->get();

        // Get interns that ended in this month (keluar/pelepasan) - based on end_date (rencana)
        $internsKeluar = Intern::whereYear('end_date', $year)
            ->whereMonth('end_date', $mon)
            ->with(['mentor', 'user'])
            ->orderBy('end_date', 'asc')
            ->get();

        // Get active interns (still active in this month) - ordered by end_date (earliest first)
        $internsAktif = Intern::where('is_active', true)
            ->whereDate('start_date', '<=', $endOfMonth)
            ->with(['mentor', 'user'])
            ->orderBy('end_date', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        // Get interns that will be released (akan pelepasan) - end_date in the selected month
        $internsAkanPelepasan = Intern::where('is_active', true)
            ->whereYear('end_date', $year)
            ->whereMonth('end_date', $mon)
            ->with(['mentor', 'user'])
            ->orderBy('end_date', 'asc')
            ->get();

        // Get interns that completed (pelepasan) in this month - based on when status was changed (updated_at)
        $internsPelepasan = Intern::where('is_active', false)
            ->whereYear('updated_at', $year)
            ->whereMonth('updated_at', $mon)
            ->with(['mentor', 'user'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Apply filter based on status selection
        $hasFilter = false;
        $filteredInterns = collect();

        // Check if any filter is actually applied (not default values)
        $isFilterApplied = (($request->filled('status') && $selectedStatus !== 'all') || ($request->filled('mentor_id') && $selectedMentor !== '')|| ($request->filled('institution') && $request->institution !== 'all'));
        
        if ($isFilterApplied) {
            $hasFilter = true;
            $query = Intern::with(['mentor', 'user']);

            // Filter by status
            if ($selectedStatus === 'masuk') {
                // Interns that entered in the selected month (based on start_date)
                $query->whereYear('start_date', $year)
                    ->whereMonth('start_date', $mon);
            } elseif ($selectedStatus === 'aktif') {
                // Active interns during the selected month (consider start/end dates)
                $query->where('is_active', true);
            } elseif ($selectedStatus === 'akan_pelepasan') {
                // Will be released in the selected month (based on end_date)
                $query->where('is_active', true)
                    ->whereNotNull('end_date')
                    ->whereBetween('end_date', [
                        $month->copy()->startOfMonth(),
                        $month->copy()->endOfMonth()
                    ]);
            } elseif ($selectedStatus === 'pelepasan') {
                // Released in the selected month (based on updated_at - when status was changed)
                $query->where('is_active', false)
                    ->whereYear('updated_at', $year)
                    ->whereMonth('updated_at', $mon);
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
            $filteredInterns = Intern::where(function ($query) use ($endOfMonth) {

            // SEMUA INTERN YANG MASIH AKTIF
            $query->where('is_active', true)
                ->whereDate('start_date', '<=', $endOfMonth->toDateString());

        })
        ->orWhere(function ($q) use ($month) {

            // INTERN YANG SUDAH DILEPAS (MANUAL) DI BULAN TERPILIH
            $q->where('is_active', false)
            ->whereYear('updated_at', $month->year)
            ->whereMonth('updated_at', $month->month);

        })
        ->with(['mentor', 'user'])
        ->orderByRaw('CASE WHEN is_active = true THEN 0 ELSE 1 END')
        ->orderBy('end_date', 'asc')
        ->orderBy('name', 'asc')
        ->paginate(15);

        }

        // Get interns released this month for monitoring section (rencana pelepasan berdasarkan end_date)
        $releasedThisMonth = Intern::whereYear('end_date', $year)
            ->whereMonth('end_date', $mon)
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
        $masukCount = Intern::whereYear('start_date', $year)
            ->whereMonth('start_date', $mon)
            ->count();
        
        // Keluar/Pelepasan: end_date (rencana pelepasan) in selected month
        $keluarCount = Intern::where('is_active', true)
            ->whereNotNull('end_date')
            ->whereYear('end_date', $year)
            ->whereMonth('end_date', $mon)
            ->count();
        
        // Aktif: is_active=true during selected month
        $aktifCount = Intern::where('is_active', true)->count();

        // Statistics for last 12 months (for chart) - Based on selected month baseline
        // Statistics for last 12 months (for chart)
$monthlyStats = [];
for ($i = 11; $i >= 0; $i--) {
    $checkMonth = $month->copy()->subMonths($i);
    $checkYear = $checkMonth->year;
    $checkMon = $checkMonth->month;
    
    // Pastikan kita menggunakan tanggal yang valid untuk bulan tersebut
    $startOfCheckMonth = $checkMonth->copy()->startOfMonth();
    $endOfCheckMonth = $checkMonth->copy()->endOfMonth();

    // Masuk: start_date in this month
    $masuk = Intern::whereYear('start_date', $checkYear)
        ->whereMonth('start_date', $checkMon)
        ->count();
    
    // Keluar: is_active changed to false (updated_at) in this month
    $keluar = Intern::where('is_active', false)
        ->whereYear('updated_at', $checkYear)
        ->whereMonth('updated_at', $checkMon)
        ->count();
    
    // Aktif: is_active=true during this month (diperbaiki)
    $aktif = Intern::where('is_active', true)
        ->where('start_date', '<=', $endOfCheckMonth)
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

        // Top Institutions for selected month (based on start_date)
        $topInstitutionsThisMonth = Intern::whereYear('start_date', $year)
            ->whereMonth('start_date', $mon)
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
            'selectedMonthYm ',
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