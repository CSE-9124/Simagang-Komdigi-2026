<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\FinalReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $intern = Auth::user()->intern;
        $report = $intern->finalReport;

        return view('intern.report.index', compact('report'));
    }

    public function store(Request $request)
    {
        $intern = Auth::user()->intern;

        // Check if already has a report
        if ($intern->finalReport) {
            return back()->withErrors(['error' => 'Anda sudah mengupload laporan akhir.']);
        }

        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'project_file' => ['nullable', 'file', 'mimes:zip,rar,7z,tar,gz', 'max:51200'],
            'project_link' => ['nullable', 'url', 'max:1024'],
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        
        if ($file->isValid() && $file->getError() === UPLOAD_ERR_OK) {
            try {
                $extension = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'pdf');
                $filename = 'report_' . time() . '_' . uniqid() . '.' . $extension;
                $destinationPath = storage_path('app/public/final-reports');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                if ($file->move($destinationPath, $filename) && file_exists($fullPath)) {
                    $filePath = 'final-reports/' . $filename;
                } else {
                    return back()->withErrors(['file' => 'Gagal menyimpan file.'])->withInput();
                }
            } catch (\Exception $e) {
                return back()->withErrors(['file' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
            }
        } else {
            return back()->withErrors(['file' => 'File tidak valid.'])->withInput();
        }

        $projectFilePath = null;
        if ($request->hasFile('project_file')) {
            $pfile = $request->file('project_file');
            if ($pfile->isValid()) {
                $pext = $pfile->getClientOriginalExtension() ?: 'zip';
                $pname = 'project_' . time() . '_' . uniqid() . '.' . $pext;
                $pdest = storage_path('app/public/projects');
                if (!file_exists($pdest)) mkdir($pdest, 0755, true);
                if ($pfile->move($pdest, $pname) && file_exists($pdest . DIRECTORY_SEPARATOR . $pname)) {
                    $projectFilePath = 'projects/' . $pname;
                }
            }
        }

        FinalReport::create([
            'intern_id' => $intern->id,
            'file_path' => $filePath,
            'project_file' => $projectFilePath,
            'project_link' => $request->input('project_link'),
            'file_name' => $fileName,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return redirect()->route('intern.report.index')
            ->with('success', 'Laporan akhir berhasil diupload.');
    }

    public function update(Request $request, FinalReport $report)
    {
        // Ensure the report belongs to the authenticated intern
        if ($report->intern_id !== Auth::user()->intern->id) {
            abort(403);
        }

        // Allow update if status is pending, rejected, or needs revision
        if ($report->status === 'approved' && !$report->needs_revision) {
            return back()->withErrors(['error' => 'Laporan yang sudah disetujui dan tidak perlu revisi tidak dapat diubah.']);
        }

        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'project_file' => ['nullable', 'file', 'mimes:zip,rar,7z,tar,gz', 'max:51200'],
            'project_link' => ['nullable', 'url', 'max:1024'],
        ]);

        // Delete old report file
        if ($report->file_path) {
            $oldPath = storage_path('app/public/' . $report->file_path);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        // Handle project file replacement
        if ($request->hasFile('project_file')) {
            // delete old project file if exists
            if ($report->project_file) {
                $oldP = storage_path('app/public/' . $report->project_file);
                if (file_exists($oldP)) {
                    @unlink($oldP);
                }
            }
            $pfile = $request->file('project_file');
            if ($pfile->isValid()) {
                $pext = $pfile->getClientOriginalExtension() ?: 'zip';
                $pname = 'project_' . time() . '_' . uniqid() . '.' . $pext;
                $pdest = storage_path('app/public/projects');
                if (!file_exists($pdest)) mkdir($pdest, 0755, true);
                if ($pfile->move($pdest, $pname) && file_exists($pdest . DIRECTORY_SEPARATOR . $pname)) {
                    $projectFilePath = 'projects/' . $pname;
                } else {
                    $projectFilePath = null;
                }
            }
        } else {
            $projectFilePath = $report->project_file;
        }

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        
        if ($file->isValid() && $file->getError() === UPLOAD_ERR_OK) {
            try {
                $extension = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'pdf');
                $filename = 'report_' . time() . '_' . uniqid() . '.' . $extension;
                $destinationPath = storage_path('app/public/final-reports');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                if ($file->move($destinationPath, $filename) && file_exists($fullPath)) {
                    $filePath = 'final-reports/' . $filename;
                } else {
                    return back()->withErrors(['file' => 'Gagal menyimpan file.'])->withInput();
                }
            } catch (\Exception $e) {
                return back()->withErrors(['file' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
            }
        } else {
            return back()->withErrors(['file' => 'File tidak valid.'])->withInput();
        }

        $report->update([
            'file_path' => $filePath,
            'project_file' => $projectFilePath,
            'project_link' => $request->input('project_link'),
            'file_name' => $fileName,
            'status' => 'pending',
            'needs_revision' => false, // Reset revision flag when resubmitted
            'submitted_at' => now(),
        ]);

        return redirect()->route('intern.report.index')
            ->with('success', 'Laporan akhir berhasil diperbarui.');
    }
}