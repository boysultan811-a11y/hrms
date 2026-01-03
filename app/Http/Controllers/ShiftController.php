<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();

        return view('dashboard.shifts.index', compact('shifts'));
    }

    public function create()
    {
        return view('dashboard.shifts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'break_duration' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Shift::create($validated);

        return redirect()->route('shifts.index')->with('success', 'تم إضافة الشفتة بنجاح!');
    }

    public function edit(Shift $shift)
    {
        return view('dashboard.shifts.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'break_duration' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $shift->update($validated);

        return redirect()->route('shifts.index')->with('success', 'تم تحديث الشفتة بنجاح!');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();

        return redirect()->route('shifts.index')->with('success', 'تم حذف الشفتة بنجاح!');
    }
}
