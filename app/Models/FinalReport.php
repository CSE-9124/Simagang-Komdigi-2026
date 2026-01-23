<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id',
        'file_path',
        'project_file',
        'project_link',
        'file_name',
        'status',
        'grade',
        'score',
        'needs_revision',
        'admin_note',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'needs_revision' => 'boolean',
    ];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}