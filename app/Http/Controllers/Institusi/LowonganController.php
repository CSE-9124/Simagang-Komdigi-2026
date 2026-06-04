<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Industri;
use App\Models\Lowongan;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lowongan::with('industri')
        ->orderBy('updated_at', 'desc');

        // search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('judul_lowongan', 'like', '%' . $search . '%')
                    ->orWhere('posisi_magang', 'like', '%' . $search . '%')
                    ->orWhere('divisi', 'like', '%' . $search . '%')
                    ->orWhereHas('industri', function ($industri) use ($search) {
                        $industri->where('nama_industri', 'like', '%' . $search . '%');
                    });
            });
        }

        // filter status
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // filter perusahaan
        if ($request->filled('perusahaan')) {
            $query->whereHas('industri', function ($q) use ($request) {
                $q->where('id', $request->perusahaan);
            });
        }

        // filter divisi
        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        // data statistik
        $totalLowongan = Lowongan::count();

        $totalPending = Lowongan::where('status_verifikasi', 'pending')->count();

        $totalApprove = Lowongan::where('status_verifikasi', 'disetujui')->count();

        $totalTolak = Lowongan::where('status_verifikasi', 'ditolak')->count();

        // data filter dropdown
        $perusahaans = Industri::orderBy('nama_industri')->get();

        $divisis = Lowongan::select('divisi')
            ->whereNotNull('divisi')
            ->distinct()
            ->pluck('divisi');

        // data lowongan
        $lowongans = $query
            ->latest()
            ->paginate(10)
            ->appends(request()->query());

        return view('institusi.lowongan.index', compact(
            'lowongans',
            'totalLowongan',
            'totalPending',
            'totalApprove',
            'totalTolak',
            'perusahaans',
            'divisis'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lowongan = Lowongan::with('industri')
        ->findOrFail($id);

        return view('institusi.lowongan.show', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
