<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offboarding extends Model
{
    protected $fillable = [
        'employee_id',
        'type',
        'resignation_date',
        'last_work_day',
        'reason',
        'final_settlement',
        'status',
        'notes',
    ];

    protected $casts = [
        'resignation_date' => 'date',
        'last_work_day' => 'date',
        'final_settlement' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
