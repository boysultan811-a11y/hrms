@extends('dashboard.layout')

@section('title', 'HRMS | الاستقالات وإنهاء الخدمة')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة الاستقالات وإنهاء الخدمة</h2>
    <a href="{{ route('offboardings.create') }}" class="btn btn-add"> إضافة إنهاء خدمة</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>اسم الموظف</th>
            <th>النوع</th>
            <th>تاريخ الاستقالة</th>
            <th>آخر يوم عمل</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($offboardings as $offboarding)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $offboarding->employee->name ?? '-' }}</td>
                <td>{{ $offboarding->type == 'resignation' ? 'استقالة' : ($offboarding->type == 'termination' ? 'إنهاء' : 'تقاعد') }}</td>
                <td>{{ $offboarding->resignation_date->format('Y-m-d') }}</td>
                <td>{{ $offboarding->last_work_day->format('Y-m-d') }}</td>
                <td>
                    @if($offboarding->status == 'completed')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> مكتمل</span>
                    @elseif($offboarding->status == 'processing')
                        <span style="background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> قيد المعالجة</span>
                    @else
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> قيد الانتظار</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('offboardings.edit', $offboarding->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('offboardings.destroy', $offboarding->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑️ حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد إنهاء خدمات حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

