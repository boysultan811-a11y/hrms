@extends('dashboard.layout')

@section('title', 'HRMS | تعديل إجراء تأديبي')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">تعديل إجراء تأديبي</h2>
    <a href="{{ route('disciplinary-actions.index') }}" class="btn btn-back"> رجوع</a>
</div>

<form action="{{ route('disciplinary-actions.update', $disciplinaryAction->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="employee_id">الموظف <span style="color: #ef4444;">*</span></label>
        <select id="employee_id" name="employee_id" required>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ $disciplinaryAction->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
            @endforeach
        </select>
        @error('employee_id')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="violation_type">نوع المخالفة <span style="color: #ef4444;">*</span></label>
        <input type="text" id="violation_type" name="violation_type" value="{{ old('violation_type', $disciplinaryAction->violation_type) }}" required placeholder="مثال: تأخير، غياب غير مبرر، إلخ">
        @error('violation_type')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">وصف المخالفة <span style="color: #ef4444;">*</span></label>
        <textarea id="description" name="description" rows="4" required placeholder="وصف تفصيلي للمخالفة">{{ old('description', $disciplinaryAction->description) }}</textarea>
        @error('description')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="action_date">تاريخ الإجراء <span style="color: #ef4444;">*</span></label>
        <input type="date" id="action_date" name="action_date" value="{{ old('action_date', $disciplinaryAction->action_date->format('Y-m-d')) }}" required>
        @error('action_date')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="severity">مستوى الخطورة <span style="color: #ef4444;">*</span></label>
        <select id="severity" name="severity" required>
            <option value="low" {{ old('severity', $disciplinaryAction->severity) == 'low' ? 'selected' : '' }}>منخفضة</option>
            <option value="medium" {{ old('severity', $disciplinaryAction->severity) == 'medium' ? 'selected' : '' }}>متوسطة</option>
            <option value="high" {{ old('severity', $disciplinaryAction->severity) == 'high' ? 'selected' : '' }}>عالية</option>
        </select>
        @error('severity')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="notes">ملاحظات إضافية</label>
        <textarea id="notes" name="notes" rows="3" placeholder="أي ملاحظات إضافية">{{ old('notes', $disciplinaryAction->notes) }}</textarea>
        @error('notes')
            <span style="color: #ef4444; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> حفظ التعديلات</button>
        <a href="{{ route('disciplinary-actions.index') }}" class="btn btn-back">إلغاء</a>
    </div>
</form>
@endsection

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

