<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Offboarding;
use Illuminate\Http\Request;

class OffboardingController extends Controller
{
    public function index()
    {
        $offboardings = Offboarding::with('employee')->latest()->get();

        return view('dashboard.offboardings.index', compact('offboardings'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('dashboard.offboardings.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:resignation,termination,retirement',
            'resignation_date' => 'required|date',
            'last_work_day' => 'required|date',
            'reason' => 'required|string',
            'final_settlement' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,processing,completed',
            'notes' => 'nullable|string',
        ]);

        Offboarding::create($validated);

        return redirect()->route('offboardings.index')->with('success', 'تم إضافة إنهاء الخدمة بنجاح!');
    }

    public function edit(Offboarding $offboarding)
    {
        $employees = Employee::all();

        return view('dashboard.offboardings.edit', compact('offboarding', 'employees'));
    }

    public function update(Request $request, Offboarding $offboarding)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:resignation,termination,retirement',
            'resignation_date' => 'required|date',
            'last_work_day' => 'required|date',
            'reason' => 'required|string',
            'final_settlement' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,processing,completed',
            'notes' => 'nullable|string',
        ]);

        $offboarding->update($validated);

        return redirect()->route('offboardings.index')->with('success', 'تم تحديث إنهاء الخدمة بنجاح!');
    }

    public function destroy(Offboarding $offboarding)
    {
        $offboarding->delete();

        return redirect()->route('offboardings.index')->with('success', 'تم حذف إنهاء الخدمة بنجاح!');
    }
}
