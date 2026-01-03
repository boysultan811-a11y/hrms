@extends('dashboard.layout')

@section('title', 'HRMS | المزايا والتعويضات')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة المزايا والتعويضات</h2>
    <a href="{{ route('benefits.create') }}" class="btn btn-add"> إضافة ميزة جديدة</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>اسم الموظف</th>
            <th>نوع الميزة</th>
            <th>اسم الميزة</th>
            <th>المبلغ</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($benefits as $benefit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $benefit->employee->name ?? '-' }}</td>
                <td>{{ $benefit->type }}</td>
                <td>{{ $benefit->name }}</td>
                <td>{{ $benefit->amount ? number_format($benefit->amount, 2) . ' ر.س' : '-' }}</td>
                <td>
                    @if($benefit->status == 'active')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> نشط</span>
                    @else
                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> غير نشط</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('benefits.edit', $benefit->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('benefits.destroy', $benefit->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد مزايا حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

