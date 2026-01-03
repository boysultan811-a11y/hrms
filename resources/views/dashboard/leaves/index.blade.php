@extends('dashboard.layout')

@section('title', 'HRMS | الإجازات')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة الإجازات</h2>
    <a href="{{ route('leaves.create') }}" class="btn btn-add"> إضافة إجازة جديدة</a>
</div>

<table>
    <thead>
        <tr>
            <th>اسم الموظف</th>
            <th>نوع الإجازة</th>
            <th>من تاريخ</th>
            <th>إلى تاريخ</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($leaves as $leave)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $leave->employee_name }}</td>
                <td>{{ $leave->leave_type }}</td>
                <td>{{ $leave->start_date }}</td>
                <td>{{ $leave->end_date }}</td>
                <td>
                    @if($leave->status == 'pending')
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> قيد الانتظار</span>
                    @elseif($leave->status == 'approved')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> موافق عليها</span>
                    @else
                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> مرفوضة</span>
                    @endif
                </td>
                <td>
                    @if($leave->status == 'pending')
                        <form action="{{ route('leaves.approve', $leave->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-edit btn-sm"> موافقة</button>
                        </form>
                        <form action="{{ route('leaves.reject', $leave->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-delete btn-sm"> رفض</button>
                        </form>
                    @else
                        <span style="color: #9ca3af; font-size: 14px;">تمت المعالجة</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد طلبات إجازة حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
