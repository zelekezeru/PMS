<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Day;
use App\Models\Goal;
use App\Models\Kpi;
use App\Models\Target;
use App\Models\Department;
use App\Models\Fortnight;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Fetch tasks based on roles
        if (request()->user()->hasAnyRole(['DEPARTMENT_HEAD'])) {
            $headOf = request()->user()->load('headOf')->headOf;

            $tasks = $headOf ? $headOf->tasks() : Task::query();
        } 
        else if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN'])) {

            $tasks = Task::with(['target', 'departments']);
        } 
        else {
            $tasks = request()->user()->tasks();
        }

        // Fetch tasks only related to the currently active fortnight if currentFortnight is true
        $currentFortnight = null;

        $today = Carbon::now()->format('Y-m-d');
        if ($request->query('currentFortnight')) {


            $currentFortnight = Fortnight::whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)->first();
                
                $tasks = $tasks->whereHas('fortnights', function ($query) use ($currentFortnight) {
                    $query->where('fortnights.id', $currentFortnight->id);
                });
        } elseif ($request->query('todays')) {

            $currentFortnight = Fortnight::whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)->first();

            if (Day::where('date', $today)->exists()) {
                $date = Day::where('date', $today)->first();
            } else {
                $date = Day::create([
                        'fortnight_id' => $currentFortnight->id, 
                        'date' => $today
                    ]);
            }
    

            $tasks = $tasks->whereHas('days', function ($query) use ($date) {
                $query->where('days.id', $date);
            });
        }

        // Filtering and sorting
        $search = $request->query('search') ?? null;
        $status = $request->query('status') ?? null;
        $dueDays = intval($request->query('due_days')) ?? null;
        $order = $request->query('order') ?? null;
        if ($search) {
            $tasks = $tasks->where('name', 'LIKE', '%' . $search . '%')
                ->orWhereHas('createdBy', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                });
        } elseif ($status) {
            $tasks = $tasks->where('status', $status);
        } elseif ($dueDays) {
            $dueDate = Carbon::now()->addDays($dueDays);

            $tasks = $tasks->whereNotNull('due_date')->whereDate('due_date', '<=', $dueDate);
        } elseif ($order) {
            $tasks = $tasks->orderBy('name', $order);
        }

        $tasks = $tasks->with(['target', 'departments', 'createdBy'])->paginate(10);

        return view('tasks.index', compact('tasks', 'currentFortnight'));
    }

    public function create(Request $request)
    {
        $targets = Target::get();

        $departments = Department::get();

        $parent_tasks = Task::get();

        $users = (request()->user()->hasROle('DEPARTMENT_HEAD') ? request()->user()->headOf->users :  request()->user()->hasROle('EMPLOYEE')) ? null : User::get();

        $today = (bool) request()->query('dailyTask') === true ? Carbon::now()->format('Y-m-d') : null;

        $fortnights = Fortnight::get();

        $assignedUsers = [];

        $parent_task_id = $request->input('parent_task_id', null);

        return view('tasks.create', compact('targets', 'parent_tasks', 'departments', 'users', 'fortnights', 'assignedUsers', 'parent_task_id', 'today'));
    }

    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();

        if (isset($data['parent_task_id'])) {
            $data['is_subtask'] = true;
        } 
        else {
            $data['is_subtask'] = false;
        }

        $data['is_subtask'] = $data['parent_task_id'] ? true : false;

        $data['created_by'] = request()->user()->id;

        $departments = $request['department_id'];

        $fortnights = $request['fortnight_id'];

        $users = request()->user()->hasRole('EMPLOYEE') ? [0 => request()->user()->id] : $request['user_id'];

        unset($data['department_id']);

        unset($data['fortnight_id']);

        unset($data['user_id']);

        $task = Task::create($data);

        // If Daily Task
        if ($request->query('today')) {
            $today = Carbon::now()->format('Y-m-d');
            $currentFortnightId = Fortnight::whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)->first()->id;
            if (Day::where('date', $today)->exists()) {
                $day = Day::where('date', $today)->first();
            } else {
                $day = Day::create([
                        'fortnight_id' => $currentFortnightId, 
                        'date' => $today
                    ]);
            }

            $day->tasks()->attach($task);
        }

        if (!request()->user()->hasRole('EMPLOYEE')) {
            $task->departments()->attach($departments);
        }

        $task->fortnights()->attach($fortnights);

        $task->users()->attach($users);
        return redirect()->route('tasks.index')->with('status', 'Task has been successfully created.');
    }

    public function show(Task $task)
    {
        $task = $task->load('departments', 'users', 'kpis', 'subtasks');

        $users = $task->users;
        return view('tasks.show', compact('task', 'users'));
    }

    public function edit(Task $task)
    {
        if (request()->user()->cannot('manageTask', $task)) {
            abort(403);
        }

        $task = $task->load('days');

        $isDaily = $task->days()->exists();

        $today = $isDaily ? $task->days()->first() : null;

        $assignedUsers = $task->users()->pluck('users.id')->toArray();

        $targets = Target::get();

        $departments = Department::get();

        $parent_tasks = Task::where('is_subtask', false)->get();

        $users = User::get();

        $fortnights = Fortnight::get();

        return view('tasks.edit', compact('task', 'targets', 'parent_tasks', 'departments', 'users', 'fortnights', 'assignedUsers', 'today'));
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        if (request()->user()->cannot('manageTask', $task)) {
            abort(403);
        }

        $data = $request->validated();

        $data['is_subtask'] = $data['parent_task_id'] ? true : false;

        $departments = $request['department_id'];
        $fortnights = $request['fortnight_id'];
        $users = request()->user()->hasRole('EMPLOYEE') ? [0 => request()->user()->id] : $request['user_id'];

        if (!request()->user()->hasRole('EMPLOYEE')) {
            $task->departments()->detach();
            $task->users()->detach();
        }

        $task->fortnights()->detach();

        unset($data['department_id']);
        unset($data['fortnight_id']);
        unset($data['user_id']);

        $task->update($data);

        if (!request()->user()->hasRole('EMPLOYEE')) {
            $task->departments()->attach($departments);
            $task->fortnights()->attach($fortnights);
            $task->users()->attach($users);
        }

        dd($data);
        return redirect()->route('tasks.index')->with('status', 'Task has been successfully Updated.');
    }

    public function destroy(Task $task)
    {
        if (request()->user()->cannot('manageTask', $task)) {
            abort(403);
        }

        if ($task->kpis()->exists() || $task->deliverables()->exists() || $task->feedbacks()->exists()) {
            return redirect()->route('tasks.index')
            ->with('status', 'You can\'t Delete This pending Task it have feedback on it.');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('status', 'Task has been successfully Deleted.');
    }

    public function listByStatus($status)
    {
        $tasks = Task::where('status', $status)->get();

        if (request()->user()->hasAnyRole(['DEPARTMENT_HEAD'])) {
            $tasks = request()->user()->headOf->tasks()->with(['target', 'departments'])->where('status', $status)->paginate(10);
        } else if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN'])) {

            $tasks = Task::with(['target', 'departments'])->where('status', $status)->paginate(10);
        } else {
            $tasks = request()->user()->tasks()->with(['target', 'departments'])->where('status', $status)->paginate(10);
        }
        $currentFortnight = null;

        // dd($tasks);
        return view('tasks.index', compact('tasks', 'currentFortnight'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $task->status = $request->status;

        $task->save();

        return redirect()->route('tasks.show', $task->id)->with('success', 'Task status updated successfully.');
    }
}
