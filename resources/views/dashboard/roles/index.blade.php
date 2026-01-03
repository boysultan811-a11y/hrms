@extends('dashboard.layout')

@section('title', 'HRMS | الصلاحيات والمستخدمين')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة الصلاحيات والمستخدمين</h2>
    <a href="{{ route('roles.create') }}" class="btn btn-add"> إضافة صلاحية جديدة</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>اسم الصلاحية</th>
            <th>الوصف</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($roles as $role)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->description ?? '-' }}</td>
                <td>
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد صلاحيات حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

