<?php

namespace App\Http\Controllers;

use App\Models\DisciplinaryAction;
use App\Models\Employee;
use Illuminate\Http\Request;

class DisciplinaryActionController extends Controller
{
    public function index()
    {
        $actions = DisciplinaryAction::with('employee')->latest()->get();

        return view('dashboard.disciplinary-actions.index', compact('actions'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('dashboard.disciplinary-actions.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'violation_type' => 'required|string|max:255',
            'description' => 'required|string',
            'action_date' => 'required|date',
            'severity' => 'required|in:low,medium,high',
            'notes' => 'nullable|string',
        ]);

        DisciplinaryAction::create($validated);

        return redirect()->route('disciplinary-actions.index')->with('success', 'تم إضافة الإجراء التأديبي بنجاح!');
    }

    public function edit(DisciplinaryAction $disciplinaryAction)
    {
        $employees = Employee::all();

        return view('dashboard.disciplinary-actions.edit', compact('disciplinaryAction', 'employees'));
    }

    public function update(Request $request, DisciplinaryAction $disciplinaryAction)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'violation_type' => 'required|string|max:255',
            'description' => 'required|string',
            'action_date' => 'required|date',
            'severity' => 'required|in:low,medium,high',
            'notes' => 'nullable|string',
        ]);

        $disciplinaryAction->update($validated);

        return redirect()->route('disciplinary-actions.index')->with('success', 'تم تحديث الإجراء التأديبي بنجاح!');
    }

    public function destroy(DisciplinaryAction $disciplinaryAction)
    {
        $disciplinaryAction->delete();

        return redirect()->route('disciplinary-actions.index')->with('success', 'تم حذف الإجراء التأديبي بنجاح!');
    }
}
