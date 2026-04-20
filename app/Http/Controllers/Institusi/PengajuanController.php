<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::where('institusi_id', Auth::user()->institusi->id)->get();
        $totalPengajuan = $pengajuans->count();
        $pengajuanPending = $pengajuans->where('status', 'pending')->count();
        $pengajuanApproved = $pengajuans->where('status', 'approved')->count();
        $pengajuanRejected = $pengajuans->where('status', 'rejected')->count();

        return view('institusi.pengajuan.index', compact('pengajuans', 'totalPengajuan', 'pengajuanPending', 'pengajuanApproved', 'pengajuanRejected'));
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

            // validasi array peserta
            'name.*' => 'required|string',
            'email.*' => 'required|email',
            'jurusan.*' => 'required|string',
            'jenis_kelamin.*' => 'required|in:L,P',
            'no_telp.*' => 'required|string',
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
}