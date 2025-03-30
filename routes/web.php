<?php

use App\Http\Controllers\DayController;
use App\Http\Controllers\DeliverableController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FortnightController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuarterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StrategyController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeekController;
use App\Http\Controllers\YearController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Dashboard Route
Route::get('/', [HomeController::class, 'index'])->middleware(['auth'])->name('index');

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/upload', [ProfileController::class, 'uploadProfileImage'])->name('profile.uploadProfileImage');
});

// Resource Routes
Route::middleware('auth')->group(function () {

    // Routes Accessible for SUPER_ADMIN, ADMIN
    Route::middleware('role:SUPER_ADMIN|ADMIN')->group(function () {
        Route::get('users/waiting-approval', [UserController::class, 'waitingApproval'])->name('users.waiting');

        // User Approval
        Route::patch('users/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::get('users/{user}/approve', [UserController::class, 'approved'])->name('users.approved');

        // KPI Approval & Confirmation
        Route::get('kpis/{kpi}/confirm', [KpiController::class, 'confirm'])->name('kpis.confirm');
        Route::get('tasks/{task}/confirm', [TaskController::class, 'confirm'])->name('tasks.confirm');

        // Resource Routes
        Route::resource('users', UserController::class)->only('create', 'store', 'edit', 'update', 'destroy');

        Route::resource('strategies', StrategyController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('targets', TargetController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('goals', GoalController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);

        Route::resource('years', YearController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('quarters', QuarterController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('days', DayController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);

        Route::resource('departments', DepartmentController::class);
    });

    // Routes Accessible for SUPER_ADMIN, ADMIN, DEPARTMENT_HEAD
    Route::middleware('role:SUPER_ADMIN|ADMIN|DEPARTMENT_HEAD')->group(function () {
        Route::resource('users', UserController::class)->only('index', 'show');

        // KPI Approval & Confirmation
        Route::get('kpis/{kpi}/approve', [KpiController::class, 'approve'])->name('kpis.approve');
        Route::get('tasks/{task}/approve', [TaskController::class, 'approve'])->name('tasks.approve');

    });

    // Resource routes
    Route::resource('homes', HomeController::class);
    Route::resource('strategies', StrategyController::class)->only(['index', 'show']);
    Route::resource('targets', TargetController::class)->only(['index', 'show']);
    Route::resource('goals', GoalController::class)->only(['index', 'show']);

    Route::resource('years', YearController::class)->only(['index', 'show']);
    Route::resource('quarters', QuarterController::class)->only(['index', 'show']);
    Route::resource('days', DayController::class)->only(['index', 'show']);
    Route::resource('tasks', TaskController::class);
    Route::resource('deliverables', DeliverableController::class);
    Route::resource('fortnights', FortnightController::class);
    Route::resource('weeks', WeekController::class);
    Route::resource('feedback', FeedbackController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('templates', TemplateController::class);
    Route::resource('kpis', KpiController::class);

    Route::get('feedbacks/{taskId}', [FeedbackController::class, 'taskFeedbacks'])->name('taskFeedbacks');
    // KPI
    Route::get('kpis/create_target/{target}', [KpiController::class, 'create_target'])->name('kpis.create_target');
    Route::get('kpis/create_task/{task}', [KpiController::class, 'create_task'])->name('kpis.create_task');
    Route::put('/kpis/{kpi}/status', [KpiController::class, 'updateStatus'])->name('kpis.status');
    Route::get('/tasks/list/{status}', [TaskController::class, 'listByStatus'])->name('tasks.list');
    Route::put('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
    Route::put('/deliverables/{deliverable}/status', [DeliverableController::class, 'achieved'])->name('deliverables.status');
    Route::get('/printableReport', [UserController::class, 'printableReport']);
});

Route::get('/users/assign', [UserController::class, 'assign'])->name('users.assign');

require __DIR__.'/auth.php';
