<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'instructor',
        'status',
        'participants',
        'skills_covered',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'participants' => 'array',
    ];
}
