<?php

use App\Http\Controllers\ProfileController;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StrategyController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\DeliverableController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\QuarterController;
use App\Http\Controllers\FortnightController;
use App\Http\Controllers\WeekController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Middleware\IsApprovedMiddleware;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Dashboard Route
Route::get('/', [HomeController::class, 'index'])->middleware(['auth'])->name('index');

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Resource Routes
Route::middleware('auth')->group(function () {

    //The way to assign specific roles to users
    Route::middleware('role:SUPER_ADMIN|ADMIN')->group(function () {
        Route::get('users/waiting-approval', [UserController::class, 'waitingApproval'])->name('users.waiting');
        Route::patch('users/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::resource('users', UserController::class);
    });

    Route::resource('homes', HomeController::class);
    Route::resource('strategies', StrategyController::class);
    Route::resource('targets', TargetController::class);
    Route::resource('goals', GoalController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('deliverables', DeliverableController::class);
    Route::resource('years', YearController::class);
    Route::resource('quarters', QuarterController::class);
    Route::resource('fortnights', FortnightController::class);
    Route::resource('weeks', WeekController::class);
    Route::resource('days', DayController::class);
    Route::resource('feedbacks', FeedbackController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('templates', TemplateController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('kpis', KpiController::class);

    //KPI
    Route::get('kpis/create_target/{target}', [KpiController::class, 'create_target'])->name('kpis.create_target');
    Route::get('kpis/create_task/{task}', [KpiController::class, 'create_task'])->name('kpis.create_task');
});

require __DIR__.'/auth.php';
