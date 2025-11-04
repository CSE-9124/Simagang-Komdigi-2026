<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Intern;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('intern');

        if ($request->filled('intern_id')) {
            $query->where('intern_id', $request->intern_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $interns = Intern::where('is_active', true)->get();

        return view('admin.attendance.index', compact('attendances', 'interns'));
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