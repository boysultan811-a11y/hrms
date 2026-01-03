<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinaryAction extends Model
{
    protected $fillable = [
        'employee_id',
        'violation_type',
        'description',
        'action_date',
        'severity',
        'notes',
    ];

    protected $casts = [
        'action_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
