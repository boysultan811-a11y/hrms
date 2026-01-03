<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // عرض الإجازات المعلقة فقط
        $leaves = Leave::where('status', 'pending')->get();

        // حذف جميع الإجازات المعالجة (approved أو rejected) تلقائياً
        Leave::whereIn('status', ['approved', 'rejected'])->delete();

        return view('dashboard.leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.leaves.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_name' => 'required|string|max:255',
            'leave_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        // إضافة status كقيمة افتراضية
        $validated['status'] = 'pending';

        Leave::create($validated);

        return redirect()->route('leaves.index')->with('success', 'تم إضافة الإجازة بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        return view('dashboard.leaves.show', compact('leave'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        return view('dashboard.leaves.edit', compact('leave'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        $validated = $request->validate([
            'employee_name' => 'required|string|max:255',
            'leave_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $leave->update($validated);

        return redirect()->route('leaves.index')->with('success', 'تم تعديل الإجازة بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'تم حذف الإجازة بنجاح!');
    }

    /**
     * Approve a leave request.
     */
    public function approve(Leave $leave)
    {
        // حفظ معلومات الإجازة قبل الحذف (اختياري)
        $employeeName = $leave->employee_name;

        // حذف الإجازة مباشرة بعد الموافقة
        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'تمت الموافقة على إجازة '.$employeeName.' وحذفها تلقائياً!');
    }

    /**
     * Reject a leave request.
     */
    public function reject(Leave $leave)
    {
        // حفظ معلومات الإجازة قبل الحذف (اختياري)
        $employeeName = $leave->employee_name;

        // حذف الإجازة مباشرة بعد الرفض
        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'تم رفض إجازة '.$employeeName.' وحذفها تلقائياً!');
    }
}
