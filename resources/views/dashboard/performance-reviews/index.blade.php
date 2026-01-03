@extends('dashboard.layout')

@section('title', 'HRMS | تقييم الأداء')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة تقييم الأداء</h2>
    <a href="{{ route('performance-reviews.create') }}" class="btn btn-add"> إضافة تقييم جديد</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>اسم الموظف</th>
            <th>تاريخ التقييم</th>
            <th>الفترة</th>
            <th>التقييم العام</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reviews as $review)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $review->employee->name ?? '-' }}</td>
                <td>{{ $review->review_date->format('Y-m-d') }}</td>
                <td>{{ $review->review_period }}</td>
                <td>
                    <span style="background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 12px; font-size: 13px;">
                        {{ $review->overall_rating }}/10
                    </span>
                </td>
                <td>
                    <a href="{{ route('performance-reviews.edit', $review->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('performance-reviews.destroy', $review->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد تقييمات حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

