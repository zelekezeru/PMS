<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Department;
use App\Models\User;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    // Display a listing of the reports with filters
    public function index(Request $request)
    {
        $query = Report::query();

        // Apply filters if provided
        if ($request->has('date') && $request->date != '') {
            $query->where('report_date', $request->date);
        }

        if ($request->has('department_id') && $request->department_id != '') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('target_id') && $request->target != '') {
            $query->where('target_id', $request->target_id);
        }

        if ($request->has('schedule') && $request->schedule != '') {
            $query->where('schedule', 'like', '%' . $request->schedule . '%');
        }

        $reports = $query->paginate(15);
        $departments = Department::all();
        $users = User::all();
        $targets = Target::all();

        return view('reports.index', compact('reports', 'departments', 'users', 'targets'));
    }

    // Show the form for creating a new report
    public function create()
    {
        $departments = Department::all();
        $users = User::all();
        $targets = Target::all();

        return view('reports.create', compact('departments', 'users', 'targets'));
    }

    // Show the form for editing an existing report
    public function edit($id)
    {
        $report = Report::findOrFail($id);
        $departments = Department::all();
        $users = User::all();
        $targets = Target::all();

        return view('reports.edit', compact('report', 'departments', 'users', 'targets'));
    }

    // Display the specified report
    public function show($id)
    {
        $report = Report::findOrFail($id);

        return view('reports.show', compact('report'));
    }

        public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'user_id' => 'required|exists:users,id',
            'target_id' => 'required|exists:targets,id',
            'schedule' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('reports.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        Report::create($request->all());

        // Set session message
        return redirect()->route('reports.index')->with('status', 'Report created successfully.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'report_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'user_id' => 'required|exists:users,id',
            'target_id' => 'required|exists:targets,id',
            'schedule' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('reports.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $report = Report::findOrFail($id);
        $report->update($request->all());

        return redirect()->route('reports.index')->with('status', 'Report updated successfully.');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('reports.index')->with('status', 'Report deleted successfully.');
    }

}
