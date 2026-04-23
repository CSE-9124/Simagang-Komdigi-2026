<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Intern;
use App\Services\HolidayService;
use App\Services\TimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
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
        $institusi  = Auth::user()->institusi;
        $nowWita    = TimeService::nowWita();
        $todayWita  = $nowWita->toDateString();

        $internIds = $this->getInstitusiInternIds();

        $query = Attendance::query()
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
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $attendances = $query->orderByDesc('date')->paginate(20)->withQueryString();

        // Dropdown filter: hanya intern dari institusi ini
        $interns = Intern::whereIn('id', $internIds)->orderBy('name')->get();

        // Deteksi intern belum absen hari ini
        $todayAbsentInterns = collect();
        $isWorkday    = !HolidayService::isHoliday($nowWita);
        $noDateFilter = !$request->filled('date_from') && !$request->filled('date_to');
        $noStatusFilter = !$request->filled('status') || $request->input('status') === 'alfa';

        if ($isWorkday && $noDateFilter && $noStatusFilter && $internIds->isNotEmpty()) {
            $presentIds = Attendance::whereIn('intern_id', $internIds)
                ->whereDate('date', $todayWita)
                ->pluck('intern_id');

            $todayAbsentInterns = $interns->whereNotIn('id', $presentIds->toArray());

            if ($request->filled('intern_id')) {
                $todayAbsentInterns = $todayAbsentInterns->where('id', $request->integer('intern_id'));
            }
        }

        return view('institusi.attendance.index', compact(
            'institusi', 'attendances', 'interns', 'todayAbsentInterns', 'todayWita'
        ));
    }

}