<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
    protected $fillable = [
        'employee_id',
        'start_date',
        'tasks',
        'documents',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
