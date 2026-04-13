<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institusi extends Model
{
    use HasFactory;

    protected $table = 'institusi';

    protected $fillable = [
        'user_id',
        'nama_institusi',
        'jenis_institusi',
        'nomor_identitas',
        'no_hp',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 