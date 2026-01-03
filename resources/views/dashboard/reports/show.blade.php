@extends('dashboard.layout')

@section('title', 'HRMS | عرض التقرير')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">عرض التقرير</h2>
    <a href="{{ route('reports.index') }}" class="btn btn-back"> رجوع</a>
</div>

<div class="content-wrapper">
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 10px 0; color: #1f2937;">{{ $report->title }}</h3>
            <p style="color: #6b7280; margin: 0;">
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
                نوع التقرير: <strong>{{ $types[$report->type] ?? $report->type }}</strong>
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
            <div>
                <p style="color: #6b7280; margin: 0 0 5px 0; font-size: 14px;">تاريخ البداية</p>
                <p style="margin: 0; font-weight: 600;">{{ $report->start_date ? $report->start_date->format('Y-m-d') : '-' }}</p>
            </div>
            <div>
                <p style="color: #6b7280; margin: 0 0 5px 0; font-size: 14px;">تاريخ النهاية</p>
                <p style="margin: 0; font-weight: 600;">{{ $report->end_date ? $report->end_date->format('Y-m-d') : '-' }}</p>
            </div>
            <div>
                <p style="color: #6b7280; margin: 0 0 5px 0; font-size: 14px;">تاريخ الإنشاء</p>
                <p style="margin: 0; font-weight: 600;">{{ $report->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        @if($report->description)
            <div style="margin-bottom: 20px;">
                <p style="color: #6b7280; margin: 0 0 10px 0; font-size: 14px;">الوصف</p>
                <p style="margin: 0; line-height: 1.6;">{{ $report->description }}</p>
            </div>
        @endif

        @if($report->file_path)
            <div style="margin-bottom: 20px;">
                <p style="color: #6b7280; margin: 0 0 10px 0; font-size: 14px;">ملف التقرير</p>
                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn btn-view"> عرض الملف</a>
            </div>
        @endif

        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <a href="{{ route('reports.export-pdf', $report->id) }}" class="btn" style="background: #dc2626; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-block; transition: background 0.3s;">📄 تصدير PDF</a>
            <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-edit"> تعديل</a>
            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا التقرير؟')"> حذف</button>
            </form>
        </div>
    </div>
</div>
@endsection

