@extends('dashboard.layout')

@section('title', 'HRMS | إضافة قسم')

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
    .form-group textarea {
        width: 100%;
        padding: 7px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
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
    <h2 style="margin: 0;">إضافة قسم جديد</h2>
    <a href="{{ route('sections.index') }}" class="btn btn-back"> رجوع</a>
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

<form action="{{ route('sections.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="name">اسم القسم <span style="color: #ef4444;">*</span></label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
        <label for="description">الوصف</label>
        <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-add"> حفظ</button>
        <a href="{{ route('sections.index') }}" class="btn btn-back">إلغاء</a>
    </div>
</form>
@endsection

