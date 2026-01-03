@extends('dashboard.layout')

@section('title', 'HRMS | تعديل إجازة')

@section('styles')
<style>
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #374151;
        font-size: 13px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 7px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #4f46e5;
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn-back {
        background: #6b7280;
    }

    .btn-back:hover {
        background: #4b5563;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 20px;">
    <h2 style="margin: 0 0 10px 0;">تعديل طلب الإجازة</h2>
    <p style="color: #6b7280; margin: 0;">قم بتعديل بيانات إجازة: {{ $leave->employee_name }}</p>
</div>

<form action="{{ route('leaves.update', $leave->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label>اسم الموظف <span style="color: red;">*</span></label>
        <input type="text" name="employee_name" value="{{ old('employee_name', $leave->employee_name) }}" required placeholder="أدخل اسم الموظف">
        @error('employee_name')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>نوع الإجازة <span style="color: red;">*</span></label>
        <select name="leave_type" required>
            <option value="">اختر نوع الإجازة</option>
            <option value="إجازة سنوية" {{ old('leave_type', $leave->leave_type) == 'إجازة سنوية' ? 'selected' : '' }}>إجازة سنوية</option>
            <option value="إجازة مرضية" {{ old('leave_type', $leave->leave_type) == 'إجازة مرضية' ? 'selected' : '' }}>إجازة مرضية</option>
            <option value="إجازة طارئة" {{ old('leave_type', $leave->leave_type) == 'إجازة طارئة' ? 'selected' : '' }}>إجازة طارئة</option>
            <option value="إجازة بدون راتب" {{ old('leave_type', $leave->leave_type) == 'إجازة بدون راتب' ? 'selected' : '' }}>إجازة بدون راتب</option>
        </select>
        @error('leave_type')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ البداية <span style="color: red;">*</span></label>
        <input type="date" name="start_date" value="{{ old('start_date', $leave->start_date) }}" required>
        @error('start_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ النهاية <span style="color: red;">*</span></label>
        <input type="date" name="end_date" value="{{ old('end_date', $leave->end_date) }}" required>
        @error('end_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>سبب الإجازة <span style="color: red;">*</span></label>
        <textarea name="reason" required placeholder="اكتب سبب طلب الإجازة">{{ old('reason', $leave->reason) }}</textarea>
        @error('reason')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> تحديث الطلب</button>
        <a href="{{ route('leaves.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection
