@extends('dashboard.layout')

@section('title', 'HRMS | إنشاء تقرير')

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
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إنشاء تقرير جديد</h2>
    <a href="{{ route('reports.index') }}" class="btn btn-back">← رجوع</a>
</div>

@if($errors->any())
    <div class="alert" style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 15px;">
        <ul style="margin: 0; padding-right: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('reports.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="title">عنوان التقرير <span style="color: #ef4444;">*</span></label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
    </div>

    <div class="form-group">
        <label for="type">نوع التقرير <span style="color: #ef4444;">*</span></label>
        <select id="type" name="type" required>
            <option value="">اختر نوع التقرير</option>
            <option value="employees" {{ old('type') == 'employees' ? 'selected' : '' }}>تقارير الموظفين</option>
            <option value="attendance" {{ old('type') == 'attendance' ? 'selected' : '' }}>تقارير الحضور</option>
            <option value="payroll" {{ old('type') == 'payroll' ? 'selected' : '' }}>تقارير الرواتب</option>
            <option value="performance" {{ old('type') == 'performance' ? 'selected' : '' }}>تقارير الأداء</option>
            <option value="leaves" {{ old('type') == 'leaves' ? 'selected' : '' }}>تقارير الإجازات</option>
            <option value="benefits" {{ old('type') == 'benefits' ? 'selected' : '' }}>تقارير المزايا</option>
        </select>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="form-group">
            <label for="start_date">تاريخ البداية</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}">
        </div>

        <div class="form-group">
            <label for="end_date">تاريخ النهاية</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}">
        </div>
    </div>

    <div class="form-group">
        <label for="description">الوصف</label>
        <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-add"> حفظ</button>
        <a href="{{ route('reports.index') }}" class="btn btn-back">إلغاء</a>
    </div>
</form>
@endsection

