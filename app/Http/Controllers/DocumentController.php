<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Employee;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('employee')->latest()->get();

        return view('dashboard.documents.index', compact('documents'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('dashboard.documents.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'file_path' => 'required|string|max:255',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'description' => 'nullable|string',
        ]);

        Document::create($validated);

        return redirect()->route('documents.index')->with('success', 'تم إضافة الوثيقة بنجاح!');
    }

    public function edit(Document $document)
    {
        $employees = Employee::all();

        return view('dashboard.documents.edit', compact('document', 'employees'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'file_path' => 'required|string|max:255',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'description' => 'nullable|string',
        ]);

        $document->update($validated);

        return redirect()->route('documents.index')->with('success', 'تم تحديث الوثيقة بنجاح!');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'تم حذف الوثيقة بنجاح!');
    }
}
