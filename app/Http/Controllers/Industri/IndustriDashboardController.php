<?php

namespace App\Http\Controllers\Industri;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use App\Models\PengajuanDetail;

class IndustriDashboardController extends Controller
{
    public function index()
    {
        $industri = Industri::where('user_id', auth()->id())->first();

        $totalLowongan = 0;
        $totalLowonganVerifikasi = 0;
        $progress = 0;
        $totalPelamar = 0;
        $totalPengajuan = 0;

        if ($industri) {

            // Statistik lowongan
            $totalLowongan = $industri->lowongans()->count();

            $totalLowonganVerifikasi = $industri->lowongans()
                ->where('status_verifikasi', 'disetujui')
                ->count();

            $totalPelamar = PengajuanDetail::whereHas('pengajuan.lowongan', function ($query) use ($industri) {
                $query->where('industri_id', $industri->id);
            })->count();

            $totalPengajuan = $industri->lowongans()
                ->with('pengajuans')
                ->get()
                ->pluck('pengajuans')
                ->flatten()
                ->count();

            // Progress kelengkapan profil
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

            $filledFields = 0;

            foreach ($fields as $field) {
                if (!empty($industri->$field)) {
                    $filledFields++;
                }
            }

            $totalFields = count($fields);

            $progress = $totalFields > 0
                ? round(($filledFields / $totalFields) * 100)
                : 0;
        }

        return view('industri.dashboard', compact(
            'industri',
            'totalLowongan',
            'totalLowonganVerifikasi',
            'progress',
            'totalPelamar',
            'totalPengajuan'
        ));
    }
}