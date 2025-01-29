<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
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
<<<<<<< Updated upstream
use App\Http\Controllers\UserController;
=======
use App\Models\Department;
use App\Http\Controllers\DepartmentController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
>>>>>>> Stashed changes

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Auth Routes

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/home', function () {
    return view('index');
});
//Resource Routes

<<<<<<< Updated upstream
Route::resource('users', UserController::class);
=======
Route::resource('homes', HomeController::class);
>>>>>>> Stashed changes

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

Route::resource('kpis', KpiController::class);

Route::resource('reports', ReportController::class);

Route::resource('templates', TemplateController::class);

<<<<<<< Updated upstream



require __DIR__.'/auth.php';
=======
Route::resource('departments', DepartmentController::class);
>>>>>>> Stashed changes
