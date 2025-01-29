<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Home;
use App\Models\Strategy;
use App\Models\Task;
use App\Models\Report;
use App\Models\Year;
use App\Models\Fortnight;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $strategies = Strategy::get();

        $tasks = Task::get();

        $reports = Report::get();

        $years = Year::get();

        $departments = Department::get();

        $fortnights = Fortnight::get();

        return view('index', compact('strategies', 'tasks', 'reports', 'fortnights', 'years'));
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
