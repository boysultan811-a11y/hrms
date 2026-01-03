@extends('dashboard.layout')

@section('title', 'HRMS | إضافة ميزة')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إضافة ميزة جديدة</h2>
    <a href="{{ route('benefits.index') }}" class="btn btn-back"> رجوع</a>
</div>

<form action="{{ route('benefits.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="employee_id">الموظف <span style="color: #ef4444;"></span></label>
        <select id="employee_id" name="employee_id" required>
            <option value="">اختر الموظف</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="type">نوع الميزة <span style="color: #ef4444;"></span></label>
        <select id="type" name="type" required>
            <option value="تأمين صحي">تأمين صحي</option>
            <option value="بدلات">بدلات</option>
            <option value="حوافز">حوافز</option>
            <option value="أخرى">أخرى</option>
        </select>
    </div>

    <div class="form-group">
        <label for="name">اسم الميزة <span style="color: #ef4444;"></span></label>
        <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="amount">المبلغ</label>
        <input type="number" id="amount" name="amount" step="0.01" min="0">
    </div>

    <div class="form-group">
        <label for="start_date">تاريخ البدء <span style="color: #ef4444;"></span></label>
        <input type="date" id="start_date" name="start_date" value="{{ date('Y-m-d') }}" required>
    </div>

    <div class="form-group">
        <label for="end_date">تاريخ الانتهاء</label>
        <input type="date" id="end_date" name="end_date">
    </div>

    <div class="form-group">
        <label for="status">الحالة <span style="color: #ef4444;"></span></label>
        <select id="status" name="status" required>
            <option value="active">نشط</option>
            <option value="inactive">غير نشط</option>
        </select>
    </div>

    <div class="form-group">
        <label for="description">الوصف</label>
        <textarea id="description" name="description" rows="3"></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-add"> حفظ</button>
        <a href="{{ route('benefits.index') }}" class="btn btn-back">إلغاء</a>
    </div>
</form>
@endsection

@section('styles')
<style>
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 13px; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 7px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; }
    .form-actions { display: flex; gap: 10px; margin-top: 25px; }
    .btn-back { background: #6b7280; }
</style>
@endsection

