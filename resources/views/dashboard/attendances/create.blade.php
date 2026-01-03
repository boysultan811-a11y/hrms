@extends('dashboard.layout')

@section('title', 'HRMS | تسجيل حضور')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
    <h2 style="margin: 0;">تسجيل حضور جديد</h2>
    <a href="{{ route('attendances.index') }}" class="btn btn-back">← رجوع</a>
</div>

<form action="{{ route('attendances.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="employee_id">الموظف <span style="color: #ef4444;">*</span></label>
        <select id="employee_id" name="employee_id" required>
            <option value="">اختر الموظف</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="date">التاريخ <span style="color: #ef4444;">*</span></label>
        <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" required>
    </div>

    <div class="form-group">
        <label for="check_in">وقت الدخول</label>
        <input type="time" id="check_in" name="check_in">
    </div>

    <div class="form-group">
        <label for="check_out">وقت الخروج</label>
        <input type="time" id="check_out" name="check_out">
    </div>

    <div class="form-group">
        <label for="status">الحالة <span style="color: #ef4444;">*</span></label>
        <select id="status" name="status" required>
            <option value="present">حاضر</option>
            <option value="absent">غائب</option>
            <option value="late">متأخر</option>
            <option value="half_day">نصف يوم</option>
        </select>
    </div>

    <div class="form-group">
        <label for="notes">ملاحظات</label>
        <textarea id="notes" name="notes" rows="3"></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-add"> حفظ</button>
        <a href="{{ route('attendances.index') }}" class="btn btn-back">إلغاء</a>
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
    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }
    .btn-back {
        background: #6b7280;
    }
</style>
@endsection

