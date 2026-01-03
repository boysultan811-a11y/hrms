    <!DOCTYPE html>
    <html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', 'HRMS Dashboard')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
            body {
                margin: 0;
                font-family: "Segoe UI", Tahoma, Arial, sans-serif;
                background: #F8FAFC;
            }

            /* السايد بار المنزلق */
            .sidebar {
                position: fixed;
                top: 0;
                right: -280px; /* مخفية في البداية */
                width: 280px;
                height: 100%;
                background: #1E3A8A;
                padding-top: 60px;
                transition: right 0.4s ease;
                z-index: 1000;
                box-shadow: -2px 0 10px rgba(0,0,0,0.3);
                overflow-y: auto;
            }

            /* عند فتح السايد بار */
            .sidebar.open {
                right: 0;
            }

            .sidebar h2 {
                text-align: center;
                margin-bottom: 30px;
                color: #fff;
                padding: 0 20px;
            }

            /* روابط السايد بار */
            .sidebar a {
                display: block;
                padding: 15px 20px;
                color: #cbd5e1;
                text-decoration: none;
                transition: background 0.3s;
                border-right: 3px solid transparent;
            }

            .sidebar a:hover {
                background-color: #3B82F6;
                color: white;
                border-right-color: #3B82F6;
            }

            .sidebar a.active {
                background-color: #3B82F6;
                border-right-color: #3B82F6;
                color: white;
            }

            /* Dropdown Menu */
            .dropdown {
                position: relative;
            }

            .dropdown-toggle {
                display: flex;
                justify-content: space-between;
                align-items: center;
                cursor: pointer;
            }

            .dropdown-toggle::after {
                content: '▼';
                font-size: 10px;
                transition: transform 0.3s;
                margin-right: 10px;
            }

            .dropdown-toggle.active::after {
                transform: rotate(180deg);
            }

            .dropdown-menu {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
                background-color: #1a1a1a;
            }

            .dropdown-menu.open {
                max-height: 500px;
            }

            .dropdown-menu a {
                padding-right: 40px;
                font-size: 14px;
                color: #cbd5e1;
            }

            .dropdown-menu a:hover {
                background-color: #2d2d2d;
                color: white;
            }

            .dropdown-menu a.active {
                background-color: #3B82F6;
                border-right-color: #3B82F6;
                color: white;
            }

            /* زر الفتح/الإغلاق */
            .toggle-btn {
                position: fixed;
                top: 15px;
                right: 15px;
                font-size: 15px;
                cursor: pointer;
                background: #1E3A8A;
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 8px;
                z-index: 1001;
                transition: background 0.3s;
                box-shadow: 0 2px 10px rgba(30, 58, 138, 0.3);
            }

            .toggle-btn:hover {
                background: #3B82F6;
            }

            /* overlay عند فتح السايد بار */
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: none;
                z-index: 999;
            }

            .overlay.show {
                display: block;
            }

            /* Main Content */
            .main {
                padding: 20px;
                min-height: 100vh;
            }

            .topbar {
                background: #ffffff;
                padding: 15px 20px;
                border-radius: 8px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                margin-top: 60px; /* مساحة لزر القائمة */
                border: 1px solid #E5E7EB;
            }

            .content-wrapper {
                background: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                border: 1px solid #E5E7EB;
            }

            .logout-btn {
                background: #1E3A8A;
                color: #fff;
                border: none;
                padding: 8px 14px;
                border-radius: 5px;
                cursor: pointer;
                transition: background 0.3s;
            }

            .logout-btn:hover {
                background: #3B82F6;
            }

            /* Buttons */
            .btn {
                padding: 8px 16px;
                border-radius: 6px;
                text-decoration: none;
                color: #fff;
                display: inline-block;
                border: none;
                cursor: pointer;
                transition: all 0.3s;
            }

            .btn-add, .btn-primary {
                background: #1E3A8A;
            }

            .btn-add:hover, .btn-primary:hover {
                background: #3B82F6;
            }

            .btn-edit, .btn-warning {
                background: #3B82F6;
            }

            .btn-edit:hover, .btn-warning:hover {
                background: #1E3A8A;
            }

            .btn-delete, .btn-danger {
                background: #1E3A8A;
            }

            .btn-delete:hover, .btn-danger:hover {
                background: #3B82F6;
            }

            .btn-sm {
                padding: 5px 10px;
                font-size: 14px;
            }

            /* Tables */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }

            th, td {
                padding: 12px;
                border-bottom: 1px solid #E5E7EB;
                text-align: right;
            }

            th {
                background: #f9fafb;
                font-weight: 600;
                color: #1F2937;
            }

            tbody tr:hover {
                background: #F8FAFC;
            }

            /* Alerts */
            .success, .alert-success {
                background: #F8FAFC;
                color: #1F2937;
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 15px;
                border-left: 4px solid #1E3A8A;
            }

            .alert {
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 15px;
            }

            /* Headings */
            h1, h2, h3 {
                color: #1F2937;
                margin-top: 0;
            }

            /* Container */
            .container {
                max-width: 100%;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .topbar {
                    flex-direction: column;
                    gap: 10px;
                }
            }
        </style>
        @yield('styles')
    </head>
    <body>

    <!-- زر فتح/إغلاق القائمة -->
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2>HRMS</h2>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"> لوحة التحكم</a>
        
        <h3 style="color: #cbd5e1; font-size: 12px; padding: 10px 20px; margin: 10px 0 5px; text-transform: uppercase;">الأقسام الأساسية</h3>
        <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}"> الموظفين</a>
        <a href="{{ route('attendances.index') }}" class="{{ request()->routeIs('attendances.*') ? 'active' : '' }}"> الحضور والانصراف</a>
        <a href="{{ route('leaves.index') }}" class="{{ request()->routeIs('leaves.*') ? 'active' : '' }}"> الإجازات</a>
        <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}"> الصلاحيات والمستخدمين</a>
        
        <h3 style="color: #9ca3af; font-size: 12px; padding: 10px 20px; margin: 10px 0 5px; text-transform: uppercase;">المالية والإدارية</h3>
        <a href="{{ route('payrolls.index') }}" class="{{ request()->routeIs('payrolls.*') ? 'active' : '' }}"> الرواتب والأجور</a>
        <a href="{{ route('benefits.index') }}" class="{{ request()->routeIs('benefits.*') ? 'active' : '' }}"> المزايا والتعويضات</a>
        
        <h3 style="color: #9ca3af; font-size: 12px; padding: 10px 20px; margin: 10px 0 5px; text-transform: uppercase;">الإدارة</h3>
        <a href="{{ route('sections.index') }}" class="{{ request()->routeIs('sections.*') ? 'active' : '' }}"> الأقسام</a>
        <a href="{{ route('shifts.index') }}" class="{{ request()->routeIs('shifts.*') ? 'active' : '' }}"> إدارة الشفتات</a>
        
        <h3 style="color: #9ca3af; font-size: 12px; padding: 10px 20px; margin: 10px 0 5px; text-transform: uppercase;">شؤون الموظفين</h3>
        <a href="{{ route('employee-requests.index') }}" class="{{ request()->routeIs('employee-requests.*') ? 'active' : '' }}"> طلبات الموظفين</a>
        <a href="{{ route('disciplinary-actions.index') }}" class="{{ request()->routeIs('disciplinary-actions.*') ? 'active' : '' }}"> الإنذارات والعقوبات</a>
        <a href="{{ route('offboardings.index') }}" class="{{ request()->routeIs('offboardings.*') ? 'active' : '' }}"> الاستقالات وإنهاء الخدمة</a>
        
        <h3 style="color: #9ca3af; font-size: 12px; padding: 10px 20px; margin: 10px 0 5px; text-transform: uppercase;">التوظيف والتطوير</h3>
        <a href="{{ route('recruitments.index') }}" class="{{ request()->routeIs('recruitments.*') ? 'active' : '' }}"> التوظيف والاستقطاب</a>
        <a href="{{ route('onboardings.index') }}" class="{{ request()->routeIs('onboardings.*') ? 'active' : '' }}"> تهيئة الموظفين الجدد</a>
        <a href="{{ route('performance-reviews.index') }}" class="{{ request()->routeIs('performance-reviews.*') ? 'active' : '' }}"> تقييم الأداء</a>
        <a href="{{ route('trainings.index') }}" class="{{ request()->routeIs('trainings.*') ? 'active' : '' }}"> التدريب والتطوير</a>
        
        <h3 style="color: #9ca3af; font-size: 12px; padding: 10px 20px; margin: 10px 0 5px; text-transform: uppercase;">إضافية</h3>
        <a href="{{ route('contracts.index') }}" class="{{ request()->routeIs('contracts.*') ? 'active' : '' }}"> إدارة العقود</a>
        <a href="{{ route('documents.index') }}" class="{{ request()->routeIs('documents.*') ? 'active' : '' }}"> إدارة الوثائق</a>
        
        <h3 style="color: #9ca3af; font-size: 12px; padding: 10px 20px; margin: 10px 0 5px; text-transform: uppercase;">التحليل والتقارير</h3>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle {{ request()->routeIs('reports.*') ? 'active' : '' }}" onclick="toggleDropdown(event, this)">
                التقارير والتحليلات
            </a>
            <div class="dropdown-menu {{ request()->routeIs('reports.*') ? 'open' : '' }}" id="reportsDropdown">
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.index') ? 'active' : '' }}"> جميع التقارير</a>
                <a href="{{ route('attendances.index') }}" class="{{ request()->routeIs('attendances.*') ? 'active' : '' }}"> كشف دوام موظف</a>
                <a href="{{ route('leaves.index') }}" class="{{ request()->routeIs('leaves.*') ? 'active' : '' }}"> كشف إجازات موظف</a>
                <a href="{{ route('attendances.index') }}?type=absences" class=""> كشف غيابات موظف</a>
            </div>
        </div>
        
        
        <h3 style="color: #9ca3af; font-size: 12px; padding: 10px 20px; margin: 10px 0 5px; text-transform: uppercase;">أخرى</h3>
        <a href="#"> الإعدادات</a>
    </div>

    <!-- Main -->
    <div class="main">
        <div class="topbar">
            <div>
                مرحباً  {{ auth()->user()->name }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn">تسجيل الخروج</button>
            </form>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        // إغلاق السايد بار عند الضغط على مفتاح ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('overlay');
                
                if (sidebar.classList.contains('open')) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('show');
                }
            }
        });

        // التحكم في القائمة المنسدلة
        function toggleDropdown(event, element) {
            event.preventDefault();
            const dropdown = element.nextElementSibling;
            
            // إغلاق جميع القوائم المنسدلة الأخرى
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu !== dropdown) {
                    menu.classList.remove('open');
                }
            });
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                if (toggle !== element) {
                    toggle.classList.remove('active');
                }
            });
            
            // فتح/إغلاق القائمة الحالية
            dropdown.classList.toggle('open');
            element.classList.toggle('active');
        }

        // فتح القائمة المنسدلة تلقائياً إذا كانت الصفحة الحالية ضمنها
        document.addEventListener('DOMContentLoaded', function() {
            const activeLink = document.querySelector('.dropdown-menu a.active');
            if (activeLink) {
                const dropdown = activeLink.closest('.dropdown-menu');
                const toggle = activeLink.closest('.dropdown').querySelector('.dropdown-toggle');
                if (dropdown && toggle) {
                    dropdown.classList.add('open');
                    toggle.classList.add('active');
                }
            }
        });
    </script>

    @yield('scripts')

    </body>
    </html>
