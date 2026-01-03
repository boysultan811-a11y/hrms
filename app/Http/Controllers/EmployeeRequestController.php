<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeRequest;
use Illuminate\Http\Request;

class EmployeeRequestController extends Controller
{
    public function index()
    {
        $requests = EmployeeRequest::with('employee')->latest()->get();

        return view('dashboard.employee-requests.index', compact('requests'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('dashboard.employee-requests.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'request_type' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        EmployeeRequest::create($validated);

        return redirect()->route('employee-requests.index')->with('success', 'تم إضافة الطلب بنجاح!');
    }

    public function edit(EmployeeRequest $employeeRequest)
    {
        $employees = Employee::all();

        return view('dashboard.employee-requests.edit', compact('employeeRequest', 'employees'));
    }

    public function update(Request $request, EmployeeRequest $employeeRequest)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'request_type' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
            'response' => 'nullable|string',
        ]);

        $employeeRequest->update($validated);

        return redirect()->route('employee-requests.index')->with('success', 'تم تحديث الطلب بنجاح!');
    }

    public function destroy(EmployeeRequest $employeeRequest)
    {
        $employeeRequest->delete();

        return redirect()->route('employee-requests.index')->with('success', 'تم حذف الطلب بنجاح!');
    }
}
