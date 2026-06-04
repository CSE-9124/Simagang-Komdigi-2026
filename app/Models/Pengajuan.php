<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'institusi_id',
        'surat_path',
        'status',
        'admin_note',
        'nomor_surat_balasan',
        'start_date',
        'end_date',
        'keperluan',
        'no_surat',
        'tujuan_surat',
        'soft_skill',
        'hard_skill',
        'lowongan_id',
    ];

    public function details()
    {
        return $this->hasMany(PengajuanDetail::class);
    }

    public function institusi()
    {
        return $this->belongsTo(Institusi::class);
    }

    public function lowongans()
    {
        return $this->belongsTo(Lowongan::class);
    }
}
