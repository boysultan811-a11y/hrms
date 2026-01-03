@extends('dashboard.layout')

@section('title', 'HRMS | تعديل دورة')

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
    <h2 style="margin: 0 0 10px 0;">تعديل دورة</h2>
    <p style="color: #6b7280; margin: 0;">قم بتعديل بيانات الدورة: {{ $training->title }}</p>
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

<form action="{{ route('trainings.update', $training->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label>عنوان الدورة <span style="color: red;">*</span></label>
        <input type="text" name="title" value="{{ old('title', $training->title) }}" required placeholder="أدخل عنوان الدورة">
        @error('title')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الوصف <span style="color: red;">*</span></label>
        <textarea name="description" required placeholder="أدخل وصف الدورة">{{ old('description', $training->description) }}</textarea>
        @error('description')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ البدء <span style="color: red;">*</span></label>
        <input type="date" name="start_date" value="{{ old('start_date', $training->start_date->format('Y-m-d')) }}" required>
        @error('start_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ الانتهاء</label>
        <input type="date" name="end_date" value="{{ old('end_date', $training->end_date ? $training->end_date->format('Y-m-d') : '') }}">
        @error('end_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>المدرب</label>
        <input type="text" name="instructor" value="{{ old('instructor', $training->instructor) }}" placeholder="أدخل اسم المدرب">
        @error('instructor')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الحالة <span style="color: red;">*</span></label>
        <select name="status" required>
            <option value="">اختر الحالة</option>
            <option value="scheduled" {{ old('status', $training->status) == 'scheduled' ? 'selected' : '' }}>مجدولة</option>
            <option value="in_progress" {{ old('status', $training->status) == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
            <option value="completed" {{ old('status', $training->status) == 'completed' ? 'selected' : '' }}>مكتملة</option>
            <option value="cancelled" {{ old('status', $training->status) == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
        </select>
        @error('status')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>المشاركون</label>
        <textarea name="participants" placeholder="أدخل قائمة المشاركون (JSON format)">{{ old('participants', $training->participants ? json_encode($training->participants, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : '') }}</textarea>
        @error('participants')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
        <small style="color: #6b7280; display: block; margin-top: 5px;">مثال: ["اسم 1", "اسم 2", "اسم 3"]</small>
    </div>

    <div class="form-group">
        <label>المهارات المغطاة</label>
        <textarea name="skills_covered" placeholder="أدخل المهارات المغطاة في الدورة">{{ old('skills_covered', $training->skills_covered) }}</textarea>
        @error('skills_covered')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit">💾 تحديث البيانات</button>
        <a href="{{ route('trainings.index') }}" class="btn btn-back">↩️ رجوع</a>
    </div>
</form>
@endsection

