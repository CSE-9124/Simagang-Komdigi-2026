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
    ];

    public function details()
    {
        return $this->hasMany(PengajuanDetail::class);
    }

    public function institusi()
    {
        return $this->belongsTo(Institusi::class);
    }
}
