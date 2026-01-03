<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all(); // جلب كل الموظفين
        Log::info('Employees index', ['count' => $employees->count()]);

        return view('dashboard.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('dashboard.employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:50',
            'serial_number' => 'nullable|string|max:255',
            'national_id' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:ذكر,أنثى',
            'marital_status' => 'nullable|in:أعزب,متزوج,مطلق,أرمل',
            'qualification' => 'nullable|string|max:255',
            'job_address' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'leave_category' => 'nullable|string|max:255',
            'work_schedule' => 'nullable|string|max:255',
        ]);

        try {
            $employee = Employee::create($validated);
            Log::info('Employee created successfully', ['employee_id' => $employee->id, 'name' => $employee->name]);

            return redirect()->route('employees.index')->with('success', 'تم إضافة الموظف بنجاح');
        } catch (\Exception $e) {
            Log::error('Error creating employee', ['error' => $e->getMessage(), 'data' => $validated]);

            return back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء إضافة الموظف: '.$e->getMessage()]);
        }
    }

    public function edit(Employee $employee)
    {
        return view('dashboard.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:50',
            'serial_number' => 'nullable|string|max:255',
            'national_id' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:ذكر,أنثى',
            'marital_status' => 'nullable|in:أعزب,متزوج,مطلق,أرمل',
            'qualification' => 'nullable|string|max:255',
            'job_address' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'leave_category' => 'nullable|string|max:255',
            'work_schedule' => 'nullable|string|max:255',
        ]);

        try {
            $employee->update($validated);

            return redirect()->route('employees.index')->with('success', 'تم تعديل بيانات الموظف بنجاح');
        } catch (\Exception $e) {
            Log::error('Error updating employee', ['error' => $e->getMessage(), 'employee_id' => $employee->id]);

            return back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء تعديل الموظف: '.$e->getMessage()]);
        }
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'تم حذف الموظف بنجاح');
    }
}
