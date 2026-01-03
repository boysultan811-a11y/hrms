<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'request_type',
        'description',
        'status',
        'response',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
