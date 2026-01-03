@extends('dashboard.layout')

@section('title', 'HRMS | إدارة الشفتات')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">إدارة الشفتات</h2>
    <a href="{{ route('shifts.create') }}" class="btn btn-add"> إضافة شفتة جديدة</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>اسم الشفتة</th>
            <th>وقت البدء</th>
            <th>وقت الانتهاء</th>
            <th>مدة الاستراحة (دقيقة)</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($shifts as $shift)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $shift->name }}</td>
                <td>{{ date('H:i', strtotime($shift->start_time)) }}</td>
                <td>{{ date('H:i', strtotime($shift->end_time)) }}</td>
                <td>{{ $shift->break_duration ?? 0 }}</td>
                <td>
                    <a href="{{ route('shifts.edit', $shift->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد شفتات حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

