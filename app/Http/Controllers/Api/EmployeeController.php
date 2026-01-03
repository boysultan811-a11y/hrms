<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view employees')->only('index');
        $this->middleware('permission:create employees')->only('store');
        $this->middleware('permission:edit employees')->only('update');
        $this->middleware('permission:delete employees')->only('destroy');
    }

    public function index()
    {
        return Employee::with('user')->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'job_title' => 'required',
            'department' => 'required',
            'salary' => 'required',
            'hire_date' => 'required|date',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('Employee');

        return Employee::create([
            'user_id' => $user->id,
            'employee_code' => 'EMP-'.rand(1000, 9999),
            'job_title' => $data['job_title'],
            'department' => $data['department'],
            'salary' => $data['salary'],
            'hire_date' => $data['hire_date'],
        ]);
    }
}
