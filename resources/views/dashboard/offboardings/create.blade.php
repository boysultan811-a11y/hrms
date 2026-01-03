@extends('dashboard.layout')

@section('title', 'HRMS | إضافة إنهاء خدمة')

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
    <h2 style="margin: 0 0 10px 0;">إضافة إنهاء خدمة</h2>
    <p style="color: #6b7280; margin: 0;">قم بإدخال بيانات إنهاء الخدمة</p>
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

<form action="{{ route('offboardings.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label>اسم الموظف <span style="color: red;">*</span></label>
        <select name="employee_id" required>
            <option value="">اختر الموظف</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
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
            <option value="resignation" {{ old('type') == 'resignation' ? 'selected' : '' }}>استقالة</option>
            <option value="termination" {{ old('type') == 'termination' ? 'selected' : '' }}>إنهاء</option>
            <option value="retirement" {{ old('type') == 'retirement' ? 'selected' : '' }}>تقاعد</option>
        </select>
        @error('type')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ الاستقالة/الإنهاء <span style="color: red;">*</span></label>
        <input type="date" name="resignation_date" value="{{ old('resignation_date') }}" required>
        @error('resignation_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>آخر يوم عمل <span style="color: red;">*</span></label>
        <input type="date" name="last_work_day" value="{{ old('last_work_day') }}" required>
        @error('last_work_day')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>السبب <span style="color: red;">*</span></label>
        <textarea name="reason" required placeholder="أدخل سبب إنهاء الخدمة">{{ old('reason') }}</textarea>
        @error('reason')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>التسوية النهائية</label>
        <input type="number" name="final_settlement" value="{{ old('final_settlement') }}" min="0" step="0.01" placeholder="أدخل مبلغ التسوية النهائية">
        @error('final_settlement')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الحالة <span style="color: red;">*</span></label>
        <select name="status" required>
            <option value="">اختر الحالة</option>
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
            <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
        </select>
        @error('status')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>ملاحظات</label>
        <textarea name="notes" placeholder="أدخل أي ملاحظات إضافية">{{ old('notes') }}</textarea>
        @error('notes')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-add"> حفظ البيانات</button>
        <a href="{{ route('offboardings.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection

