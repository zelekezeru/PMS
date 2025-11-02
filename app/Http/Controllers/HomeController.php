<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\Department;
use App\Models\Fortnight;
use App\Models\Home;
use App\Models\Strategy;
use App\Models\Task;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $strategies = Strategy::get();

        $years = Year::get();

        $fortnights = Fortnight::get();

        $user = Auth::user();
        
        if (request()->user()->hasAnyRole(['EMPLOYEE'])) {
            $departments = null;

            $users = null;

            $tasks = $user->tasks;

            $dailyTasks = $user->dailyTasks;

        } elseif (request()->user()->hasAnyRole(['DEPARTMENT_HEAD'])) {

            $department = request()->user()->load('headOf')->headOf;

            $departmentTasks = $department->tasks;

            $departmentTasks = request()->user()->tasks;

            $tasks = $departmentTasks->merge($departmentTasks)->unique('id');

            $dailyTasks = $user->dailyTasks;

            $users = $department->users;

            $departments = null;

        } elseif (request()->user()->hasAnyRole(['SUPER_ADMIN']) || request()->user()->hasAnyRole(['ADMIN'])) {
            $departments = Department::get();

            $users = User::get();

            $tasks = Task::get();

            $dailyTasks = DailyTask::where('date', now()->format('Y-m-d'))->get();
        }

        $pendingTasks = $tasks->where('status', 'Pending')->count();

        $inProgressTasks = $tasks->where('status', 'Progress')->count();

        $completedTasks = $tasks->where('status', 'Completed')->count();

        return view('index', compact('strategies', 'tasks', 'fortnights', 'years', 'departments', 'users', 'pendingTasks', 'inProgressTasks', 'completedTasks', 'dailyTasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Home $home)
    {
        //
    }
}
