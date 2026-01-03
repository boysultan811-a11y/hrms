@extends('dashboard.layout')

@section('title', 'HRMS | Dashboard')

@section('styles')
<style>
    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px;
        background: linear-gradient(135deg, #1E3A8A 0%, #3B82F6 100%);
        border-radius: 12px;
        color: white;
    }

    .dashboard-header .greeting {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .dashboard-header .greeting h1 {
        margin: 0;
        font-size: 28px;
        color: white;
    }

    .dashboard-header .greeting .date {
        font-size: 14px;
        opacity: 0.9;
    }

    .dashboard-header .actions {
        display: flex;
        gap: 10px;
    }

    .header-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        backdrop-filter: blur(10px);
    }

    .header-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    /* Cards */
    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s;
        cursor: pointer;
        border-left: 4px solid;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .stat-card.card-employees {
        border-left-color: #1E3A8A;
    }

    .stat-card.card-sections {
        border-left-color: #3B82F6;
    }

    .stat-card.card-leaves {
        border-left-color: #1E3A8A;
    }

    .stat-card.card-attendance {
        border-left-color: #3B82F6;
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .stat-card-icon {
        font-size: 32px;
        opacity: 0.8;
    }

    .stat-card-title {
        font-size: 14px;
        color: #1F2937;
        margin: 0;
        font-weight: 500;
    }

    .stat-card-value {
        font-size: 36px;
        font-weight: bold;
        color: #1F2937;
        margin: 10px 0;
        min-height: 45px;
        display: flex;
        align-items: center;
    }

    .stat-card-empty {
        font-size: 16px;
        color: #9ca3af;
        font-weight: normal;
        font-style: italic;
    }

    .stat-card-footer {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Secondary Stats Row */
    .secondary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .secondary-stat {
        background: #f9fafb;
        padding: 15px;
        border-radius: 8px;
        border-right: 3px solid;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .secondary-stat.stat-absent {
        border-right-color: #1E3A8A;
    }

    .secondary-stat.stat-late {
        border-right-color: #3B82F6;
    }

    .secondary-stat.stat-approved {
        border-right-color: #1E3A8A;
    }

    .secondary-stat.stat-rejected {
        border-right-color: #3B82F6;
    }

    .secondary-stat-label {
        font-size: 13px;
        color: #1F2937;
    }

    .secondary-stat-value {
        font-size: 24px;
        font-weight: bold;
        color: #1F2937;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 968px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    .content-box {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .content-box-title {
        font-size: 18px;
        font-weight: 600;
        color: #1F2937;
        margin: 0 0 20px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 15px;
        border-bottom: 2px solid #E5E7EB;
    }

    .recent-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .recent-item {
        padding: 12px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.2s;
    }

    .recent-item:hover {
        background: #f9fafb;
    }

    .recent-item:last-child {
        border-bottom: none;
    }

    .recent-item-info {
        flex: 1;
    }

    .recent-item-name {
        font-weight: 500;
        color: #111827;
        margin-bottom: 4px;
    }

    .recent-item-meta {
        font-size: 12px;
        color: #6b7280;
    }

    .recent-item-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-pending {
        background: #F8FAFC;
        color: #1F2937;
        border: 1px solid #E5E7EB;
    }

    .status-approved {
        background: #F8FAFC;
        color: #1F2937;
        border: 1px solid #E5E7EB;
    }

    .status-rejected {
        background: #F8FAFC;
        color: #1F2937;
        border: 1px solid #E5E7EB;
    }

    .status-present {
        background: #F8FAFC;
        color: #1F2937;
        border: 1px solid #E5E7EB;
    }

    /* Charts Section */
    .charts-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .chart-container canvas {
        max-height: 300px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .empty-state-text {
        font-size: 14px;
    }

    .content-wrapper {
        background: transparent !important;
        box-shadow: none !important;
        padding: 0 !important;
    }

    /* Recent Activities Scroll */
    .recent-list {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    .recent-list::-webkit-scrollbar {
        width: 6px;
    }

    .recent-list::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .recent-list::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .recent-list::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Loading Skeleton */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }
</style>
@endsection

@section('content')

<!-- Dashboard Header -->
<div class="dashboard-header">
    <div class="greeting">
        <h1>مرحباً، {{ $user->name }}</h1>
        <span class="date"> {{ now()->locale('ar')->translatedFormat('l، d F Y') }}</span>
    </div>
    <div class="actions">
        <a href="{{ route('reports.index') }}" class="header-btn">
             تصدير تقرير
        </a>
        <button onclick="location.reload()" class="header-btn">
             تحديث البيانات
        </button>
    </div>
</div>

<!-- Main Stats Cards -->
<div class="cards">
    <a href="{{ route('employees.index') }}" class="stat-card card-employees" style="text-decoration: none; color: inherit;">
        <div class="stat-card-header">
            <h3 class="stat-card-title"> عدد الموظفين</h3>
            <span class="stat-card-icon"></span>
        </div>
        <div class="stat-card-value">
            @if($totalEmployees > 0)
                <span class="counter" data-target="{{ $totalEmployees }}">0</span>
            @else
                <span class="stat-card-empty">لا توجد بيانات</span>
            @endif
        </div>
        <div class="stat-card-footer">
            <span> تم التحديث: {{ now()->format('H:i') }}</span>
        </div>
    </a>

    <a href="{{ route('sections.index') }}" class="stat-card card-sections" style="text-decoration: none; color: inherit;">
        <div class="stat-card-header">
            <h3 class="stat-card-title"> الأقسام</h3>
            <span class="stat-card-icon"></span>
        </div>
        <div class="stat-card-value">
            @if($totalSections > 0)
                <span class="counter" data-target="{{ $totalSections }}">0</span>
            @else
                <span class="stat-card-empty">لا توجد بيانات</span>
            @endif
        </div>
        <div class="stat-card-footer">
            <span>⏱️ تم التحديث: {{ now()->format('H:i') }}</span>
        </div>
    </a>

    <a href="{{ route('leaves.index') }}" class="stat-card card-leaves" style="text-decoration: none; color: inherit;">
        <div class="stat-card-header">
            <h3 class="stat-card-title"> طلبات الإجازة</h3>
        </div>
        <div class="stat-card-value">
            @if($totalLeaves > 0)
                <span class="counter" data-target="{{ $totalLeaves }}">0</span>
            @else
                <span class="stat-card-empty">لا توجد طلبات معلقة</span>
            @endif
        </div>
        <div class="stat-card-footer">
            <span> تم التحديث: {{ now()->format('H:i') }}</span>
        </div>
    </a>

    <a href="{{ route('attendances.index') }}" class="stat-card card-attendance" style="text-decoration: none; color: inherit;">
        <div class="stat-card-header">
            <h3 class="stat-card-title"> الحضور اليوم</h3>
        </div>
        <div class="stat-card-value">
            @if($todayAttendance > 0)
                <span class="counter" data-target="{{ $todayAttendance }}">0</span>
            @else
                <span class="stat-card-empty">لا يوجد تسجيل حضور بعد</span>
            @endif
        </div>
        <div class="stat-card-footer">
            <span> تم التحديث: {{ now()->format('H:i') }}</span>
        </div>
    </a>
</div>

<!-- Secondary Stats -->
<div class="secondary-stats">
    <div class="secondary-stat stat-absent">
        <div>
            <div class="secondary-stat-label"> الغائبين اليوم</div>
            <div class="secondary-stat-value">{{ $todayAbsent }}</div>
        </div>
    </div>
    <div class="secondary-stat stat-late">
        <div>
            <div class="secondary-stat-label"> المتأخرين اليوم</div>
            <div class="secondary-stat-value">{{ $todayLate }}</div>
        </div>
    </div>
    <div class="secondary-stat stat-approved">
        <div>
            <div class="secondary-stat-label"> الإجازات الموافقة</div>
            <div class="secondary-stat-value">{{ $approvedLeaves }}</div>
        </div>
    </div>
    <div class="secondary-stat stat-rejected">
        <div>
            <div class="secondary-stat-label"> الإجازات المرفوضة</div>
            <div class="secondary-stat-value">{{ $rejectedLeaves }}</div>
        </div>
    </div>
</div>

<!-- Content Grid: Recent Activities -->
<div class="content-grid">
    <!-- Recent Leaves -->
    <div class="content-box">
        <h2 class="content-box-title"> آخر طلبات الإجازة</h2>
        @if($recentLeaves->count() > 0)
            <ul class="recent-list">
                @foreach($recentLeaves as $leave)
                    <li class="recent-item">
                        <div class="recent-item-info">
                            <div class="recent-item-name">{{ $leave->employee_name }}</div>
                            <div class="recent-item-meta">
                                {{ $leave->leave_type }} • 
                                {{ $leave->start_date ? $leave->start_date->format('Y-m-d') : '-' }}
                            </div>
                        </div>
                        <span class="recent-item-status status-{{ $leave->status }}">
                            @if($leave->status == 'pending')
                                قيد الانتظار
                            @elseif($leave->status == 'approved')
                                موافق عليه
                            @else
                                مرفوض
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty-state">
                <div class="empty-state-text">لا توجد طلبات إجازة حديثة</div>
            </div>
        @endif
    </div>

    <!-- Recent Attendances -->
    <div class="content-box">
        <h2 class="content-box-title"> آخر تسجيلات الحضور</h2>
        @if($recentAttendances->count() > 0)
            <ul class="recent-list">
                @foreach($recentAttendances as $attendance)
                    <li class="recent-item">
                        <div class="recent-item-info">
                            <div class="recent-item-name">{{ $attendance->employee->name ?? 'غير معروف' }}</div>
                            <div class="recent-item-meta">
                                {{ $attendance->date ? $attendance->date->format('Y-m-d') : '-' }} • 
                                {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}
                            </div>
                        </div>
                        <span class="recent-item-status status-{{ $attendance->status }}">
                            @if($attendance->status == 'present')
                                حاضر
                            @elseif($attendance->status == 'absent')
                                غائب
                            @elseif($attendance->status == 'late')
                                متأخر
                            @else
                                نصف يوم
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty-state">
                <div class="empty-state-text">لا توجد تسجيلات حضور حديثة</div>
            </div>
        @endif
    </div>
</div>

<!-- All Recent Activities Section -->
@if(isset($recentActivities) && $recentActivities->count() > 0)
<div class="content-box" style="margin-bottom: 30px;">
    <h2 class="content-box-title"> جميع الأنشطة الأخيرة</h2>
    <div style="max-height: 600px; overflow-y: auto;">
        <ul class="recent-list">
            @foreach($recentActivities as $activity)
                <li class="recent-item">
                    <div class="recent-item-info" style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">{{ $activity['icon'] }}</span>
                        <div style="flex: 1;">
                            <div class="recent-item-name" style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 11px; background: #f3f4f6; padding: 2px 8px; border-radius: 4px; color: #6b7280;">
                                    {{ $activity['type_label'] }}
                                </span>
                                <a href="{{ $activity['route'] }}" style="text-decoration: none; color: inherit; font-weight: 500;">
                                    {{ $activity['title'] }}
                                </a>
                            </div>
                            <div class="recent-item-meta">
                                {{ $activity['subtitle'] }} • 
                                <span style="color: #9ca3af;">
                                    {{ $activity['created_at']->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<!-- Charts Section -->
<div class="charts-section">
    <!-- Weekly Attendance Chart -->
    <div class="chart-container">
        <h2 class="content-box-title"> حضور الأسبوع</h2>
        <canvas id="weeklyAttendanceChart"></canvas>
    </div>

    <!-- Monthly Absence Chart -->
    <div class="chart-container">
        <h2 class="content-box-title"> الغياب الشهري</h2>
        <canvas id="monthlyAbsenceChart"></canvas>
    </div>

    <!-- Employees by Section Chart -->
    @if(count($employeesBySection) > 0)
    <div class="chart-container">
        <h2 class="content-box-title"> توزيع الموظفين حسب الأقسام</h2>
        <canvas id="employeesBySectionChart"></canvas>
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        if (target > 0) {
            let current = 0;
            const increment = target / 50;
            
            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    counter.innerText = Math.ceil(current);
                    setTimeout(updateCounter, 20);
                } else {
                    counter.innerText = target;
                }
            };
            
            updateCounter();
        }
    });

    // Weekly Attendance Chart
    const weeklyCtx = document.getElementById('weeklyAttendanceChart');
    if (weeklyCtx) {
        const weeklyData = @json($weeklyAttendance ?? []);
        const hasData = weeklyData && weeklyData.length > 0;
        
        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: hasData ? weeklyData.map(d => d.day) : ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'],
                datasets: [{
                    label: 'عدد الحضور',
                    data: hasData ? weeklyData.map(d => d.count) : [0, 0, 0, 0, 0, 0, 0],
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Monthly Absence Chart
    const monthlyCtx = document.getElementById('monthlyAbsenceChart');
    if (monthlyCtx) {
        const monthlyData = @json($monthlyAbsence ?? []);
        const hasData = monthlyData && monthlyData.length > 0;
        
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: hasData ? monthlyData.map(d => d.week) : ['أسبوع 1', 'أسبوع 2', 'أسبوع 3', 'أسبوع 4'],
                datasets: [{
                    label: 'عدد الغياب',
                    data: hasData ? monthlyData.map(d => d.count) : [0, 0, 0, 0],
                    backgroundColor: '#ef4444',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Employees by Section Chart
    @if(count($employeesBySection) > 0)
    const sectionCtx = document.getElementById('employeesBySectionChart');
    if (sectionCtx) {
        const sectionData = @json($employeesBySection);
        const colors = [
            '#4f46e5', '#7c3aed', '#06b6d4', '#10b981', 
            '#f59e0b', '#ef4444', '#6366f1', '#14b8a6'
        ];
        
        new Chart(sectionCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(sectionData),
                datasets: [{
                    data: Object.values(sectionData),
                    backgroundColor: colors.slice(0, Object.keys(sectionData).length)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    @endif
</script>
@endsection
