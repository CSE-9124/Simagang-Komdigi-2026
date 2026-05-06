<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Intern;
use App\Services\HolidayService;
use App\Services\TimeService;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_attendance')->only(['index', 'show']);
        $this->middleware('permission:manage_attendance')->only(['updateDocumentStatus']);
    }

    public function index(Request $request)
    {
        $nowWita   = TimeService::nowWita();
        $todayWita = $nowWita->toDateString();

        $query = Attendance::with('intern');

        if ($request->filled('intern_id')) {
            $query->where('intern_id', $request->intern_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $interns = Intern::orderBy('name')->get();


        $todayAbsentInterns = collect();
        $isWorkday    = !HolidayService::isHoliday($nowWita);
        $noDateFilter = !$request->filled('date_from') && !$request->filled('date_to');
        $noStatusFilter = !$request->filled('status') || $request->input('status') === 'alfa';

        if ($isWorkday && $noDateFilter && $noStatusFilter) {
            $presentIds = Attendance::whereDate('date', $todayWita)->pluck('intern_id')->toArray();
            $absentQuery = Intern::where('is_active', true)->whereNotIn('id', $presentIds)->orderBy('name');

            if ($request->filled('intern_id')) {
                $absentQuery->where('id', $request->integer('intern_id'));
            }

            $todayAbsentInterns = $absentQuery->get();
        }

        return view('admin.attendance.index', compact('attendances', 'interns', 'todayAbsentInterns', 'todayWita'));
    }

    public function show(Attendance $attendance)
    {
        $attendance->load('intern');
        return view('admin.attendance.show', compact('attendance'));
    }

    public function updateDocumentStatus(Request $request, Attendance $attendance)
    {
        if (!in_array($attendance->status, ['izin', 'sakit'])) {
            return back()->withErrors(['error' => 'Status absensi ini tidak memiliki dokumen.']);
        }

        $validated = $request->validate([
            'document_status' => ['required', 'in:approved,rejected'],
            'admin_note' => ['nullable', 'string'],
        ]);

        $attendance->update([
            'document_status' => $validated['document_status'],
            'admin_note' => $validated['admin_note'] ?? null,
        ]);

        return back()->with('success', 'Status dokumen berhasil diperbarui.');
    }
}