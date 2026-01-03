@extends('dashboard.layout')

@section('title', 'HRMS | إدارة الوثائق')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة الوثائق</h2>
    <a href="{{ route('documents.create') }}" class="btn btn-add"> إضافة وثيقة جديدة</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>اسم الوثيقة</th>
            <th>النوع</th>
            <th>اسم الموظف</th>
            <th>تاريخ الإصدار</th>
            <th>تاريخ الانتهاء</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($documents as $document)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $document->name }}</td>
                <td>{{ $document->type }}</td>
                <td>{{ $document->employee->name ?? '-' }}</td>
                <td>{{ $document->issue_date ? $document->issue_date->format('Y-m-d') : '-' }}</td>
                <td>{{ $document->expiry_date ? $document->expiry_date->format('Y-m-d') : '-' }}</td>
                <td>
                    <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('documents.destroy', $document->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد وثائق حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

