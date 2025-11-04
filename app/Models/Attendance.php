<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id',
        'date',
        'status',
        'check_in',
        'check_out',
        'photo_path',
        'photo_checkout',
        'note',
        'document_path',
        'document_status',
        'admin_note',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}