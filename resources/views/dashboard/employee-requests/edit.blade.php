@extends('dashboard.layout')

@section('title', 'HRMS | تعديل طلب')

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
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3b82f6;
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

    .error-list {
        background: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .error-list ul {
        margin: 0;
        padding: 0 0 0 20px;
        color: #991b1b;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 20px;">
    <h2 style="margin: 0 0 10px 0;">تعديل طلب</h2>
    <p style="color: #6b7280; margin: 0;">قم بتعديل بيانات الطلب</p>
</div>

@if ($errors->any())
    <div class="error-list">
        <strong> يرجى تصحيح الأخطاء التالية:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('employee-requests.update', $employeeRequest->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label>اسم الموظف <span style="color: red;">*</span></label>
        <select name="employee_id" required>
            <option value="">اختر الموظف</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ old('employee_id', $employeeRequest->employee_id) == $employee->id ? 'selected' : '' }}>
                    {{ $employee->name }}
                </option>
            @endforeach
        </select>
        @error('employee_id')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>نوع الطلب <span style="color: red;">*</span></label>
        <input type="text" name="request_type" value="{{ old('request_type', $employeeRequest->request_type) }}" required placeholder="مثال: طلب نقل، طلب ترقية، طلب تعديل راتب">
        @error('request_type')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الوصف <span style="color: red;">*</span></label>
        <textarea name="description" required placeholder="أدخل وصف الطلب">{{ old('description', $employeeRequest->description) }}</textarea>
        @error('description')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الحالة <span style="color: red;">*</span></label>
        <select name="status" required>
            <option value="">اختر الحالة</option>
            <option value="pending" {{ old('status', $employeeRequest->status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
            <option value="approved" {{ old('status', $employeeRequest->status) == 'approved' ? 'selected' : '' }}>معتمد</option>
            <option value="rejected" {{ old('status', $employeeRequest->status) == 'rejected' ? 'selected' : '' }}>مرفوض</option>
        </select>
        @error('status')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الرد</label>
        <textarea name="response" placeholder="أدخل رد على الطلب">{{ old('response', $employeeRequest->response) }}</textarea>
        @error('response')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> تحديث البيانات</button>
        <a href="{{ route('employee-requests.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection

