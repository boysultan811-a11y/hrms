@extends('dashboard.layout')

@section('title', 'HRMS | تعديل صلاحية')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">تعديل صلاحية</h2>
    <a href="{{ route('roles.index') }}" class="btn btn-back"> رجوع</a>
</div>

<form action="{{ route('roles.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="name">اسم الصلاحية <span style="color: #ef4444;">*</span></label>
        <input type="text" id="name" name="name" value="{{ $role->name }}" required>
    </div>

    <div class="form-group">
        <label for="description">الوصف</label>
        <textarea id="description" name="description" rows="3">{{ $role->description }}</textarea>
    </div>

    <div class="form-group">
        <label for="permissions">الصلاحيات (JSON)</label>
        <textarea id="permissions" name="permissions" rows="5">{{ $role->permissions ? json_encode($role->permissions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '' }}</textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> حفظ التعديلات</button>
        <a href="{{ route('roles.index') }}" class="btn btn-back">إلغاء</a>
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

