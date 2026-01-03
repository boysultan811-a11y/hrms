<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Benefit;
use App\Models\Contract;
use App\Models\DisciplinaryAction;
use App\Models\Document;
use App\Models\Employee;
use App\Models\EmployeeRequest;
use App\Models\Leave;
use App\Models\Offboarding;
use App\Models\Onboarding;
use App\Models\Payroll;
use App\Models\PerformanceReview;
use App\Models\Recruitment;
use App\Models\Report;
use App\Models\Role;
use App\Models\Section;
use App\Models\Shift;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $user = Auth::user();
        $today = Carbon::today();

        // تحديد الصلاحيات (يمكن تطويرها لاحقاً مع Role model)
        $userRole = $this->getUserRole($user);
        $hasFullAccess = $this->hasFullAccess($userRole);
        $hasHRAccess = $this->hasHRAccess($userRole);
        $isManager = $this->isManager($userRole);

        // السماح لجميع المستخدمين برؤية البيانات (يمكن تقييدها لاحقاً)
        $canViewData = true; // $hasFullAccess || $hasHRAccess || $isManager;

        // الإحصائيات الأساسية
        $totalEmployees = $canViewData ? Employee::count() : 0;
        $totalSections = $canViewData ? Section::count() : 0;
        $totalLeaves = $canViewData ? Leave::where('status', 'pending')->count() : 0;
        $todayAttendance = $canViewData ? Attendance::whereDate('date', $today)->where('status', 'present')->count() : 0;

        // إحصائيات إضافية
        $todayAbsent = $canViewData ? Attendance::whereDate('date', $today)->where('status', 'absent')->count() : 0;
        $todayLate = $canViewData ? Attendance::whereDate('date', $today)->where('status', 'late')->count() : 0;
        $approvedLeaves = $canViewData ? Leave::where('status', 'approved')->count() : 0;
        $rejectedLeaves = $canViewData ? Leave::where('status', 'rejected')->count() : 0;

        // آخر العمليات
        $recentLeaves = $canViewData ? Leave::latest()->limit(5)->get() : collect();
        $recentAttendances = $canViewData ? Attendance::with('employee')->latest()->limit(5)->get() : collect();

        // جميع الأنشطة الأخيرة من جميع النماذج
        $recentActivities = $this->getRecentActivities($hasFullAccess, $hasHRAccess, $isManager);

        // بيانات الرسوم البيانية (حضور الأسبوع)
        $weeklyAttendance = $canViewData ? $this->getWeeklyAttendanceData($user, $hasFullAccess, $isManager) : [];

        // بيانات الرسم البياني (الغياب الشهري)
        $monthlyAbsence = $canViewData ? $this->getMonthlyAbsenceData($user, $hasFullAccess, $isManager) : [];

        // توزيع الموظفين حسب الأقسام
        $employeesBySection = $canViewData ? $this->getEmployeesBySectionData() : [];

        return view('dashboard.index', compact(
            'user',
            'userRole',
            'hasFullAccess',
            'hasHRAccess',
            'isManager',
            'totalEmployees',
            'totalSections',
            'totalLeaves',
            'todayAttendance',
            'todayAbsent',
            'todayLate',
            'approvedLeaves',
            'rejectedLeaves',
            'recentLeaves',
            'recentAttendances',
            'recentActivities',
            'weeklyAttendance',
            'monthlyAbsence',
            'employeesBySection'
        ));
    }

    private function getUserRole($user): string
    {
        // يمكن تطويرها لاحقاً للتحقق من Role model
        // حالياً، سنستخدم اسم المستخدم أو email للتحقق
        $adminEmails = ['admin@hrms.com', 'admin@example.com'];

        if (in_array($user->email ?? '', $adminEmails)) {
            return 'admin';
        }

        // يمكن إضافة المزيد من المنطق هنا
        return 'user'; // افتراضياً user
    }

    private function hasFullAccess(string $role): bool
    {
        return $role === 'admin';
    }

    private function hasHRAccess(string $role): bool
    {
        return in_array($role, ['admin', 'hr']);
    }

    private function isManager(string $role): bool
    {
        return $role === 'manager';
    }

    private function getTeamEmployeeCount($user): int
    {
        // يمكن تطويرها لاحقاً عند إضافة علاقة Manager-Employee
        return 0;
    }

    private function getTeamPendingLeavesCount($user): int
    {
        // يمكن تطويرها لاحقاً
        return 0;
    }

    private function getTeamTodayAttendance($user, $today): int
    {
        // يمكن تطويرها لاحقاً
        return 0;
    }

    private function getTeamRecentLeaves($user, $limit)
    {
        // يمكن تطويرها لاحقاً
        return collect();
    }

    private function getTeamRecentAttendances($user, $limit)
    {
        // يمكن تطويرها لاحقاً
        return collect();
    }

    private function getWeeklyAttendanceData($user, bool $hasFullAccess, bool $isManager): array
    {
        $data = [];
        $startOfWeek = Carbon::now()->startOfWeek();

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $query = Attendance::whereDate('date', $date)->where('status', 'present');

            // تطبيق فلتر الصلاحيات هنا لاحقاً
            // if ($isManager && !$hasFullAccess) {
            //     $query = $query->whereHas('employee', function($q) use ($user) {
            //         // فلتر حسب الفريق
            //     });
            // }

            $data[] = [
                'day' => $date->locale('ar')->translatedFormat('l'),
                'date' => $date->format('Y-m-d'),
                'count' => $query->count(),
            ];
        }

        return $data;
    }

    private function getMonthlyAbsenceData($user, bool $hasFullAccess, bool $isManager): array
    {
        $data = [];
        $startOfMonth = Carbon::now()->startOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;

        // تقسيم الشهر إلى 4 أسابيع تقريباً
        $weekSize = ceil($daysInMonth / 4);

        for ($i = 0; $i < 4; $i++) {
            $startDate = $startOfMonth->copy()->addDays($i * $weekSize);
            $endDate = $startDate->copy()->addDays($weekSize - 1);
            if ($endDate->gt(Carbon::now()->endOfMonth())) {
                $endDate = Carbon::now()->endOfMonth();
            }

            $query = Attendance::whereBetween('date', [$startDate, $endDate])
                ->where('status', 'absent');

            // تطبيق فلتر الصلاحيات هنا لاحقاً

            $data[] = [
                'week' => 'أسبوع '.($i + 1),
                'count' => $query->count(),
            ];
        }

        return $data;
    }

    private function getEmployeesBySectionData(): array
    {
        // إذا كان هناك علاقة بين Employee و Section
        // هنا سنستخدم position كبديل مؤقت
        $employees = Employee::select('position')
            ->whereNotNull('position')
            ->get()
            ->groupBy('position')
            ->map(fn ($group) => $group->count())
            ->toArray();

        return $employees;
    }

    private function getRecentActivities(bool $hasFullAccess, bool $hasHRAccess, bool $isManager): Collection
    {
        $activities = collect();
        $limit = 10; // عدد الأنشطة الأخيرة من كل نوع

        // السماح لجميع المستخدمين برؤية الأنشطة
        $canViewActivities = true; // $hasFullAccess || $hasHRAccess;

        if ($canViewActivities) {
            // الموظفين
            Employee::latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'employee',
                    'type_label' => 'موظف',
                    'title' => $item->name,
                    'subtitle' => $item->position ?? 'غير محدد',
                    'created_at' => $item->created_at,
                    'route' => route('employees.edit', $item->id),
                    'icon' => '👤',
                ]);
            });

            // الأقسام
            Section::latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'section',
                    'type_label' => 'قسم',
                    'title' => $item->name ?? 'قسم جديد',
                    'subtitle' => $item->description ?? '',
                    'created_at' => $item->created_at,
                    'route' => route('sections.edit', $item->id),
                    'icon' => '🏢',
                ]);
            });

            // الأدوار
            Role::latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'role',
                    'type_label' => 'دور',
                    'title' => $item->name ?? 'دور جديد',
                    'subtitle' => $item->description ?? '',
                    'created_at' => $item->created_at,
                    'route' => route('roles.edit', $item->id),
                    'icon' => '🎭',
                ]);
            });

            // التحويلات
            Shift::latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'shift',
                    'type_label' => 'تحويل',
                    'title' => $item->name ?? 'تحويل جديد',
                    'subtitle' => ($item->start_time ?? '').' - '.($item->end_time ?? ''),
                    'created_at' => $item->created_at,
                    'route' => route('shifts.edit', $item->id),
                    'icon' => '⏰',
                ]);
            });

            // طلبات الموظفين
            EmployeeRequest::with('employee')->latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'employee_request',
                    'type_label' => 'طلب موظف',
                    'title' => $item->employee?->name ?? 'طلب جديد',
                    'subtitle' => ($item->request_type ?? 'طلب').' - '.($item->status ?? 'قيد الانتظار'),
                    'created_at' => $item->created_at,
                    'route' => route('employee-requests.edit', $item->id),
                    'icon' => '📋',
                ]);
            });

            // الإجراءات التأديبية
            DisciplinaryAction::with('employee')->latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'disciplinary_action',
                    'type_label' => 'إجراء تأديبي',
                    'title' => $item->employee?->name ?? 'إجراء جديد',
                    'subtitle' => $item->violation_type ?? 'نوع غير محدد',
                    'created_at' => $item->created_at,
                    'route' => route('disciplinary-actions.edit', $item->id),
                    'icon' => '⚠️',
                ]);
            });

            // إنهاء الخدمة
            Offboarding::with('employee')->latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'offboarding',
                    'type_label' => 'إنهاء خدمة',
                    'title' => $item->employee?->name ?? 'إنهاء خدمة جديد',
                    'subtitle' => $item->last_work_day ? $item->last_work_day->format('Y-m-d') : '',
                    'created_at' => $item->created_at,
                    'route' => route('offboardings.edit', $item->id),
                    'icon' => '👋',
                ]);
            });

            // التوظيف
            Recruitment::latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'recruitment',
                    'type_label' => 'توظيف',
                    'title' => $item->job_title ?? 'وظيفة جديدة',
                    'subtitle' => $item->department ?? 'قسم غير محدد',
                    'created_at' => $item->created_at,
                    'route' => route('recruitments.edit', $item->id),
                    'icon' => '💼',
                ]);
            });

            // التعيين
            Onboarding::with('employee')->latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'onboarding',
                    'type_label' => 'تعيين',
                    'title' => $item->employee?->name ?? 'تعيين جديد',
                    'subtitle' => $item->start_date ? $item->start_date->format('Y-m-d') : '',
                    'created_at' => $item->created_at,
                    'route' => route('onboardings.edit', $item->id),
                    'icon' => '🎯',
                ]);
            });

            // التقييمات
            PerformanceReview::with('employee')->latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'performance_review',
                    'type_label' => 'تقييم أداء',
                    'title' => $item->employee?->name ?? 'تقييم جديد',
                    'subtitle' => $item->review_date ? $item->review_date->format('Y-m-d') : '',
                    'created_at' => $item->created_at,
                    'route' => route('performance-reviews.edit', $item->id),
                    'icon' => '⭐',
                ]);
            });

            // التدريبات
            Training::latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'training',
                    'type_label' => 'تدريب',
                    'title' => $item->title ?? 'تدريب جديد',
                    'subtitle' => $item->instructor ?? 'مدرب غير محدد',
                    'created_at' => $item->created_at,
                    'route' => route('trainings.edit', $item->id),
                    'icon' => '📚',
                ]);
            });

            // العقود
            Contract::with('employee')->latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'contract',
                    'type_label' => 'عقد',
                    'title' => $item->employee?->name ?? 'عقد جديد',
                    'subtitle' => ($item->contract_type ?? 'نوع غير محدد').' - '.($item->start_date ? $item->start_date->format('Y-m-d') : ''),
                    'created_at' => $item->created_at,
                    'route' => route('contracts.edit', $item->id),
                    'icon' => '📄',
                ]);
            });

            // المستندات
            Document::with('employee')->latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'document',
                    'type_label' => 'مستند',
                    'title' => $item->name ?? 'مستند جديد',
                    'subtitle' => $item->employee?->name ?? 'موظف غير محدد',
                    'created_at' => $item->created_at,
                    'route' => route('documents.edit', $item->id),
                    'icon' => '📎',
                ]);
            });

            // المزايا
            Benefit::with('employee')->latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'benefit',
                    'type_label' => 'ميزة',
                    'title' => $item->employee?->name ?? 'ميزة جديدة',
                    'subtitle' => ($item->name ?? 'ميزة').' - '.($item->amount ?? '0'),
                    'created_at' => $item->created_at,
                    'route' => route('benefits.edit', $item->id),
                    'icon' => '🎁',
                ]);
            });

            // الرواتب
            Payroll::with('employee')->latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'payroll',
                    'type_label' => 'رواتب',
                    'title' => $item->employee?->name ?? 'راتب جديد',
                    'subtitle' => $item->payroll_date ? $item->payroll_date->format('Y-m-d') : '',
                    'created_at' => $item->created_at,
                    'route' => route('payrolls.edit', $item->id),
                    'icon' => '💰',
                ]);
            });

            // التقارير
            Report::latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'report',
                    'type_label' => 'تقرير',
                    'title' => $item->title ?? 'تقرير جديد',
                    'subtitle' => $item->type ?? 'نوع غير محدد',
                    'created_at' => $item->created_at,
                    'route' => route('reports.edit', $item->id),
                    'icon' => '📊',
                ]);
            });

            // الإجازات
            Leave::latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'leave',
                    'type_label' => 'إجازة',
                    'title' => $item->employee_name ?? 'إجازة جديدة',
                    'subtitle' => $item->leave_type ?? 'نوع غير محدد',
                    'created_at' => $item->created_at,
                    'route' => route('leaves.index'),
                    'icon' => '🏖️',
                ]);
            });

            // الحضور
            Attendance::with('employee')->latest()->limit($limit)->get()->each(function ($item) use ($activities) {
                $activities->push([
                    'type' => 'attendance',
                    'type_label' => 'حضور',
                    'title' => $item->employee?->name ?? 'تسجيل حضور',
                    'subtitle' => $item->date ? $item->date->format('Y-m-d') : '',
                    'created_at' => $item->created_at,
                    'route' => route('attendances.edit', $item->id),
                    'icon' => '✅',
                ]);
            });
        }

        // ترتيب حسب تاريخ الإنشاء (الأحدث أولاً)
        return $activities->sortByDesc('created_at')->take(30);
    }
}
