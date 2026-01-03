<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('employee')->latest()->get();

        return view('dashboard.contracts.index', compact('contracts'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('dashboard.contracts.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'contract_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'salary' => 'required|numeric|min:0',
            'terms' => 'nullable|string',
            'status' => 'required|in:active,expired,terminated',
            'document_path' => 'nullable|string|max:255',
        ]);

        Contract::create($validated);

        return redirect()->route('contracts.index')->with('success', 'تم إضافة العقد بنجاح!');
    }

    public function edit(Contract $contract)
    {
        $employees = Employee::all();

        return view('dashboard.contracts.edit', compact('contract', 'employees'));
    }

    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'contract_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'salary' => 'required|numeric|min:0',
            'terms' => 'nullable|string',
            'status' => 'required|in:active,expired,terminated',
            'document_path' => 'nullable|string|max:255',
        ]);

        $contract->update($validated);

        return redirect()->route('contracts.index')->with('success', 'تم تحديث العقد بنجاح!');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'تم حذف العقد بنجاح!');
    }
}
