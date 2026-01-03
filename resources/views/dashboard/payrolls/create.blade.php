@extends('dashboard.layout')

@section('title', 'HRMS | إضافة كشف راتب')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إضافة كشف راتب جديد</h2>
    <a href="{{ route('payrolls.index') }}" class="btn btn-back"> رجوع</a>
</div>

<form action="{{ route('payrolls.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="employee_id">الموظف <span style="color: #ef4444;">*</span></label>
        <select id="employee_id" name="employee_id" required>
            <option value="">اختر الموظف</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="payroll_date">تاريخ الراتب <span style="color: #ef4444;">*</span></label>
        <input type="date" id="payroll_date" name="payroll_date" value="{{ date('Y-m-d') }}" required>
    </div>

    <div class="form-group">
        <label for="basic_salary">الراتب الأساسي <span style="color: #ef4444;">*</span></label>
        <input type="number" id="basic_salary" name="basic_salary" step="0.01" min="0" required>
    </div>

    <div class="form-group">
        <label for="allowances">البدلات</label>
        <input type="number" id="allowances" name="allowances" step="0.01" min="0" value="0">
    </div>

    <div class="form-group">
        <label for="deductions">الخصومات</label>
        <input type="number" id="deductions" name="deductions" step="0.01" min="0" value="0">
    </div>

    <div class="form-group">
        <label for="tax">الضرائب</label>
        <input type="number" id="tax" name="tax" step="0.01" min="0" value="0">
    </div>

    <div class="form-group">
        <label for="bonus">المكافآت</label>
        <input type="number" id="bonus" name="bonus" step="0.01" min="0" value="0">
    </div>

    <div class="form-group">
        <label for="status">الحالة <span style="color: #ef4444;">*</span></label>
        <select id="status" name="status" required>
            <option value="pending">قيد الانتظار</option>
            <option value="approved">معتمد</option>
            <option value="paid">مدفوع</option>
        </select>
    </div>

    <div class="form-group">
        <label for="notes">ملاحظات</label>
        <textarea id="notes" name="notes" rows="3"></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-add"> حفظ</button>
        <a href="{{ route('payrolls.index') }}" class="btn btn-back">إلغاء</a>
    </div>
</form>
@endsection

@section('styles')
<style>
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 13px; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 7px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; }
    .form-actions { display: flex; gap: 10px; margin-top: 25px; }
    .btn-back { background: #6b7280; }
</style>
@endsection

