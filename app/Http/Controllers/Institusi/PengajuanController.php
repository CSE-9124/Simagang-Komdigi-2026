<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::where('institusi_id', Auth::user()->institusi->id)->get()->sortByDesc('created_at');
        $totalPengajuan = $pengajuans->count();
        $pengajuanPending = $pengajuans->where('status', 'pending')->count();
        $pengajuanApproved = $pengajuans->where('status', 'approved')->count();
        $pengajuanRejected = $pengajuans->where('status', 'rejected')->count();
        $pengajuanRevised = $pengajuans->where('status', 'revised')->count();

        return view('institusi.pengajuan.index', compact('pengajuans', 'totalPengajuan', 'pengajuanPending', 'pengajuanApproved', 'pengajuanRejected', 'pengajuanRevised'));
    }
    
    public function create()
    {
        return view('institusi.pengajuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'surat_magang' => 'required|file|mimes:pdf,doc,docx',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'keperluan' => 'required|string',
            'no_surat' => ['required', 'string', Rule::unique('pengajuans', 'no_surat')->where('institusi_id', Auth::user()->institusi->id)],
            'tujuan_surat' => 'required|string',

            // validasi array peserta
            'name.*' => 'required|string',
            'email.*' => 'required|email',
            'jurusan.*' => 'required|string',
            'jenis_kelamin.*' => 'required|in:L,P',
            'no_telp.*' => 'required|string',
        ], [
            'no_surat.unique' => 'Nomor surat ini sudah pernah digunakan oleh institusi Anda. Silakan gunakan nomor surat yang berbeda.',
        ]);

        // upload file
        $path = $request->file('surat_magang')->store('surat_magang', 'public');

        // simpan pengajuan utama
        $pengajuan = Pengajuan::create([
            'institusi_id' => Auth::user()->institusi->id,
            'surat_path' => $path,
            'status' => 'pending',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'keperluan' => $request->keperluan,
            'no_surat' => $request->no_surat,
            'tujuan_surat' => $request->tujuan_surat,
        ]);

        // simpan banyak peserta
        foreach ($request->name as $i => $nama) {
            PengajuanDetail::create([
                'pengajuan_id' => $pengajuan->id,
                'nama' => $nama,
                'email' => $request->email[$i],
                'jurusan' => $request->jurusan[$i],
                'jenis_kelamin' => $request->jenis_kelamin[$i],
                'no_telp' => $request->no_telp[$i],
            ]);
        }

        return redirect()
            ->route('institusi.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dikirim');
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with('details')
            ->where('institusi_id', Auth::user()->institusi->id)
            ->findOrFail($id);

        return view('institusi.pengajuan.show', compact('pengajuan'));
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::where('institusi_id', Auth::user()->institusi->id)->findOrFail($id);

        // 🔥 Cek status dulu
        if ($pengajuan->status !== 'rejected' && $pengajuan->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Pengajuan hanya bisa dihapus jika statusnya rejected atau pending.');
        }

        // Hapus relasi detail dulu
        $pengajuan->details()->delete();

        // Hapus pengajuan
        $pengajuan->delete();

        return redirect()
            ->route('institusi.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
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

        /**
         * =========================
         * ISI DATA DINAMIS
         * =========================
         */

        // Nomor surat
        $pdf->SetXY(40, 30); // sesuaikan posisi
        // $pdf->Write(0, $pengajuan->nomor);

        //Tanggal
        $pdf->SetXY(150, 30); // sesuaikan posisi
        $pdf->Write(0, now()->translatedFormat('d F Y'));

        /**
         * =========================
         * LIST NAMA (PENTING 🔥)
         * =========================
         */

        $startY = 95; // sesuaikan dengan posisi "atas nama :" di template
        $pdf->SetXY(40, $startY);

        $no = 1;

        foreach ($pengajuan->details as $detail) {
            $pdf->MultiCell(
                120, // lebar area teks
                6,   // tinggi baris
                $no++ . ". " . $detail->nama . " - " . $detail->jurusan,
                0,
                'L'
            );
        }

        /**
         * =========================
         * OUTPUT PDF
         * =========================
         */
        return response($pdf->Output('surat_balasan.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
}