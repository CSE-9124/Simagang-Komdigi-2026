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
        return view('institusi.pengajuan.index', compact('pengajuans'));
    }
    
    public function create()
    {
        return view('institusi.pengajuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'surat' => 'required|file|mimes:pdf',
            'nama.*' => 'required|string',
        ]);

        // upload surat
        $path = $request->file('surat')->store('surat', 'public');

        // simpan pengajuan
        $pengajuan = Pengajuan::create([
            'institusi_id' => Auth::user()->institusi->id,
            'surat_path' => $path,
        ]);

        // simpan banyak anak
        foreach ($request->nama as $index => $nama) {
            PengajuanDetail::create([
                'pengajuan_id' => $pengajuan->id,
                'nama' => $nama,
                'jurusan' => $request->jurusan[$index] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim');
    }
}
