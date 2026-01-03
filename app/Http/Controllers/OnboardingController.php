<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Onboarding;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        $onboardings = Onboarding::with('employee')->latest()->get();

        return view('dashboard.onboardings.index', compact('onboardings'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('dashboard.onboardings.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date',
            'tasks' => 'nullable|string',
            'documents' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'notes' => 'nullable|string',
        ]);

        Onboarding::create($validated);

        return redirect()->route('onboardings.index')->with('success', 'تم إضافة التهيئة بنجاح!');
    }

    public function edit(Onboarding $onboarding)
    {
        $employees = Employee::all();

        return view('dashboard.onboardings.edit', compact('onboarding', 'employees'));
    }

    public function update(Request $request, Onboarding $onboarding)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date',
            'tasks' => 'nullable|string',
            'documents' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'notes' => 'nullable|string',
        ]);

        $onboarding->update($validated);

        return redirect()->route('onboardings.index')->with('success', 'تم تحديث التهيئة بنجاح!');
    }

    public function destroy(Onboarding $onboarding)
    {
        $onboarding->delete();

        return redirect()->route('onboardings.index')->with('success', 'تم حذف التهيئة بنجاح!');
    }
}
