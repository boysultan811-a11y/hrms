@extends('dashboard.layout')

@section('title', 'HRMS | الحضور والانصراف')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة الحضور والانصراف</h2>
    <a href="{{ route('attendances.create') }}" class="btn btn-add"> تسجيل حضور جديد</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>اسم الموظف</th>
            <th>التاريخ</th>
            <th>وقت الدخول</th>
            <th>وقت الخروج</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($attendances as $attendance)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $attendance->employee->name ?? '-' }}</td>
                <td>{{ $attendance->date->format('Y-m-d') }}</td>
                <td>{{ $attendance->check_in ?? '-' }}</td>
                <td>{{ $attendance->check_out ?? '-' }}</td>
                <td>
                    @if($attendance->status == 'present')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> حاضر</span>
                    @elseif($attendance->status == 'absent')
                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> غائب</span>
                    @elseif($attendance->status == 'late')
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> متأخر</span>
                    @else
                        <span style="background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> نصف يوم</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد سجلات حضور حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

