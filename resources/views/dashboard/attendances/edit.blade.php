@extends('dashboard.layout')

@section('title', 'HRMS | تعديل حضور')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">تعديل سجل حضور</h2>
    <a href="{{ route('attendances.index') }}" class="btn btn-back">رجوع</a>
</div>

<form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="employee_id">الموظف <span style="color: #ef4444;"></span></label>
        <select id="employee_id" name="employee_id" required>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ $attendance->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="date">التاريخ <span style="color: #ef4444;"></span></label>
        <input type="date" id="date" name="date" value="{{ $attendance->date->format('Y-m-d') }}" required>
    </div>

    <div class="form-group">
        <label for="check_in">وقت الدخول</label>
        <input type="time" id="check_in" name="check_in" value="{{ $attendance->check_in ? date('H:i', strtotime($attendance->check_in)) : '' }}">
    </div>

    <div class="form-group">
        <label for="check_out">وقت الخروج</label>
        <input type="time" id="check_out" name="check_out" value="{{ $attendance->check_out ? date('H:i', strtotime($attendance->check_out)) : '' }}">
    </div>

    <div class="form-group">
        <label for="status">الحالة <span style="color: #ef4444;"></span></label>
        <select id="status" name="status" required>
            <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>حاضر</option>
            <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>غائب</option>
            <option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>متأخر</option>
            <option value="half_day" {{ $attendance->status == 'half_day' ? 'selected' : '' }}>نصف يوم</option>
        </select>
    </div>

    <div class="form-group">
        <label for="notes">ملاحظات</label>
        <textarea id="notes" name="notes" rows="3">{{ $attendance->notes }}</textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> حفظ التعديلات</button>
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

