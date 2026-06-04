<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Industri;

class AdminLowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lowongan::with('industri')
        ->orderByRaw("
            CASE
                WHEN status_verifikasi = 'pending' THEN 1
                WHEN status_verifikasi = 'ditolak' THEN 2
                WHEN status_verifikasi = 'disetujui' THEN 3
                ELSE 4
            END
        ")
        ->latest();

        // search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('judul_lowongan', 'like', '%' . $search . '%')
                    ->orWhere('posisi_magang', 'like', '%' . $search . '%')
                    ->orWhere('divisi', 'like', '%' . $search . '%')
                    ->orWhere('fasilitas', 'like', '%' . $search . '%')
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

        return view('admin.lowongan.index', compact(
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
        return view('admin.lowongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'judul_lowongan'      => 'required|string|max:255',
            'posisi_magang'       => 'required|string|max:255',
            'divisi'              => 'required|string|max:255',
            'deskripsi_pekerjaan' => 'required|string',
            'requirements'        => 'required|string',
            'fasilitas'           => 'required|string',
            'kuota_peserta'       => 'required|integer|min:1',
            'status'              => 'required|in:aktif,nonaktif',
        ], [
            'required' => ':attribute wajib diisi.',
        ]);

        // Simpan lowongan
        Lowongan::create([
            'judul_lowongan'      => $request->judul_lowongan,
            'posisi_magang'       => $request->posisi_magang,
            'divisi'              => $request->divisi,
            'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan,
            'requirements'        => $request->requirements,
            'fasilitas'           => $request->fasilitas,
            'kuota_peserta'       => $request->kuota_peserta,

            // Mapping status
            'status' => $request->status === 'aktif'
                ? 'dibuka'
                : 'ditutup',
        ]);

        return redirect()
            ->route('admin.lowongan.index')
            ->with('success', 'Lowongan magang berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lowongan = Lowongan::with('industri')
        ->findOrFail($id);

        return view('admin.lowongan.show', compact('lowongan'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $lowongan->delete();

        return redirect()
            ->route('admin.lowongan.index')
            ->with('success', 'Lowongan berhasil dihapus.');
    }

    public function approve(string $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $lowongan->update([
            'status_verifikasi' => 'disetujui',
        ]);

        return redirect()
            ->route('admin.lowongan.index')
            ->with('success', 'Lowongan berhasil disetujui.');
    }

    public function reject(string $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $lowongan->update([
            'status_verifikasi' => 'ditolak',
        ]);

        return redirect()
            ->route('admin.lowongan.index')
            ->with('success', 'Lowongan berhasil ditolak.');
    }
}
