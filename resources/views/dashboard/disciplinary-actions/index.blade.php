@extends('dashboard.layout')

@section('title', 'HRMS | الإنذارات والعقوبات')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة الإنذارات والعقوبات</h2>
    <a href="{{ route('disciplinary-actions.create') }}" class="btn btn-add"> إضافة إجراء تأديبي</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>اسم الموظف</th>
            <th>نوع المخالفة</th>
            <th>تاريخ الإجراء</th>
            <th>الخطورة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($actions as $action)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $action->employee->name ?? '-' }}</td>
                <td>{{ $action->violation_type }}</td>
                <td>{{ $action->action_date->format('Y-m-d') }}</td>
                <td>
                    @if($action->severity == 'high')
                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 12px; font-size: 13px;">🔴 عالية</span>
                    @elseif($action->severity == 'medium')
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 13px;">🟡 متوسطة</span>
                    @else
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;">🟢 منخفضة</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('disciplinary-actions.edit', $action->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('disciplinary-actions.destroy', $action->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد إجراءات تأديبية حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

