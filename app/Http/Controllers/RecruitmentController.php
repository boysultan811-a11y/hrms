<?php

namespace App\Http\Controllers;

use App\Models\Recruitment;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    public function index()
    {
        $recruitments = Recruitment::latest()->get();

        return view('dashboard.recruitments.index', compact('recruitments'));
    }

    public function create()
    {
        return view('dashboard.recruitments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:open,closed,on_hold',
            'posted_date' => 'required|date',
            'closing_date' => 'nullable|date|after:posted_date',
        ]);

        $validated['applicants_count'] = 0;
        Recruitment::create($validated);

        return redirect()->route('recruitments.index')->with('success', 'تم إضافة الوظيفة بنجاح!');
    }

    public function edit(Recruitment $recruitment)
    {
        return view('dashboard.recruitments.edit', compact('recruitment'));
    }

    public function update(Request $request, Recruitment $recruitment)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:open,closed,on_hold',
            'posted_date' => 'required|date',
            'closing_date' => 'nullable|date|after:posted_date',
        ]);

        $recruitment->update($validated);

        return redirect()->route('recruitments.index')->with('success', 'تم تحديث الوظيفة بنجاح!');
    }

    public function destroy(Recruitment $recruitment)
    {
        $recruitment->delete();

        return redirect()->route('recruitments.index')->with('success', 'تم حذف الوظيفة بنجاح!');
    }
}
