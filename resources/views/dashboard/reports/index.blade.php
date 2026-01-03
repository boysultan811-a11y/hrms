@extends('dashboard.layout')

@section('title', 'HRMS | التقارير والتحليلات')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">التقارير والتحليلات</h2>
    <a href="{{ route('reports.create') }}" class="btn btn-add"> إنشاء تقرير جديد</a>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<p style="color: #6b7280; margin-bottom: 15px;">عدد التقارير: <strong>{{ $reports->count() }}</strong></p>

<table>
    <thead>
        <tr>
            <th>عنوان التقرير</th>
            <th>نوع التقرير</th>
            <th>تاريخ البداية</th>
            <th>تاريخ النهاية</th>
            <th>تاريخ الإنشاء</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reports as $report)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $report->title }}</td>
                <td>
                    @php
                        $types = [
                            'employees' => 'تقارير الموظفين',
                            'attendance' => 'تقارير الحضور',
                            'payroll' => 'تقارير الرواتب',
                            'performance' => 'تقارير الأداء',
                            'leaves' => 'تقارير الإجازات',
                            'benefits' => 'تقارير المزايا',
                        ];
                    @endphp
                    {{ $types[$report->type] ?? $report->type }}
                </td>
                <td>{{ $report->start_date ? $report->start_date->format('Y-m-d') : '-' }}</td>
                <td>{{ $report->end_date ? $report->end_date->format('Y-m-d') : '-' }}</td>
                <td>{{ $report->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('reports.show', $report->id) }}" class="btn btn-view btn-sm"> عرض</a>
                    <a href="{{ route('reports.export-pdf', $report->id) }}" class="btn btn-sm" style="background: #dc2626; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; display: inline-block; margin: 0 2px;">📄 PDF</a>
                    <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-edit btn-sm"> تعديل</a>
                    <form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا التقرير؟')"> حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">
                    لا يوجد تقارير حالياً
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

