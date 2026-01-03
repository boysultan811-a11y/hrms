@extends('dashboard.layout')

@section('title', 'HRMS | إضافة وثيقة جديدة')

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
    <h2 style="margin: 0 0 10px 0;">إضافة وثيقة جديدة</h2>
    <p style="color: #6b7280; margin: 0;">قم بإدخال بيانات الوثيقة</p>
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

<form action="{{ route('documents.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label>اسم الموظف</label>
        <select name="employee_id">
            <option value="">اختر الموظف (اختياري)</option>
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
        <label>اسم الوثيقة <span style="color: red;">*</span></label>
        <input type="text" name="name" value="{{ old('name') }}" required placeholder="أدخل اسم الوثيقة">
        @error('name')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>نوع الوثيقة <span style="color: red;">*</span></label>
        <select name="type" required>
            <option value="">اختر نوع الوثيقة</option>
            <option value="هوية" {{ old('type') == 'هوية' ? 'selected' : '' }}>هوية</option>
            <option value="شهادة" {{ old('type') == 'شهادة' ? 'selected' : '' }}>شهادة</option>
            <option value="عقد" {{ old('type') == 'عقد' ? 'selected' : '' }}>عقد</option>
            <option value="رخصة" {{ old('type') == 'رخصة' ? 'selected' : '' }}>رخصة</option>
            <option value="شهادة صحية" {{ old('type') == 'شهادة صحية' ? 'selected' : '' }}>شهادة صحية</option>
            <option value="أخرى" {{ old('type') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
        </select>
        @error('type')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>مسار الملف <span style="color: red;">*</span></label>
        <input type="text" name="file_path" value="{{ old('file_path') }}" required placeholder="مثال: /storage/documents/document.pdf">
        @error('file_path')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
        <small style="color: #6b7280; display: block; margin-top: 5px;">أدخل مسار الملف في نظام الملفات</small>
    </div>

    <div class="form-group">
        <label>تاريخ الإصدار</label>
        <input type="date" name="issue_date" value="{{ old('issue_date') }}">
        @error('issue_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ الانتهاء</label>
        <input type="date" name="expiry_date" value="{{ old('expiry_date') }}">
        @error('expiry_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الوصف</label>
        <textarea name="description" placeholder="أدخل وصف الوثيقة (اختياري)">{{ old('description') }}</textarea>
        @error('description')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-add"> حفظ البيانات</button>
        <a href="{{ route('documents.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection

