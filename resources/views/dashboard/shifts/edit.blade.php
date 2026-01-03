@extends('dashboard.layout')

@section('title', 'HRMS | تعديل شفتة')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">تعديل شفتة</h2>
    <a href="{{ route('shifts.index') }}" class="btn btn-back"> رجوع</a>
</div>

<form action="{{ route('shifts.update', $shift->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="name">اسم الشفتة <span style="color: #ef4444;">*</span></label>
        <input type="text" id="name" name="name" value="{{ $shift->name }}" required>
    </div>

    <div class="form-group">
        <label for="start_time">وقت البدء <span style="color: #ef4444;">*</span></label>
        <input type="time" id="start_time" name="start_time" value="{{ date('H:i', strtotime($shift->start_time)) }}" required>
    </div>

    <div class="form-group">
        <label for="end_time">وقت الانتهاء <span style="color: #ef4444;">*</span></label>
        <input type="time" id="end_time" name="end_time" value="{{ date('H:i', strtotime($shift->end_time)) }}" required>
    </div>

    <div class="form-group">
        <label for="break_duration">مدة الاستراحة (بالدقائق)</label>
        <input type="number" id="break_duration" name="break_duration" min="0" value="{{ $shift->break_duration ?? 0 }}">
    </div>

    <div class="form-group">
        <label for="description">الوصف</label>
        <textarea id="description" name="description" rows="3">{{ $shift->description }}</textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> حفظ التعديلات</button>
        <a href="{{ route('shifts.index') }}" class="btn btn-back">إلغاء</a>
    </div>
</form>
@endsection

@section('styles')
<style>
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 6px; font-weight: 600; color: #374151; font-size: 13px; }
    .form-group input, .form-group textarea { width: 100%; padding: 7px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; }
    .form-actions { display: flex; gap: 10px; margin-top: 25px; }
    .btn-back { background: #6b7280; }
</style>
@endsection

