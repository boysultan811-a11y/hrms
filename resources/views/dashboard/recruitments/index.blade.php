@extends('dashboard.layout')

@section('title', 'HRMS | التوظيف والاستقطاب')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة التوظيف والاستقطاب</h2>
    <a href="{{ route('recruitments.create') }}" class="btn btn-add"> إضافة وظيفة جديدة</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>المسمى الوظيفي</th>
            <th>القسم</th>
            <th>تاريخ النشر</th>
            <th>عدد المتقدمين</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($recruitments as $recruitment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $recruitment->job_title }}</td>
                <td>{{ $recruitment->department ?? '-' }}</td>
                <td>{{ $recruitment->posted_date->format('Y-m-d') }}</td>
                <td>{{ $recruitment->applicants_count }}</td>
                <td>
                    @if($recruitment->status == 'open')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> مفتوحة</span>
                    @elseif($recruitment->status == 'closed')
                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> مغلقة</span>
                    @else
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> متوقفة</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('recruitments.edit', $recruitment->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('recruitments.destroy', $recruitment->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد وظائف حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

