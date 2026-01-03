<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PerformanceReview;
use Illuminate\Http\Request;

class PerformanceReviewController extends Controller
{
    public function index()
    {
        $reviews = PerformanceReview::with('employee')->latest()->get();

        return view('dashboard.performance-reviews.index', compact('reviews'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('dashboard.performance-reviews.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'review_date' => 'required|date',
            'review_period' => 'required|string|max:255',
            'kpis' => 'nullable|string',
            'overall_rating' => 'required|integer|min:1|max:10',
            'manager_notes' => 'nullable|string',
            'employee_feedback' => 'nullable|string',
        ]);

        if ($validated['kpis']) {
            $validated['kpis'] = json_decode($validated['kpis'], true);
        }

        PerformanceReview::create($validated);

        return redirect()->route('performance-reviews.index')->with('success', 'تم إضافة التقييم بنجاح!');
    }

    public function edit(PerformanceReview $performanceReview)
    {
        $employees = Employee::all();

        return view('dashboard.performance-reviews.edit', compact('performanceReview', 'employees'));
    }

    public function update(Request $request, PerformanceReview $performanceReview)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'review_date' => 'required|date',
            'review_period' => 'required|string|max:255',
            'kpis' => 'nullable|string',
            'overall_rating' => 'required|integer|min:1|max:10',
            'manager_notes' => 'nullable|string',
            'employee_feedback' => 'nullable|string',
        ]);

        if ($validated['kpis']) {
            $validated['kpis'] = json_decode($validated['kpis'], true);
        }

        $performanceReview->update($validated);

        return redirect()->route('performance-reviews.index')->with('success', 'تم تحديث التقييم بنجاح!');
    }

    public function destroy(PerformanceReview $performanceReview)
    {
        $performanceReview->delete();

        return redirect()->route('performance-reviews.index')->with('success', 'تم حذف التقييم بنجاح!');
    }
}
