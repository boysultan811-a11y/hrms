<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report->title }}</title>
    <style>
        @page {
            margin: 20mm;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            direction: rtl;
            text-align: right;
            color: #333;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3b82f6;
        }

        .header h1 {
            color: #1f2937;
            margin: 0 0 10px 0;
            font-size: 24px;
        }

        .header p {
            color: #6b7280;
            margin: 5px 0;
            font-size: 14px;
        }

        .info-section {
            margin-bottom: 25px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .info-section h2 {
            color: #1f2937;
            font-size: 18px;
            margin: 0 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .info-value {
            color: #1f2937;
            font-weight: 600;
            font-size: 14px;
        }

        .description {
            margin-top: 20px;
            padding: 15px;
            background: #ffffff;
            border-right: 4px solid #3b82f6;
            border-radius: 6px;
        }

        .description h3 {
            color: #1f2937;
            font-size: 16px;
            margin: 0 0 10px 0;
        }

        .description p {
            color: #4b5563;
            margin: 0;
            line-height: 1.8;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            background: #3b82f6;
            color: white;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $report->title }}</h1>
        <p>نظام إدارة الموارد البشرية - HRMS</p>
        <p>تاريخ الإنشاء: {{ $report->created_at->format('Y-m-d H:i') }}</p>
    </div>

    <div class="info-section">
        <h2>معلومات التقرير</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">نوع التقرير</span>
                <span class="info-value">{{ $reportType }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">تاريخ البداية</span>
                <span class="info-value">{{ $report->start_date ? $report->start_date->format('Y-m-d') : 'غير محدد' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">تاريخ النهاية</span>
                <span class="info-value">{{ $report->end_date ? $report->end_date->format('Y-m-d') : 'غير محدد' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">الحالة</span>
                <span class="badge">نشط</span>
            </div>
        </div>
    </div>

    @if($report->description)
        <div class="description">
            <h3>وصف التقرير</h3>
            <p>{{ $report->description }}</p>
        </div>
    @endif

    @if($report->data && count($report->data) > 0)
        <div class="info-section" style="margin-top: 25px;">
            <h2>بيانات التقرير</h2>
            <p style="color: #6b7280; font-size: 14px;">
                يحتوي هذا التقرير على {{ count($report->data) }} سجل بيانات.
            </p>
        </div>
    @endif

    <div class="footer">
        <p>تم إنشاء هذا التقرير تلقائياً من نظام HRMS</p>
        <p>جميع الحقوق محفوظة © {{ date('Y') }}</p>
    </div>
</body>
</html>

