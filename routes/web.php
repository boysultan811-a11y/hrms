<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisciplinaryActionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeRequestController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OffboardingController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PerformanceReviewController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Route;

// Redirect root URL to login page
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::patch('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::patch('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
});

Route::middleware('auth')->group(function () {
    Route::resource('sections', SectionController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('payrolls', PayrollController::class);
    Route::resource('benefits', BenefitController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('shifts', ShiftController::class);
    Route::resource('employee-requests', EmployeeRequestController::class);
    Route::resource('disciplinary-actions', DisciplinaryActionController::class);
    Route::resource('offboardings', OffboardingController::class);
    Route::resource('recruitments', RecruitmentController::class);
    Route::resource('onboardings', OnboardingController::class);
    Route::resource('performance-reviews', PerformanceReviewController::class);
    Route::resource('trainings', TrainingController::class);
    Route::resource('contracts', ContractController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('reports', ReportController::class);
    Route::get('reports/{report}/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
});
