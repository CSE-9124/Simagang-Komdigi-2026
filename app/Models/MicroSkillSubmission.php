<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicroSkillSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id', 'title', 'description', 'photo_path', 'status',
        'reviewer_type', 'reviewer_id', 'review_note', 'submitted_at', 'reviewed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}


