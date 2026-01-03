@extends('dashboard.layout')

@section('title', 'HRMS | التدريب والتطوير')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة التدريب والتطوير</h2>
    <a href="{{ route('trainings.create') }}" class="btn btn-add">➕ إضافة دورة جديدة</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>عنوان الدورة</th>
            <th>المدرب</th>
            <th>تاريخ البدء</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($trainings as $training)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $training->title }}</td>
                <td>{{ $training->instructor ?? '-' }}</td>
                <td>{{ $training->start_date->format('Y-m-d') }}</td>
                <td>
                    @if($training->status == 'completed')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px;">✅ مكتملة</span>
                    @elseif($training->status == 'in_progress')
                        <span style="background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 12px; font-size: 13px;">🔄 قيد التنفيذ</span>
                    @elseif($training->status == 'cancelled')
                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 12px; font-size: 13px;">❌ ملغاة</span>
                    @else
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 13px;">📅 مجدولة</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('trainings.edit', $training->id) }}" class="btn btn-edit btn-sm">✏️ تعديل</a>
                    <form action="{{ route('trainings.destroy', $training->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑️ حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد دورات حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

