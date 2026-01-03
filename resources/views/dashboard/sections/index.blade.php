@extends('dashboard.layout')

@section('title', 'HRMS | الأقسام')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة الأقسام</h2>
    <a href="{{ route('sections.create') }}" class="btn btn-add"> إضافة قسم جديد</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<p style="color: #6b7280; margin-bottom: 15px;">عدد الأقسام: <strong>{{ $sections->count() }}</strong></p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>اسم القسم</th>
            <th>الوصف</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sections as $section)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $section->name }}</td>
                <td>{{ $section->description ?? '-' }}</td>
                <td>
                    <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('sections.destroy', $section->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا القسم؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد أقسام حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

