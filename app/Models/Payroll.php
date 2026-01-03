<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'payroll_date',
        'basic_salary',
        'allowances',
        'deductions',
        'tax',
        'bonus',
        'total_salary',
        'status',
        'notes',
    ];

    protected $casts = [
        'payroll_date' => 'date',
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'tax' => 'decimal:2',
        'bonus' => 'decimal:2',
        'total_salary' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
