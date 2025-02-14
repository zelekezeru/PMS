<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Home;
use App\Models\Strategy;
use App\Models\Task;
use App\Models\Report;
use App\Models\Year;
use App\Models\Fortnight;
use App\Models\User;
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

        if($user->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
        {
            $departments = Department::get();

            $users = User::get();

            $tasks = Task::get();
        }
        elseif($user->hasRole('DEPARTMENT_HEAD')) {

            $headOf = request()->user()->load('headOf')->headOf;

            $tasks = $headOf ? $headOf->tasks : Task::query()->get();

            $departments = $user->department;

            $users = $departments->users;
            
        }
        elseif($user->hasRole('EMPLOYEE'))
        {
            $departments = $user->departments;

            $users = null;

            $tasks = $user->tasks;
        }

        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();

        return view('index', compact('strategies', 'tasks', 'fortnights', 'years', 'departments', 'users', 'pendingTasks', 'inProgressTasks', 'completedTasks'));
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
