@extends('dashboard.layout')

@section('title', 'HRMS | إضافة موظف')

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
    <h2 style="margin: 0 0 10px 0;">إضافة موظف جديد</h2>
    <p style="color: #6b7280; margin: 0;">قم بإدخال بيانات الموظف الجديد</p>
</div>

@if ($errors->any())
    <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
        <strong style="color: #991b1b;"> يرجى تصحيح الأخطاء التالية:</strong>
        <ul style="margin: 10px 0 0 0; padding: 0 0 0 20px; color: #991b1b;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('employees.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label>الرقم التسلسلي <span style="color: red;">*</span></label>
        <input type="text" name="serial_number" value="{{ old('serial_number') }}" required placeholder="أدخل الرقم التسلسلي">
        @error('serial_number')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>اسم الموظف <span style="color: red;">*</span></label>
        <input type="text" name="name" value="{{ old('name') }}" required placeholder="أدخل اسم الموظف">
        @error('name')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>رقم الهوية <span style="color: red;">*</span></label>
        <input type="text" name="national_id" value="{{ old('national_id') }}" required placeholder="أدخل رقم الهوية">
        @error('national_id')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>العنوان</label>
        <input type="text" name="address" value="{{ old('address') }}" placeholder="أدخل العنوان">
        @error('address')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الجنس</label>
        <select name="gender">
            <option value="">اختر الجنس</option>
            <option value="ذكر" {{ old('gender') == 'ذكر' ? 'selected' : '' }}>ذكر</option>
            <option value="أنثى" {{ old('gender') == 'أنثى' ? 'selected' : '' }}>أنثى</option>
        </select>
        @error('gender')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>المدينة</label>
        <select name="city">
            <option value="">اختر المدينة</option>
            <option value="غزة" {{ old('city') == 'غزة' ? 'selected' : '' }}>غزة</option>
            <option value="القدس" {{ old('city') == 'القدس' ? 'selected' : '' }}>القدس</option>
            <option value="رام الله" {{ old('city') == 'رام الله' ? 'selected' : '' }}>رام الله</option>
            <option value="الخليل" {{ old('city') == 'الخليل' ? 'selected' : '' }}>الخليل</option>
            <option value="نابلس" {{ old('city') == 'نابلس' ? 'selected' : '' }}>نابلس</option>
            <option value="جنين" {{ old('city') == 'جنين' ? 'selected' : '' }}>جنين</option>
            <option value="طولكرم" {{ old('city') == 'طولكرم' ? 'selected' : '' }}>طولكرم</option>
            <option value="قلقيلية" {{ old('city') == 'قلقيلية' ? 'selected' : '' }}>قلقيلية</option>
            <option value="بيت لحم" {{ old('city') == 'بيت لحم' ? 'selected' : '' }}>بيت لحم</option>
            <option value="سلفيت" {{ old('city') == 'سلفيت' ? 'selected' : '' }}>سلفيت</option>
            <option value="طوباس" {{ old('city') == 'طوباس' ? 'selected' : '' }}>طوباس</option>
            <option value="أريحا" {{ old('city') == 'أريحا' ? 'selected' : '' }}>أريحا</option>
            <option value="رفح" {{ old('city') == 'رفح' ? 'selected' : '' }}>رفح</option>
            <option value="خانيونس" {{ old('city') == 'خانيونس' ? 'selected' : '' }}>خانيونس</option>
            <option value="دير البلح" {{ old('city') == 'دير البلح' ? 'selected' : '' }}>دير البلح</option>
            <option value="بيت حانون" {{ old('city') == 'بيت حانون' ? 'selected' : '' }}>بيت حانون</option>
        </select>
        @error('city')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الحالة الاجتماعية</label>
        <select name="marital_status">
            <option value="">اختر الحالة الاجتماعية</option>
            <option value="أعزب" {{ old('marital_status') == 'أعزب' ? 'selected' : '' }}>أعزب</option>
            <option value="متزوج" {{ old('marital_status') == 'متزوج' ? 'selected' : '' }}>متزوج</option>
            <option value="مطلق" {{ old('marital_status') == 'مطلق' ? 'selected' : '' }}>مطلق</option>
            <option value="أرمل" {{ old('marital_status') == 'أرمل' ? 'selected' : '' }}>أرمل</option>
        </select>
        @error('marital_status')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>الدرجة العلمية</label>
        <select name="qualification">
            <option value="">اختر الدرجة العلمية</option>
            <option value="غير متعلم " {{ old('qualification', $employee->qualification ?? '') == 'غير متعلم' ? 'selected' : '' }}>غير متعلم </option>
            <option value="ثانوي" {{ old('qualification', $employee->qualification ?? '') == 'ثانوي' ? 'selected' : '' }}>ثانوي</option>
            <option value="دبلوم" {{ old('qualification', $employee->qualification ?? '') == 'دبلوم' ? 'selected' : '' }}>دبلوم</option>
            <option value="بكالوريوس" {{ old('qualification', $employee->qualification ?? '') == 'بكالوريوس' ? 'selected' : '' }}>بكالوريوس</option>
            <option value="ماجستير" {{ old('qualification', $employee->qualification ?? '') == 'ماجستير' ? 'selected' : '' }}>ماجستير</option>
            <option value="دكتوراه" {{ old('qualification', $employee->qualification ?? '') == 'دكتوراه' ? 'selected' : '' }}>دكتوراه</option>
            <option value="أخرى" {{ old('qualification', $employee->qualification ?? '') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
        </select>
        @error('qualification')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>المسمى الوظيفي</label>
        <input type="text" name="position" value="{{ old('position') }}" placeholder="مثال: مدير مبيعات">
        @error('position')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>القسم</label>
        <select name="department">
            <option value="">اختر القسم</option>
            <option value="المحاسبة" {{ old('department') == 'المحاسبة' ? 'selected' : '' }}>المحاسبة</option>
            <option value="الموارد البشرية" {{ old('department') == 'الموارد البشرية' ? 'selected' : '' }}>الموارد البشرية</option>
            <option value="المبيعات" {{ old('department') == 'المبيعات' ? 'selected' : '' }}>المبيعات</option>
            <option value="التسويق" {{ old('department') == 'التسويق' ? 'selected' : '' }}>التسويق</option>
            <option value="خدمة العملاء" {{ old('department') == 'خدمة العملاء' ? 'selected' : '' }}>خدمة العملاء</option>
            <option value="الإدارة" {{ old('department') == 'الإدارة' ? 'selected' : '' }}>الإدارة</option>
            <option value="الإنتاج" {{ old('department') == 'الإنتاج' ? 'selected' : '' }}>الإنتاج</option>
            <option value="تكنولوجيا المعلومات" {{ old('department') == 'تكنولوجيا المعلومات' ? 'selected' : '' }}>تكنولوجيا المعلومات</option>
            <option value="أخرى" {{ old('department') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
        </select>
        @error('department')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>الراتب</label>
        <input type="number" name="salary" value="{{ old('salary') }}" placeholder="أدخل الراتب">
        @error('salary')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>فئة الاجازة</label>
        <select name="leave_category">
            <option value="">اختر فئة الاجازة</option>
            <option value="سنوية" {{ old('leave_category') == 'سنوية' ? 'selected' : '' }}>سنوية</option>
            <option value="عارضة" {{ old('leave_category') == 'عارضة' ? 'selected' : '' }}>عارضة</option>
            <option value="مرضية" {{ old('leave_category') == 'مرضية' ? 'selected' : '' }}>مرضية</option>
            <option value="بدون راتب" {{ old('leave_category') == 'بدون راتب' ? 'selected' : '' }}>بدون راتب</option>
            <option value="أخرى" {{ old('leave_category') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
        </select>
        @error('leave_category')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>


    <div class="form-group">
        <label>البريد الإلكتروني</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="example@email.com">
        @error('email')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>جدول الدوام</label>
        <input type="text" name="work_schedule" value="{{ old('work_schedule') }}" placeholder="أدخل جدول الدوام">
        @error('work_schedule')
            <span style="color: #ef4444; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-add"> حفظ البيانات</button>
        <a href="{{ route('employees.index') }}" class="btn btn-back"> رجوع</a>
    </div>
</form>
@endsection
