@extends('dashboard.layout')

@section('title', 'HRMS | إدارة العقود')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة العقود</h2>
    <a href="{{ route('contracts.create') }}" class="btn btn-add"> إضافة عقد جديد</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>اسم الموظف</th>
            <th>نوع العقد</th>
            <th>تاريخ البدء</th>
            <th>الراتب</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($contracts as $contract)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $contract->employee->name ?? '-' }}</td>
                <td>{{ $contract->contract_type }}</td>
                <td>{{ $contract->start_date->format('Y-m-d') }}</td>
                <td>{{ number_format($contract->salary, 2) }} ر.س</td>
                <td>
                    @if($contract->status == 'active')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> نشط</span>
                    @elseif($contract->status == 'expired')
                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> منتهي</span>
                    @else
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> منتهي</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد عقود حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

