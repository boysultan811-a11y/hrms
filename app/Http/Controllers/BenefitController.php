<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Employee;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function index()
    {
        $benefits = Benefit::with('employee')->latest()->get();

        return view('dashboard.benefits.index', compact('benefits'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('dashboard.benefits.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Benefit::create($validated);

        return redirect()->route('benefits.index')->with('success', 'تم إضافة الميزة بنجاح!');
    }

    public function edit(Benefit $benefit)
    {
        $employees = Employee::all();

        return view('dashboard.benefits.edit', compact('benefit', 'employees'));
    }

    public function update(Request $request, Benefit $benefit)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $benefit->update($validated);

        return redirect()->route('benefits.index')->with('success', 'تم تحديث الميزة بنجاح!');
    }

    public function destroy(Benefit $benefit)
    {
        $benefit->delete();

        return redirect()->route('benefits.index')->with('success', 'تم حذف الميزة بنجاح!');
    }
}
