<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinalReport;
use App\Models\Intern;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_reports')->only(['index', 'show']);
        $this->middleware('permission:manage_reports')->only(['updateStatus']);
    }

    public function index(Request $request)
    {
        $query = FinalReport::with('intern');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('intern_id')) {
            $query->where('intern_id', $request->intern_id);
        }

        $reports = $query->orderBy('submitted_at', 'desc')->paginate(20);
        $interns = Intern::where('is_active', true)->get();

        return view('admin.report.index', compact('reports', 'interns'));
    }

    public function show(FinalReport $report)
    {
        $this->authorize('view', $report);

        $report->load('intern');
        return view('admin.report.show', compact('report'));
    }

    public function updateStatus(Request $request, FinalReport $report)
    {
        $this->authorize('grade', $report);

        $rules = [
            'status' => ['required', 'in:approved,rejected,revised'],
            'admin_note' => ['nullable', 'string'],
        ];

        $validated = $request->validate($rules);

        // VALIDASI WAJIB
        if (
            $validated['status'] === 'approved' &&
            is_null($report->mentor_score)
        ) {
            return back()->with(
                'error',
                'Laporan tidak dapat disetujui sebelum mentor memberikan nilai.'
            );
        }

        $data = [
            'admin_note' => $validated['admin_note'] ?? null,
        ];

        if ($validated['status'] === 'approved') {
            $data['status'] = 'approved';
            $data['needs_revision'] = false;
        } elseif ($validated['status'] === 'revised') {
            $data['status'] = 'pending';
            $data['needs_revision'] = true;
        } else {
            $data['status'] = 'rejected';
            $data['needs_revision'] = false;
        }

        $report->update($data);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}