<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    protected $fillable = [
        'industri_id',
        'judul_lowongan',
        'posisi_magang',
        'divisi',
        'deskripsi_pekerjaan',
        'requirements',
        'fasilitas',
        'kuota_peserta',
        'durasi_magang',
        'status',
        'status_verifikasi',
    ];

    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }

}