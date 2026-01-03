@extends('dashboard.layout')

@section('title', 'HRMS | تعديل تهيئة')

@section('styles')
<style>
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3b82f6;
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

    .error-list {
        background: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .error-list ul {
        margin: 0;
        padding: 0 0 0 20px;
        color: #991b1b;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 20px;">
    <h2 style="margin: 0 0 10px 0;">تعديل تهيئة</h2>
    <p style="color: #6b7280; margin: 0;">قم بتعديل بيانات التهيئة للموظف: {{ $onboarding->employee->name ?? '-' }}</p>
</div>

@if ($errors->any())
    <div class="error-list">
        <strong> يرجى تصحيح الأخطاء التالية:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('onboardings.update', $onboarding->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label>اسم الموظف <span style="color: red;">*</span></label>
        <select name="employee_id" required>
            <option value="">اختر الموظف</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ old('employee_id', $onboarding->employee_id) == $employee->id ? 'selected' : '' }}>
                    {{ $employee->name }}
                </option>
            @endforeach
        </select>
        @error('employee_id')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ البدء <span style="color: red;">*</span></label>
        <input type="date" name="start_date" value="{{ old('start_date', $onboarding->start_date->format('Y-m-d')) }}" required>
        @error('start_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الحالة <span style="color: red;">*</span></label>
        <select name="status" required>
            <option value="">اختر الحالة</option>
            <option value="pending" {{ old('status', $onboarding->status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
            <option value="in_progress" {{ old('status', $onboarding->status) == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
            <option value="completed" {{ old('status', $onboarding->status) == 'completed' ? 'selected' : '' }}>مكتمل</option>
        </select>
        @error('status')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>المهام المطلوبة</label>
        <textarea name="tasks" placeholder="أدخل المهام المطلوبة (سطر واحد لكل مهمة)">{{ old('tasks', $onboarding->tasks) }}</textarea>
        @error('tasks')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
        <small style="color: #6b7280; display: block; margin-top: 5px;">يمكنك كتابة المهام في سطور متعددة</small>
    </div>

    <div class="form-group">
        <label>الوثائق المطلوبة</label>
        <textarea name="documents" placeholder="أدخل الوثائق المطلوبة (سطر واحد لكل وثيقة)">{{ old('documents', $onboarding->documents) }}</textarea>
        @error('documents')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
        <small style="color: #6b7280; display: block; margin-top: 5px;">يمكنك كتابة الوثائق في سطور متعددة</small>
    </div>

    <div class="form-group">
        <label>ملاحظات</label>
        <textarea name="notes" placeholder="أدخل أي ملاحظات إضافية">{{ old('notes', $onboarding->notes) }}</textarea>
        @error('notes')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> تحديث البيانات</button>
        <a href="{{ route('onboardings.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection

