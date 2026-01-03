@extends('dashboard.layout')

@section('title', 'HRMS | تعديل ميزة')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">تعديل ميزة</h2>
    <a href="{{ route('benefits.index') }}" class="btn btn-back"> رجوع</a>
</div>

<form action="{{ route('benefits.update', $benefit->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="employee_id">الموظف <span style="color: #ef4444;"></span></label>
        <select id="employee_id" name="employee_id" required>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ $benefit->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="type">نوع الميزة <span style="color: #ef4444;"></span></label>
        <input type="text" id="type" name="type" value="{{ $benefit->type }}" required>
    </div>

    <div class="form-group">
        <label for="name">اسم الميزة <span style="color: #ef4444;"></span></label>
        <input type="text" id="name" name="name" value="{{ $benefit->name }}" required>
    </div>

    <div class="form-group">
        <label for="amount">المبلغ</label>
        <input type="number" id="amount" name="amount" step="0.01" min="0" value="{{ $benefit->amount }}">
    </div>

    <div class="form-group">
        <label for="start_date">تاريخ البدء <span style="color: #ef4444;"></span></label>
        <input type="date" id="start_date" name="start_date" value="{{ $benefit->start_date->format('Y-m-d') }}" required>
    </div>

    <div class="form-group">
        <label for="end_date">تاريخ الانتهاء</label>
        <input type="date" id="end_date" name="end_date" value="{{ $benefit->end_date ? $benefit->end_date->format('Y-m-d') : '' }}">
    </div>

    <div class="form-group">
        <label for="status">الحالة <span style="color: #ef4444;"></span></label>
        <select id="status" name="status" required>
            <option value="active" {{ $benefit->status == 'active' ? 'selected' : '' }}>نشط</option>
            <option value="inactive" {{ $benefit->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
        </select>
    </div>

    <div class="form-group">
        <label for="description">الوصف</label>
        <textarea id="description" name="description" rows="3">{{ $benefit->description }}</textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> حفظ التعديلات</button>
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

