<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'logbook_id',
        'comment',
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function logbook()
    {
        return $this->belongsTo(Logbook::class);
    }
}
