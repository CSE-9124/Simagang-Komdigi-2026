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
        $jumlahPeserta = PengajuanDetail::selectRaw('pengajuan_id, COUNT(*) as total_peserta')
            ->groupBy('pengajuan_id')
            ->pluck('total_peserta', 'pengajuan_id');

        
        foreach ($pengajuanTabel as $pengajuan) {
            $pengajuan->jumlah_peserta = $jumlahPeserta->get($pengajuan->id, 0);
        }
        $totalPengajuan = $pengajuanTabel->count();
        $totalDiterima = $pengajuanTabel->where('status', 'approved')->count();
        $totalDitolak = $pengajuanTabel->where('status', 'rejected')->count();
        $totalMenunggu = $pengajuanTabel->where('status', 'pending')->count();
        $totalRevisi = $pengajuanTabel->where('status', 'revised')->count();

        $baseQuery = Pengajuan::query();
            if (request('search')) {
                $baseQuery->whereHas('institusi', function ($query) {
                    $query->where('no_surat', 'like', '%' . request('search') . '%');
                });
            }
            if (request('status')) {
                $baseQuery->where('status', request('status'));
            }
            
        $pengajuanTabel = $baseQuery->with('institusi')->get();

        return view('admin.pengajuan.index', compact(
            'pengajuanTabel',
            'jumlahPeserta',
            'totalPengajuan',
            'totalDiterima',
            'totalDitolak',
            'totalMenunggu',
            'totalRevisi'
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
        // Prevent any status change if already approved
        if ($pengajuan->status === 'approved') {
            return redirect()
                ->back()
                ->with('error', 'Status sudah disetujui dan tidak dapat diubah.');
        }

        // Check if status is approved from request
        $statusFromRequest = $request->input('status');
        
        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected,pending,revised'],
            'admin_note' => ['nullable', 'string', 'max:2000'],
            'nomor_surat_balasan' => [
                $statusFromRequest === 'approved' ? 'required' : 'nullable',
                'string',
                'max:100'
            ],
        ]);

        // Only keep admin_note when status is revised, otherwise clear it
        $pengajuan->update([
            'status' => $validated['status'],
            'admin_note' => $validated['status'] === 'revised' ? ($validated['admin_note'] ?? null) : null,
            'nomor_surat_balasan' => $validated['nomor_surat_balasan'] ?? null,
        ]);

        $message = match($validated['status']) {
            'approved' => 'Laporan telah disetujui.',
            'rejected' => 'Status laporan ditolak.',
            'revised' => 'Pengajuan ditandai perlu revisi.',
            'pending' => 'Status dikembalikan ke pending.',
            default => 'Status berhasil diperbarui.',
        };

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', $message);
    }
}
