@extends('dashboard.layout')

@section('title', 'HRMS | تعديل وظيفة')

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
    <h2 style="margin: 0 0 10px 0;">تعديل وظيفة</h2>
    <p style="color: #6b7280; margin: 0;">قم بتعديل بيانات الوظيفة: {{ $recruitment->job_title }}</p>
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

<form action="{{ route('recruitments.update', $recruitment->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label>المسمى الوظيفي <span style="color: red;">*</span></label>
        <input type="text" name="job_title" value="{{ old('job_title', $recruitment->job_title) }}" required placeholder="أدخل المسمى الوظيفي">
        @error('job_title')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>وصف الوظيفة <span style="color: red;">*</span></label>
        <textarea name="job_description" required placeholder="أدخل وصف الوظيفة">{{ old('job_description', $recruitment->job_description) }}</textarea>
        @error('job_description')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>القسم</label>
        <input type="text" name="department" value="{{ old('department', $recruitment->department) }}" placeholder="أدخل القسم">
        @error('department')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ النشر <span style="color: red;">*</span></label>
        <input type="date" name="posted_date" value="{{ old('posted_date', $recruitment->posted_date->format('Y-m-d')) }}" required>
        @error('posted_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ الإغلاق</label>
        <input type="date" name="closing_date" value="{{ old('closing_date', $recruitment->closing_date ? $recruitment->closing_date->format('Y-m-d') : '') }}">
        @error('closing_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الحالة <span style="color: red;">*</span></label>
        <select name="status" required>
            <option value="">اختر الحالة</option>
            <option value="open" {{ old('status', $recruitment->status) == 'open' ? 'selected' : '' }}>مفتوحة</option>
            <option value="closed" {{ old('status', $recruitment->status) == 'closed' ? 'selected' : '' }}>مغلقة</option>
            <option value="on_hold" {{ old('status', $recruitment->status) == 'on_hold' ? 'selected' : '' }}>متوقفة</option>
        </select>
        @error('status')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> تحديث البيانات</button>
        <a href="{{ route('recruitments.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection

