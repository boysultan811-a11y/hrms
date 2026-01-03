@extends('dashboard.layout')

@section('title', 'HRMS | إضافة عقد جديد')

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
        margin-bottom: 15px;
    }

    .error-list ul {
        margin: 0;
        padding: 0 0 0 20px;
        color: #991b1b;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 15px;">
    <h2 style="margin: 0 0 10px 0;">إضافة عقد جديد</h2>
    <p style="color: #6b7280; margin: 0;">قم بإدخال بيانات العقد</p>
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

<form action="{{ route('contracts.store') }}" method="POST">
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
        <label>نوع العقد <span style="color: red;">*</span></label>
        <input type="text" name="contract_type" value="{{ old('contract_type') }}" required placeholder="مثال: عقد عمل دائم، عقد عمل مؤقت">
        @error('contract_type')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ البدء <span style="color: red;">*</span></label>
        <input type="date" name="start_date" value="{{ old('start_date') }}" required>
        @error('start_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ الانتهاء</label>
        <input type="date" name="end_date" value="{{ old('end_date') }}">
        @error('end_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الراتب <span style="color: red;">*</span></label>
        <input type="number" name="salary" value="{{ old('salary') }}" required min="0" step="0.01" placeholder="أدخل الراتب">
        @error('salary')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الحالة <span style="color: red;">*</span></label>
        <select name="status" required>
            <option value="">اختر الحالة</option>
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
            <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>منتهي</option>
            <option value="terminated" {{ old('status') == 'terminated' ? 'selected' : '' }}>منهي</option>
        </select>
        @error('status')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الشروط والبنود</label>
        <textarea name="terms" placeholder="أدخل شروط العقد">{{ old('terms') }}</textarea>
        @error('terms')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>مسار الوثيقة</label>
        <input type="text" name="document_path" value="{{ old('document_path') }}" placeholder="مثال: /storage/contracts/contract.pdf">
        @error('document_path')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-add"> حفظ البيانات</button>
        <a href="{{ route('contracts.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection

