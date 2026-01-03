<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Baidouabdellah\LaravelArpdf\Facades\ArPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::latest()->get();

        return view('dashboard.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:employees,attendance,payroll,performance,leaves,benefits',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['data'] = []; // سيتم ملؤها لاحقاً عند إنشاء التقرير الفعلي

        Report::create($validated);

        return redirect()->route('reports.index')->with('success', 'تم إنشاء التقرير بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return view('dashboard.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        return view('dashboard.reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:employees,attendance,payroll,performance,leaves,benefits',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $report->update($validated);

        return redirect()->route('reports.index')->with('success', 'تم تحديث التقرير بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'تم حذف التقرير بنجاح!');
    }

    /**
     * Export report as PDF.
     */
    public function exportPdf(Report $report)
    {
        $types = [
            'employees' => 'تقارير الموظفين',
            'attendance' => 'تقارير الحضور',
            'payroll' => 'تقارير الرواتب',
            'performance' => 'تقارير الأداء',
            'leaves' => 'تقارير الإجازات',
            'benefits' => 'تقارير المزايا',
        ];

        $reportType = $types[$report->type] ?? $report->type;
        $fileName = 'تقرير-'.$report->title.'-'.date('Y-m-d').'.pdf';

        $html = view('dashboard.reports.pdf', [
            'report' => $report,
            'reportType' => $reportType,
        ])->render();

        return ArPDF::loadHTML($html)->download($fileName);
    }
}
