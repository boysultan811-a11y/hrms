@extends('dashboard.layout')

@section('title', 'HRMS | طلبات الموظفين')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة طلبات الموظفين</h2>
    <a href="{{ route('employee-requests.create') }}" class="btn btn-add"> إضافة طلب جديد</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>اسم الموظف</th>
            <th>نوع الطلب</th>
            <th>الوصف</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($requests as $request)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $request->employee->name ?? '-' }}</td>
                <td>{{ $request->request_type }}</td>
                <td>{{ Str::limit($request->description, 50) }}</td>
                <td>
                    @if($request->status == 'approved')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> معتمد</span>
                    @elseif($request->status == 'rejected')
                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> مرفوض</span>
                    @else
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> قيد الانتظار</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('employee-requests.edit', $request->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('employee-requests.destroy', $request->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد طلبات حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

