@extends('dashboard.layout')

@section('title', 'HRMS | تهيئة الموظفين الجدد')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة تهيئة الموظفين الجدد</h2>
    <a href="{{ route('onboardings.create') }}" class="btn btn-add"> إضافة تهيئة جديدة</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>اسم الموظف</th>
            <th>تاريخ البدء</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($onboardings as $onboarding)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $onboarding->employee->name ?? '-' }}</td>
                <td>{{ $onboarding->start_date->format('Y-m-d') }}</td>
                <td>
                    @if($onboarding->status == 'completed')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> مكتمل</span>
                    @elseif($onboarding->status == 'in_progress')
                        <span style="background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> قيد التنفيذ</span>
                    @else
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> قيد الانتظار</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('onboardings.edit', $onboarding->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('onboardings.destroy', $onboarding->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد تهيئات حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

