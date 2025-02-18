<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Department;
use App\Models\User;
use App\Models\Target;
use Illuminate\Http\Request;
use App\Http\Requests\ReportStoreRequest;
use App\Http\Requests\ReportUpdateRequest;
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

        $assignedUsers = [];

        $report = new Report;

        return view('reports.create', compact('departments', 'users', 'targets', 'report', 'assignedUsers'));
    }

    public function store(ReportStoreRequest $request)
    {
        $data = $request->validated();

        $users = User::whereIn('id', $request->user_id)->get();

        $departments = Department::whereIn('id', $request->department_id)->get();

        $calculate_task = $this->calculate_tasks($users);
        
        Report::create($request->all());

        // Set session message
        return redirect()->route('reports.index')->with('status', 'Report created successfully.');
    }

    // Display the specified report
    public function show($id)
    {
        $report = Report::findOrFail($id);

        return view('reports.show', compact('report'));
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

    public function update(ReportStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->fails()) {
            return redirect()->route('reports.edit', $id)
                            ->withErrors($data)
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

    public function calculate_tasks($users)
    {
        foreach($users as $user)
        {
            // Fetch tasks and KPIs once to avoid redundant queries
            $tasks = collect($user->tasks);

            // Group and count task statuses
            $taskCounts = $tasks->groupBy('status')->map->count();
            $taskSummary = [
                'all_tasks' => $tasks->count(),
                'pending' => $taskCounts->get('Pending', 0),
                'progress' => $taskCounts->get('Progress', 0),
                'completed' => $taskCounts->get('Completed', 0),
            ];

            foreach($tasks as $task)
            {
                $kpis = collect($task->kpis);
                // Group and count KPI statuses

                $kpiCounts = $kpis->groupBy('status')->map->count();

                $kpiSummary = [
                    'all_kpis' => $kpis->count(),
                    'pending' => $kpiCounts->get('Pending', 0),
                    'progress' => $kpiCounts->get('Progress', 0),
                    'completed' => $kpiCounts->get('Completed', 0),
                ];
            }
                

                dd($kpiSummary);
                
            // If KPI summary is needed for each task, create an array
            $taskKpiSummaries = [];

            foreach ($tasks as $task) {
                $taskKpiSummaries[$task->id] = $kpiSummary;
            }

            // Return data as JSON or pass it to a view
            return response()->json([
                'task_summary' => $taskSummary,
                'kpi_summary' => $kpiSummary,
                'task_kpi_summaries' => $taskKpiSummaries
            ]);


            

            // Return as JSON response (for API) or pass it to a view
            return response()->json($taskSummary);
                
        }
    }

}
