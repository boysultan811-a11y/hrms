@extends('dashboard.layout')

@section('title', 'HRMS | إضافة إجراء تأديبي')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إضافة إجراء تأديبي جديد</h2>
    <a href="{{ route('disciplinary-actions.index') }}" class="btn btn-back">← رجوع</a>
</div>

<form action="{{ route('disciplinary-actions.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="employee_id">الموظف <span style="color: #ef4444;">*</span></label>
        <select id="employee_id" name="employee_id" required>
            <option value="">اختر الموظف</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
            @endforeach
        </select>
        @error('employee_id')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="violation_type">نوع المخالفة <span style="color: #ef4444;">*</span></label>
        <input type="text" id="violation_type" name="violation_type" value="{{ old('violation_type') }}" required placeholder="مثال: تأخير، غياب غير مبرر، إلخ">
        @error('violation_type')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">وصف المخالفة <span style="color: #ef4444;">*</span></label>
        <textarea id="description" name="description" rows="4" required placeholder="وصف تفصيلي للمخالفة">{{ old('description') }}</textarea>
        @error('description')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="action_date">تاريخ الإجراء <span style="color: #ef4444;">*</span></label>
        <input type="date" id="action_date" name="action_date" value="{{ old('action_date', date('Y-m-d')) }}" required>
        @error('action_date')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="severity">مستوى الخطورة <span style="color: #ef4444;">*</span></label>
        <select id="severity" name="severity" required>
            <option value="">اختر مستوى الخطورة</option>
            <option value="low" {{ old('severity') == 'low' ? 'selected' : '' }}>منخفضة</option>
            <option value="medium" {{ old('severity') == 'medium' ? 'selected' : '' }}>متوسطة</option>
            <option value="high" {{ old('severity') == 'high' ? 'selected' : '' }}>عالية</option>
        </select>
        @error('severity')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="notes">ملاحظات إضافية</label>
        <textarea id="notes" name="notes" rows="3" placeholder="أي ملاحظات إضافية">{{ old('notes') }}</textarea>
        @error('notes')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-add"> حفظ</button>
        <a href="{{ route('disciplinary-actions.index') }}" class="btn btn-back">إلغاء</a>
    </div>
</form>
@endsection

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
    }
    .form-group textarea {
        resize: vertical;
    }
    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }
    .btn-back {
        background: #6b7280;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-back:hover {
        background: #4b5563;
    }
</style>
@endsection

