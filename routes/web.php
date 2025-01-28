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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/home', function () {
    return view('index');
});
//Resource Routes

Route::resource('users', UserController::class);

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




require __DIR__.'/auth.php';