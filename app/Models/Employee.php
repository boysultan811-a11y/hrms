<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'serial_number',
        'national_id',
        'address',
        'gender',
        'marital_status',
        'qualification',
        'job_address',
        'salary',
        'leave_category',
        'work_schedule',
    ];
}
