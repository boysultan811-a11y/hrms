@extends('dashboard.layout')

@section('title', 'HRMS | الموظفين')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة الموظفين</h2>
    <a href="{{ route('employees.create') }}" class="btn btn-add"> إضافة موظف جديد</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<p style="color: #6b7280; margin-bottom: 15px;">عدد الموظفين: <strong>{{ $employees->count() }}</strong></p>

<table>
    <thead>
        <tr>
            
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>الهاتف</th>
            <th>الوظيفة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($employees as $employee)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone ?? '-' }}</td>
                <td>{{ $employee->position ?? '-' }}</td>
                <td>
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا الموظف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد موظفين حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
