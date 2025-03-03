<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Department;
use App\Models\User;
use App\Models\Target;
use App\Models\TaskSummary;
use App\Models\Fortnight;
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

        $fortnights = Fortnight::all();

        $assignedUsers = [];

        $report = new Report;

        return view('reports.create', compact('departments', 'users', 'targets', 'report', 'assignedUsers', 'fortnights'));
    }

    public function store(ReportStoreRequest $request)
    {
        $data = $request->validated();

        $users = User::whereIn('id', $request->user_id)->get();
        $departments = Department::whereIn('id', $request->department_id)->get();

        $fortnight = Fortnight::findOrFail($request->fortnight_id);

        $user_tasks = $this->calculate_tasks($users, 'user')->getData();

        $department_tasks = $this->calculate_tasks($departments, 'department')->getData();

    
        // Save user_tasks data to TaskSummary table
        foreach ($user_tasks->component_task_summaries as $taskSummary) {

            $report_data = [
                'start_date' => $request->start_date ?? $fortnight->start_date,
                'end_date' => $request->end_date ?? $fortnight->end_date,
                'user_id' => $user_tasks->task_user,
                'department_id' => $user_tasks->task_department,
                'fortnight_id' => $request->fortnight_id,
                'created_by' => auth()->id(),
            ];
            
            $report = Report::create($report_data);

            $report->taskSummaries()->create((array) $taskSummary);
        }

        // Save department_tasks data to TaskSummary table
        foreach ($department_tasks->component_task_summaries as $taskSummary) {

            $report_data = [
                'start_date' => $request->start_date ?? $fortnight->start_date,
                'end_date' => $request->end_date ?? $fortnight->end_date,
                'user_id' => $user_tasks->task_user,
                'department_id' => $user_tasks->task_department,
                'fortnight_id' => $request->fortnight_id,
                'created_by' => auth()->id(),
            ];
            
            $report = Report::create($report_data);

            $report->taskSummaries()->create((array) $taskSummary);
        }

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

    public function calculate_tasks($components, $type)
    {
        // The operation is done for all users in the collection

        foreach($components as $component)
        {
            // Fetch tasks and KPIs once to avoid redundant queries
            $tasks = collect($component->tasks);
            
            // Group and count task statuses
            $taskCounts = $tasks->groupBy('status')->map->count();

            if($type == 'user')
            {
                $taskSummary = [
                    'all_tasks' => $tasks->count(),
                    'pending_tasks' => $taskCounts->get('Pending', 0),
                    'progress_tasks' => $taskCounts->get('Progress', 0),
                    'completed_tasks' => $taskCounts->get('Completed', 0),
                ];
                $task_user = $component->id;
                $task_department = 0;
            }
            else
            {
                $taskSummary = [
                    'all_tasks' => $tasks->count(),
                    'pending_tasks' => $taskCounts->get('Pending', 0),
                    'progress_tasks' => $taskCounts->get('Progress', 0),
                    'completed_tasks' => $taskCounts->get('Completed', 0),
                ];
                $task_user = 0;
                $task_department = $component->id;
            }
            
            // count the Kpis for each task
            foreach($tasks as $task)
            {
                $kpis = collect($task->kpis);
                // Group and count KPI statuses

                $kpiCounts = $kpis->groupBy('status')->map->count();

                $kpiSummary = [
                    'task_kpis' => $kpis->count(),
                    'pending_kpis' => $kpiCounts->get('Pending', 0),
                    'progress_kpis' => $kpiCounts->get('Progress', 0),
                    'completed_kpis' => $kpiCounts->get('Completed', 0),
                ];
                
                // Initialize the array if not already initialized
                if (!isset($taskKpiSummaries)) {
                    $taskKpiSummaries = [];
                }

                // Store the KPI summary for each task
                $taskKpiSummaries[$task->id] = $kpiSummary;
            }
                // Initialize the array if not already initialized
                if (!isset($componentTaskSummaries)) {
                    $componentTaskSummaries = [];
                }

                // Store the KPI summary for each task
                $componentTaskSummaries[$component->id] = $taskSummary;
        }

        // Return data as JSON or pass it to a view
        return response()->json([
            'component_task_summaries' => $componentTaskSummaries,
            'task_kpi_summaries' => $taskKpiSummaries,
            'task_user' => $task_user,
            'task_department' => $task_department
        ]);

        // Return as JSON response (for API) or pass it to a view
        return response()->json($taskSummary);
                
    }

}
