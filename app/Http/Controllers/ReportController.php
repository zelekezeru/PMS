<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportStoreRequest;
use App\Models\Department;
use App\Models\Fortnight;
use App\Models\Report;
use App\Models\Target;
use App\Models\TaskKpiSummary;
use App\Models\TaskSummary;
use App\Models\User;
use Illuminate\Http\Request;

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
            $query->where('schedule', 'like', '%'.$request->schedule.'%');
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

        if ($request->has('fortnight_id')) {
            $data['fortnight_id'] = $request->fortnight_id;

            $fortnight = Fortnight::findOrFail($request->fortnight_id);
        }

        if ($request->has('user_id')) {
            $data['user_id'] = $request->user_id;

            $users = User::whereIn('id', $request->user_id)->get();

            // Calculate tasks for each user and department
            foreach ($users as $user) {
                $tasks = $user->tasks->where('created_at', '>=', $fortnight->start_date)->where('created_at', '<=', $fortnight->end_date);

                $user_tasks = $this->calculate_tasks($tasks, $user)->getData();

                $report_data = [
                    'start_date' => $request->start_date ?? $fortnight->start_date,
                    'end_date' => $request->end_date ?? $fortnight->end_date,
                    'user_id' => $user->id,
                    'department_id' => $user->department->department_id,
                    'fortnight_id' => $request->fortnight_id,
                    'created_by' => auth()->id(),
                ];

                $report = Report::create($report_data);

                TaskSummary::create([
                    'report_id' => $report->id,
                    'all_tasks' => $user_tasks->taskSummary->all_tasks,
                    'pending_tasks' => $user_tasks->taskSummary->pending_tasks,
                    'progress_tasks' => $user_tasks->taskSummary->progress_tasks,
                    'completed_tasks' => $user_tasks->taskSummary->completed_tasks,
                ]);

                foreach ($user_tasks->task_kpi_summaries as $kpiSummary) {
                    TaskKpiSummary::create([
                        'task_id' => $kpiSummary->task_id,
                        'task_kpis' => $kpiSummary->task_kpis,
                        'pending_kpis' => $kpiSummary->pending_kpis,
                        'progress_kpis' => $kpiSummary->progress_kpis,
                        'completed_kpis' => $kpiSummary->completed_kpis,
                    ]);
                }
            }
        }

        if ($request->has('department_id')) {
            $data['department_id'] = $request->department_id;

            $departments = Department::whereIn('id', $request->department_id)->get();

            foreach ($departments as $department) {
                $tasks = $department->tasks->where('created_at', '>=', $fortnight->start_date)->where('created_at', '<=', $fortnight->end_date);

                $department_tasks = $this->calculate_tasks($tasks, $department)->getData();
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

                TaskSummary::create([
                    'report_id' => $report->id,
                    'all_tasks' => $taskSummary->all_tasks,
                    'pending_tasks' => $taskSummary->pending_tasks,
                    'progress_tasks' => $taskSummary->progress_tasks,
                    'completed_tasks' => $taskSummary->completed_tasks,
                ]);

                foreach ($department_tasks->task_kpi_summaries as $kpiSummary) {
                    TaskKpiSummary::create([
                        'task_id' => $kpiSummary->task_id,
                        'task_kpis' => $kpiSummary->task_kpis,
                        'pending_kpis' => $kpiSummary->pending_kpis,
                        'progress_kpis' => $kpiSummary->progress_kpis,
                        'completed_kpis' => $kpiSummary->completed_kpis,
                    ]);
                }
            }
        }

        // Set session message
        return redirect()->route('reports.index')->with('status', 'Report created successfully.');
    }

    // Display the specified report
    public function show($id)
    {
        $report = Report::findOrFail($id);

        $taskSummaries = $report->taskSummaries->toArray();
        $taskKpiSummaries = TaskKpiSummary::whereIn('task_id', array_column($taskSummaries, 'task_id'))->get()->toArray();

        return view('reports.show', compact('report', 'taskSummaries', 'taskKpiSummaries'));
    }

    // Show the form for editing an existing report
    public function edit($id)
    {
        $report = Report::findOrFail($id);

        $departments = Department::all();

        $users = User::all();

        $targets = Target::all();

        $fortnights = Fortnight::all();

        $assignedUsers = $report->users->pluck('id')->toArray();

        return view('reports.edit', compact('report', 'departments', 'users', 'targets', 'assignedUsers', 'fortnights'));
    }

    public function update(ReportStoreRequest $request)
    {
        $data = $request->validated();

        return redirect()->route('reports.index')->with('status', 'Report updated successfully.');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        $report->delete();

        return redirect()->route('reports.index')->with('status', 'Report deleted successfully.');
    }

    public function calculate_tasks($tasks, $component)
    {
        // Group and count task statuses
        $taskCounts = $tasks->groupBy('status')->map->count();

        $taskSummary = [
            'all_tasks' => $tasks->count(),
            'pending_tasks' => $taskCounts->get('Pending', 0),
            'progress_tasks' => $taskCounts->get('Progress', 0),
            'completed_tasks' => $taskCounts->get('Completed', 0),
        ];

        // count the Kpis for each task
        foreach ($tasks as $task) {
            $kpis = collect($task->kpis);

            // Group and count KPI statuses for each task
            $kpiCounts = $kpis->groupBy('status')->map->count();

            $kpiSummary = [
                'task_id' => $task->id,
                'task_kpis' => $kpis->count(),
                'pending_kpis' => $kpiCounts->get('Pending', 0),
                'progress_kpis' => $kpiCounts->get('Progress', 0),
                'completed_kpis' => $kpiCounts->get('Completed', 0),
            ];

            // Initialize the array if not already initialized
            if (! isset($taskKpiSummaries)) {
                $taskKpiSummaries = [];
            }

            // Store the KPI summary for each task
            $taskKpiSummaries[$task->id] = $kpiSummary;

        }

        // Return data as JSON or pass it to a view
        return response()->json([
            'taskSummary' => $taskSummary,
            'task_kpi_summaries' => $taskKpiSummaries,
        ]);

    }
}
