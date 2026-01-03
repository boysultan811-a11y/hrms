<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')->latest()->get();

        return view('dashboard.payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('dashboard.payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'payroll_date' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,paid',
            'notes' => 'nullable|string',
        ]);

        $validated['total_salary'] = $validated['basic_salary'] + ($validated['allowances'] ?? 0) + ($validated['bonus'] ?? 0) - ($validated['deductions'] ?? 0) - ($validated['tax'] ?? 0);

        Payroll::create($validated);

        return redirect()->route('payrolls.index')->with('success', 'تم إضافة كشف الراتب بنجاح!');
    }

    public function edit(Payroll $payroll)
    {
        $employees = Employee::all();

        return view('dashboard.payrolls.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'payroll_date' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,paid',
            'notes' => 'nullable|string',
        ]);

        $validated['total_salary'] = $validated['basic_salary'] + ($validated['allowances'] ?? 0) + ($validated['bonus'] ?? 0) - ($validated['deductions'] ?? 0) - ($validated['tax'] ?? 0);

        $payroll->update($validated);

        return redirect()->route('payrolls.index')->with('success', 'تم تحديث كشف الراتب بنجاح!');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()->route('payrolls.index')->with('success', 'تم حذف كشف الراتب بنجاح!');
    }
}
