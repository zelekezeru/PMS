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

        if($user->roles->first()->name == 'SUPER_ADMIN' || $user->roles->first()->name == 'ADMIN')
        {
            $departments = Department::get();
            $users = User::get();
            $tasks = Task::get();
        }
        elseif($user->roles->first()->name == 'DEPARTMENT_HEAD')
        {
            $departments = $user->department;
            $users = $departments->users;
            $tasks = $departments->tasks;
        }
        elseif($user->roles->first()->name == 'EMPLOYEE')
        {
            $departments = $user->departments;
            $users = $user;
            $tasks = $users->tasks;
        }

        return view('index', compact('strategies', 'tasks', 'fortnights', 'years', 'departments', 'users'));
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
