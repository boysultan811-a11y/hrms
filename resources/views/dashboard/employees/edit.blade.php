@extends('dashboard.layout')

@section('title', 'HRMS | تعديل موظف')

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
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #4f46e5;
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
<div style="margin-bottom: 20px;">
    <h2 style="margin: 0 0 10px 0;">تعديل بيانات الموظف</h2>
    <p style="color: #6b7280; margin: 0;">قم بتعديل بيانات: {{ $employee->name }}</p>
</div>

<form action="{{ route('employees.update', $employee->id) }}" method="POST">
    @csrf
    @method('PUT')
    

    <div class="form-group">
        <label>الرقم التسلسلي <span style="color: red;">*</span></label>
        <input type="text" name="serial_number" value="{{ old('serial_number', $employee->serial_number ?? '') }}" required placeholder="أدخل الرقم التسلسلي">
        @error('serial_number')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>اسم الموظف <span style="color: red;">*</span></label>
        <input type="text" name="name" value="{{ old('name', $employee->name) }}" required placeholder="أدخل اسم الموظف">
        @error('name')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>رقم الهوية <span style="color: red;">*</span></label>
        <input type="text" name="national_id" value="{{ old('national_id', $employee->national_id ?? '') }}" required placeholder="أدخل رقم الهوية">
        @error('national_id')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>العنوان</label>
        <input type="text" name="address" value="{{ old('address', $employee->address ?? '') }}" placeholder="أدخل العنوان">
        @error('address')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="form-group">
        <label>الجنس</label>
        <select name="gender">
            <option value="">اختر الجنس</option>
            <option value="ذكر" {{ old('gender', $employee->gender ?? '') == 'ذكر' ? 'selected' : '' }}>ذكر</option>
            <option value="أنثى" {{ old('gender', $employee->gender ?? '') == 'أنثى' ? 'selected' : '' }}>أنثى</option>
        </select>
        @error('gender')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الحالة الاجتماعية</label>
        <select name="marital_status">
            <option value="">اختر الحالة الاجتماعية</option>
            <option value="أعزب" {{ old('marital_status', $employee->marital_status ?? '') == 'أعزب' ? 'selected' : '' }}>أعزب</option>
            <option value="متزوج" {{ old('marital_status', $employee->marital_status ?? '') == 'متزوج' ? 'selected' : '' }}>متزوج</option>
            <option value="مطلق" {{ old('marital_status', $employee->marital_status ?? '') == 'مطلق' ? 'selected' : '' }}>مطلق</option>
            <option value="أرمل" {{ old('marital_status', $employee->marital_status ?? '') == 'أرمل' ? 'selected' : '' }}>أرمل</option>
        </select>
        @error('marital_status')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الدرجة العلمية</label>
        <select name="qualification">
            <option value="">اختر الدرجة العلمية</option>
            <option value="بكالوريوس" {{ old('qualification', $employee->qualification ?? '') == 'بكالوريوس' ? 'selected' : '' }}>بكالوريوس</option>
            <option value="ماجستير" {{ old('qualification', $employee->qualification ?? '') == 'ماجستير' ? 'selected' : '' }}>ماجستير</option>
            <option value="دكتوراه" {{ old('qualification', $employee->qualification ?? '') == 'دكتوراه' ? 'selected' : '' }}>دكتوراه</option>
        </select>
        @error('qualification')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>المسمى الوظيفي</label>
        <input type="text" name="position" value="{{ old('position', $employee->position) }}" placeholder="مثال: مدير مبيعات">
        @error('position')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>العنوان الوظيفي</label>
        <input type="text" name="job_address" value="{{ old('job_address', $employee->job_address ?? '') }}" placeholder="أدخل العنوان الوظيفي">
        @error('job_address')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الراتب</label>
        <input type="number" name="salary" value="{{ old('salary', $employee->salary ?? '') }}" placeholder="أدخل الراتب">
        @error('salary')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>فئة الاجازة</label>
        <input type="text" name="leave_category" value="{{ old('leave_category', $employee->leave_category ?? '') }}" placeholder="أدخل فئة الاجازة">
        @error('leave_category')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>


    <div class="form-group">
        <label>جدول الدوام</label>
        <input type="text" name="work_schedule" value="{{ old('work_schedule', $employee->work_schedule ?? '') }}" placeholder="أدخل جدول الدوام">
        @error('work_schedule')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>


    <div class="form-actions">
        <button type="submit" class="btn btn-edit"> تحديث البيانات</button>
        <a href="{{ route('employees.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection
