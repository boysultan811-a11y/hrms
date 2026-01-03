@extends('dashboard.layout')

@section('title', 'HRMS | تعديل تقييم')

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
    <h2 style="margin: 0 0 10px 0;">تعديل تقييم</h2>
    <p style="color: #6b7280; margin: 0;">قم بتعديل بيانات التقييم</p>
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

<form action="{{ route('performance-reviews.update', $performanceReview->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label>اسم الموظف <span style="color: red;">*</span></label>
        <select name="employee_id" required>
            <option value="">اختر الموظف</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ old('employee_id', $performanceReview->employee_id) == $employee->id ? 'selected' : '' }}>
                    {{ $employee->name }}
                </option>
            @endforeach
        </select>
        @error('employee_id')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>تاريخ التقييم <span style="color: red;">*</span></label>
        <input type="date" name="review_date" value="{{ old('review_date', $performanceReview->review_date->format('Y-m-d')) }}" required>
        @error('review_date')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الفترة <span style="color: red;">*</span></label>
        <input type="text" name="review_period" value="{{ old('review_period', $performanceReview->review_period) }}" required placeholder="مثال: الربع الأول 2024">
        @error('review_period')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>مؤشرات الأداء الرئيسية (KPIs)</label>
        <textarea name="kpis" placeholder="أدخل مؤشرات الأداء (JSON format)">{{ old('kpis', $performanceReview->kpis ? json_encode($performanceReview->kpis, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : '') }}</textarea>
        @error('kpis')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
        <small style="color: #6b7280; display: block; margin-top: 5px;">مثال: {"المؤشر 1": "القيمة", "المؤشر 2": "القيمة"}</small>
    </div>

    <div class="form-group">
        <label>التقييم العام <span style="color: red;">*</span></label>
        <input type="number" name="overall_rating" value="{{ old('overall_rating', $performanceReview->overall_rating) }}" required min="1" max="10" placeholder="من 1 إلى 10">
        @error('overall_rating')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>ملاحظات المدير</label>
        <textarea name="manager_notes" placeholder="أدخل ملاحظات المدير">{{ old('manager_notes', $performanceReview->manager_notes) }}</textarea>
        @error('manager_notes')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>ملاحظات الموظف</label>
        <textarea name="employee_feedback" placeholder="أدخل ملاحظات الموظف">{{ old('employee_feedback', $performanceReview->employee_feedback) }}</textarea>
        @error('employee_feedback')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> تحديث البيانات</button>
        <a href="{{ route('performance-reviews.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection

