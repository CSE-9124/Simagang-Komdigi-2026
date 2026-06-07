<?php

namespace App\Http\Controllers\Industri;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Team;

class IndustriLowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $industri = $user->industri;

        // Default data agar tidak error
        $lowongans = new LengthAwarePaginator([], 0, 10);

        $totalLowongan = 0;
        $lowonganDibuka = 0;
        $lowonganDitutup = 0;
        $totalLowonganFilter = 0;
        $totalPesertaMagan = 0;

        // Jalankan query hanya jika industri tersedia
        if ($industri) {

            $query = Lowongan::where('industri_id', $industri->id);

            // Search
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('judul_lowongan', 'like', '%' . $request->search . '%')
                        ->orWhere('posisi_magang', 'like', '%' . $request->search . '%')
                        ->orWhere('divisi', 'like', '%' . $request->search . '%')
                        ->orWhere('fasilitas', 'like', '%' . $request->search . '%');
                });
            }

            // Filter status lowongan
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter status verifikasi
            if ($request->filled('status_verifikasi')) {
                $query->where('status_verifikasi', $request->status_verifikasi);
            }

            // Filter tanggal
            if ($request->filled('date')) {
                $query->whereDate('created_at', $request->date);
            }

            // Data lowongan
            $lowongans = $query->latest()->paginate(10);

            // Statistik
            $totalLowongan = Lowongan::where('industri_id', $industri->id)
                ->count();

            $lowonganDibuka = Lowongan::where('industri_id', $industri->id)
                ->where('status', 'dibuka')
                ->count();

            $lowonganDitutup = Lowongan::where('industri_id', $industri->id)
                ->where('status', 'ditutup')
                ->count();

            $totalLowonganFilter = $lowongans->total();

            // $totalPesertaMagan = Lowongan::where('industri_id', $industri->id)
            //     ->withCount('interns')
            //     ->get()
            //     ->sum('interns_count');
        }

        return view('industri.lowongan.index', compact(
            'industri',
            'lowongans',
            'totalLowongan',
            'lowonganDibuka',
            'lowonganDitutup',
            'totalLowonganFilter',
            // 'totalPesertaMagan'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industri = auth()->user()->industri;

        if (!$this->profilLengkap($industri)) {
            return redirect()
                ->route('industri.lowongan.index')
                ->with(
                    'error',
                    'Lengkapi profil industri terlebih dahulu sebelum membuat lowongan.'
                );
        }

        $teams = Team::orderBy('name')->get();
        return view('industri.lowongan.create', compact('industri', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $industri = auth()->user()->industri;

        // Cegah jika profil belum lengkap
        if (!$this->profilLengkap($industri)) {
            return redirect()
                ->route('industri.lowongan.index')
                ->with('error', 'Profil industri belum lengkap.');
        }

        // Validasi
        $request->validate([
            'judul_lowongan'      => 'required|string|max:255',
            'posisi_magang'       => 'required|string|max:255',
            'divisi'              => 'required|string|max:255',
            'deskripsi_pekerjaan' => 'required|string',
            'requirements'        => 'required|string',
            'fasilitas'           => 'required|string',
            'kuota_peserta'       => 'required|integer|min:1',
            // 'durasi_magang'       => 'required|string|max:100',
            'status'              => 'required|in:aktif,nonaktif',
        ], [
            'required' => ':attribute wajib diisi.',
        ]);

        // Simpan lowongan
        Lowongan::create([
            'industri_id'         => $industri->id,
            'judul_lowongan'      => $request->judul_lowongan,
            'posisi_magang'       => $request->posisi_magang,
            'divisi'              => $request->divisi,
            'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan,
            'requirements'        => $request->requirements,
            'fasilitas'           => $request->fasilitas,
            'kuota_peserta'       => $request->kuota_peserta,
            // 'durasi_magang'       => $request->durasi_magang,

            // Mapping status
            'status' => $request->status === 'aktif'
                ? 'dibuka'
                : 'ditutup',
        ]);

        return redirect()
            ->route('industri.lowongan.index')
            ->with('success', 'Lowongan magang berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lowongan = Lowongan::with('industri')->findOrFail($id);

        if (!$this->canManageLowongan($lowongan)) {
            abort(403, 'Anda tidak memiliki akses ke lowongan ini.');
        }

        return view('industri.lowongan.show', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        if (!$this->canManageLowongan($lowongan)) {
            abort(403, 'Anda tidak memiliki akses ke lowongan ini.');
        }

        $teams = Team::orderBy('name')->get();

        return view('industri.lowongan.edit', compact('lowongan', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        if (!$this->canManageLowongan($lowongan)) {
            abort(403, 'Anda tidak memiliki akses ke lowongan ini.');
        }

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

        $lowongan->update([
            'judul_lowongan'      => $request->judul_lowongan,
            'posisi_magang'       => $request->posisi_magang,
            'divisi'              => $request->divisi,
            'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan,
            'requirements'        => $request->requirements,
            'fasilitas'           => $request->fasilitas,
            'kuota_peserta'       => $request->kuota_peserta,
            'status'              => $request->status === 'aktif' ? 'dibuka' : 'ditutup',
        ]);

        return redirect()
            ->route('industri.lowongan.show', $lowongan->id)
            ->with('success', 'Lowongan magang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        if (!$this->canManageLowongan($lowongan)) {
            abort(403, 'Anda tidak memiliki akses ke lowongan ini.');
        }

        $lowongan->delete();

        return redirect()
            ->route('industri.lowongan.index')
            ->with('success', 'Lowongan magang berhasil dihapus.');
    }

    /**
     * Cek apakah profil industri lengkap
     */
    private function canManageLowongan(Lowongan $lowongan): bool
    {
        $industri = auth()->user()?->industri;

        return $industri && $lowongan->industri_id === $industri->id;
    }

    private function profilLengkap($industri): bool
    {
        if (!$industri) {
            return false;
        }

        $fields = [
            'nama_industri',
            'bidang_industri',
            'logo_industri',
            'deskripsi_industri',
            'alamat_industri',
            'kota_kabupaten',
            'email_industri',
            'nomor_telepon_industri',
            'nib',
        ];

        foreach ($fields as $field) {
            if (empty($industri->$field)) {
                return false;
            }
        }

        return true;
    }
}