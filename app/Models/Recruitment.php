<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    protected $fillable = [
        'job_title',
        'job_description',
        'department',
        'status',
        'posted_date',
        'closing_date',
        'applicants_count',
    ];

    protected $casts = [
        'posted_date' => 'date',
        'closing_date' => 'date',
    ];
}
