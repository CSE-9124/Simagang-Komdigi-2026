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

    public function generateSuratBalasan(Pengajuan $pengajuan)
    {
        $pengajuan->load('details');

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->SetAutoPageBreak(true, 10);

        // Load template
        $templatePath = storage_path('app/public/balasan_surat/template_balasanSurat.pdf');
        $pdf->setSourceFile($templatePath);

        $pdf->AddPage();
        $tpl = $pdf->importPage(1);
        $pdf->useTemplate($tpl, 0, 0, 210);

        $pdf->SetFont('Times', '', 12);

        // Nomor surat
        $pdf->SetXY(43.8, 80.6);
        $pdf->Write(0, $pengajuan->nomor_surat_balasan ?? '-');

        //Tanggal
        $pdf->SetXY(146, 80.6); 
        $pdf->Write(0, "Makassar, " . $pengajuan->updated_at->translatedFormat('d F Y'));

        // Tujuan surat
        $pdf->SetXY(18, 108.3); 
        $pdf->Write(0, $pengajuan->tujuan_surat);

        // Institusi
        $pdf->SetXY(18, 114); 
        if ($pengajuan->institusi->jenis_institusi === 'sekolah') {
            $pdf->Write(0, $pengajuan->institusi->nama_institusi );
        } else {
            $pdf->Write(0, "Fakultas ". $pengajuan->institusi->fakultas . " " . $pengajuan->institusi->nama_institusi);
        }

        // nomor surat pengajuan
        $pdf->SetXY(128.5, 130.7); 
        $pdf->Write(0, $pengajuan->no_surat);

        // tanggal pengajuan
        $tanggal = $pengajuan->created_at;
        $pdf->SetXY(32.8, 136.2); 
        $pdf->Write(0, 
            $tanggal->translatedFormat('d') . ' ' . 
            bulanSingkat($tanggal) . ' ' . 
            $tanggal->translatedFormat('Y')
        );

        // ttd
        $pdf->Image(
            storage_path('app/public/images/ttd_balasan_surat.jpg'),
            137.7,
            242.4,
            20,
            20
        );
            
        // halaman 2
        $pdf->AddPage();
        $tpl2 = $pdf->importPage(2);
        $pdf->useTemplate($tpl2, 0, 0, 210);

        // TABEL
        $pdf->SetFont('Times', '', 12);

        // posisi awal tabel
        $startY = 35;
        $pdf->SetXY(22, $startY);

        // lebar kolom 
        $wNo = 12;
        $wNama = 86;
        $wJurusan = 65;

        // ================= HEADER =================
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetX(22); 
        $pdf->Cell($wNo, 8, 'No', 1, 0, 'C');
        $pdf->Cell($wNama, 8, 'Nama', 1, 0, 'C');
        $pdf->Cell($wJurusan, 8, 'Jurusan', 1, 1, 'C');

        // ================= ISI =================
        $pdf->SetFont('Times', '', 12);

        $no = 1;
        foreach ($pengajuan->details as $detail) {

            $pdf->SetX(22); 

            $pdf->Cell($wNo, 7, $no++, 1, 0, 'C');
            $pdf->Cell($wNama, 7, ' ' . $detail->nama, 1);
            $pdf->Cell($wJurusan, 7, ' ' . $detail->jurusan ?? '-', 1);
            
            $pdf->Ln();
        }
        
        return response($pdf->Output('surat_balasan.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
}
