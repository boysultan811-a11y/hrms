@extends('dashboard.layout')

@section('title', 'HRMS | الرواتب والأجور')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة الرواتب والأجور</h2>
    <a href="{{ route('payrolls.create') }}" class="btn btn-add"> إضافة كشف راتب جديد</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>اسم الموظف</th>
            <th>تاريخ الراتب</th>
            <th>الراتب الأساسي</th>
            <th>إجمالي الراتب</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($payrolls as $payroll)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payroll->employee->name ?? '-' }}</td>
                <td>{{ $payroll->payroll_date->format('Y-m-d') }}</td>
                <td>{{ number_format($payroll->basic_salary, 2) }} ر.س</td>
                <td><strong>{{ number_format($payroll->total_salary, 2) }} ر.س</strong></td>
                <td>
                    @if($payroll->status == 'paid')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> مدفوع</span>
                    @elseif($payroll->status == 'approved')
                        <span style="background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> معتمد</span>
                    @else
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 13px;"> قيد الانتظار</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('payrolls.edit', $payroll->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('payrolls.destroy', $payroll->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد كشوف رواتب حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

