<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceReview extends Model
{
    protected $fillable = [
        'employee_id',
        'review_date',
        'review_period',
        'kpis',
        'overall_rating',
        'manager_notes',
        'employee_feedback',
    ];

    protected $casts = [
        'review_date' => 'date',
        'kpis' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
