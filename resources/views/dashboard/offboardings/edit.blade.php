@extends('dashboard.layout')

@section('title', 'HRMS | تعديل إنهاء خدمة')

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
    <h2 style="margin: 0 0 10px 0;">تعديل إنهاء خدمة</h2>
    <p style="color: #6b7280; margin: 0;">قم بتعديل بيانات إنهاء الخدمة</p>
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

<form action="{{ route('offboardings.update', $offboarding->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label>اسم الموظف <span style="color: red;">*</span></label>
        <select name="employee_id" required>
            <option value="">اختر الموظف</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ old('employee_id', $offboarding->employee_id) == $employee->id ? 'selected' : '' }}>
                    {{ $employee->name }}
                </option>
            @endforeach
        </select>
        @error('employee_id')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>النوع <span style="color: red;">*</span></label>
        <select name="type" required>
            <option value="">اختر النوع</option>
            <option value="resignation" {{ old('type', $offboarding->type) == 'resignation' ? 'selected' : '' }}>استقالة</option>
            <option value="termination" {{ old('type', $offboarding->type) == 'termination' ? 'selected' : '' }}>إنهاء</option>
            <option value="retirement" {{ old('type', $offboarding->type) == 'retirement' ? 'selected' : '' }}>تقاعد</option>
        </select>
        @error('type')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ الاستقالة/الإنهاء <span style="color: red;">*</span></label>
        <input type="date" name="resignation_date" value="{{ old('resignation_date', $offboarding->resignation_date->format('Y-m-d')) }}" required>
        @error('resignation_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>آخر يوم عمل <span style="color: red;">*</span></label>
        <input type="date" name="last_work_day" value="{{ old('last_work_day', $offboarding->last_work_day->format('Y-m-d')) }}" required>
        @error('last_work_day')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>السبب <span style="color: red;">*</span></label>
        <textarea name="reason" required placeholder="أدخل سبب إنهاء الخدمة">{{ old('reason', $offboarding->reason) }}</textarea>
        @error('reason')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>التسوية النهائية</label>
        <input type="number" name="final_settlement" value="{{ old('final_settlement', $offboarding->final_settlement) }}" min="0" step="0.01" placeholder="أدخل مبلغ التسوية النهائية">
        @error('final_settlement')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الحالة <span style="color: red;">*</span></label>
        <select name="status" required>
            <option value="">اختر الحالة</option>
            <option value="pending" {{ old('status', $offboarding->status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
            <option value="processing" {{ old('status', $offboarding->status) == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
            <option value="completed" {{ old('status', $offboarding->status) == 'completed' ? 'selected' : '' }}>مكتمل</option>
        </select>
        @error('status')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>ملاحظات</label>
        <textarea name="notes" placeholder="أدخل أي ملاحظات إضافية">{{ old('notes', $offboarding->notes) }}</textarea>
        @error('notes')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> تحديث البيانات</button>
        <a href="{{ route('offboardings.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection

