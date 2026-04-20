<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'final_report_id',
        'intern_id',
        'testimony',
    ];

    public function finalReport()
    {
        return $this->belongsTo(FinalReport::class);
    }

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
