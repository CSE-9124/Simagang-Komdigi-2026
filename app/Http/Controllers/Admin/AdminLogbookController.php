<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use App\Models\Intern;
use App\Models\Logbook;
use Illuminate\Http\Request;

class AdminLogbookController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_logbook')->only(['index', 'servePhoto']);
        $this->middleware('permission:manage_logbook')->only(['destroy']);
    }

    private function adminInternIds(): \Illuminate\Support\Collection
    {
        $komdigi = Industri::where('nama_industri', 'BBLSDM Komdigi Makassar')->first();

        return Intern::where(function ($q) use ($komdigi) {
            $q->whereNull('pengajuan_detail_id');

            if ($komdigi) {
                $q->orWhereHas('pengajuanDetail.pengajuan.lowongan', function ($lq) use ($komdigi) {
                    $lq->where('industri_id', $komdigi->id);
                });
            }
        })->pluck('id');
    }

    public function index(Request $request)
    {
        $internIds = $this->adminInternIds();

        $query = Logbook::with('intern')
            ->whereIn('intern_id', $internIds);

        if ($request->filled('q')) {
            $q = '%' . $request->input('q') . '%';
            $query->whereHas('intern', function ($sub) use ($q) {
                $sub->where('name', 'like', $q)
                    ->orWhere('institution', 'like', $q);
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date('date_to'));
        }

        $logbooks = $query->orderByDesc('date')->paginate(20);

        return view('admin.logbook.index', compact('logbooks'));
    }

    public function servePhoto(string $filename)
    {
        if ($filename !== basename($filename)) {
            abort(404, 'File not found');
        }

        $photoPath = 'private/logbook-photos/' . $filename;

        $logbook = Logbook::where('photo_path', $photoPath)->firstOrFail();

        abort_unless(
            $this->adminInternIds()->contains($logbook->intern_id),
            403
        );

        $this->authorize('view', $logbook);

        $fullPath = storage_path('app/' . $photoPath);

        if (!file_exists($fullPath)) {
            abort(404, 'File not found');
        }

        return response()->file($fullPath, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, private',
            'Pragma'        => 'no-cache',
            'Expires'       => '0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function destroy(Logbook $logbook)
    {
        abort_unless(
            $this->adminInternIds()->contains($logbook->intern_id),
            403
        );

        $this->authorize('delete', $logbook);

        $logbook->delete();

        return back()->with('success', 'Logbook berhasil dihapus.');
    }
}