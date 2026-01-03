<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'start_date',
        'end_date',
        'description',
        'data',
        'file_path',
        'created_by',
    ];

    protected $casts = [
        'data' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
