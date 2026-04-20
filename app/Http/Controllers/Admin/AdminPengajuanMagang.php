<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use Illuminate\Support\Facades\Auth;

class AdminPengajuanMagang extends Controller
{
    public function index()
    {   
        $pengajuanTabel = Pengajuan::with('institusi')->get();

        $totalPengajuan = $pengajuanTabel->count();
        $totalDiterima = $pengajuanTabel->where('status', 'approved')->count();
        $totalDitolak = $pengajuanTabel->where('status', 'rejected')->count();
        $totalMenunggu = $pengajuanTabel->where('status', 'pending')->count();

        return view('admin.pengajuan.index', compact(
            'pengajuanTabel',
            'totalPengajuan',
            'totalDiterima',
            'totalDitolak',
            'totalMenunggu'
        ));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with('details', 'institusi')
            ->findOrFail($id);

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        // 🔥 Cek status dulu
        if ($pengajuan->status !== 'rejected') {
            return redirect()
                ->back()
                ->with('error', 'Pengajuan hanya bisa dihapus jika statusnya rejected.');
        }

        // Hapus relasi detail dulu
        $pengajuan->details()->delete();

        // Hapus pengajuan
        $pengajuan->delete();

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected,pending'],
        ]);

        $pengajuan->update([
            'status' => $validated['status']
        ]);

        $message = match($validated['status']) {
            'approved' => 'Laporan telah disetujui.',
            'rejected' => 'Status laporan ditolak.',
            'pending' => 'Status dikembalikan ke pending.',
            default => 'Status berhasil diperbarui.',
        };

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', $message);
    }
}
