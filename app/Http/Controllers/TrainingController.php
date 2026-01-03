<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::latest()->get();

        return view('dashboard.trainings.index', compact('trainings'));
    }

    public function create()
    {
        return view('dashboard.trainings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'instructor' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'participants' => 'nullable|string',
            'skills_covered' => 'nullable|string',
        ]);

        if ($validated['participants']) {
            $validated['participants'] = json_decode($validated['participants'], true);
        }

        Training::create($validated);

        return redirect()->route('trainings.index')->with('success', 'تم إضافة الدورة بنجاح!');
    }

    public function edit(Training $training)
    {
        return view('dashboard.trainings.edit', compact('training'));
    }

    public function update(Request $request, Training $training)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'instructor' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'participants' => 'nullable|string',
            'skills_covered' => 'nullable|string',
        ]);

        if ($validated['participants']) {
            $validated['participants'] = json_decode($validated['participants'], true);
        }

        $training->update($validated);

        return redirect()->route('trainings.index')->with('success', 'تم تحديث الدورة بنجاح!');
    }

    public function destroy(Training $training)
    {
        $training->delete();

        return redirect()->route('trainings.index')->with('success', 'تم حذف الدورة بنجاح!');
    }
}
