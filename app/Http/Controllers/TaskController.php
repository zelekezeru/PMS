<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
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
        if(request()->user()->hasAnyRole(['DEPARTMENT_HEAD']))
        {
            $tasks = request()->user()->headOf->tasks();
        } else if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN'])) {
            $tasks = Task::with(['target', 'departments']);
        } else {
            $tasks = request()->user()->tasks();
        }

        // Fetch tasks only related to the currently active fortnight if currentFortnight is true
        $currentFortnight = null;
        if ($request->query('currentFortnight')) {

            $today = Carbon::now()->format('Y-m-d');

            $currentFortnight = Fortnight::whereDate('start_date', '<', $today)
            ->whereDate('end_date', '>', $today)->first();

            $tasks = $tasks->whereHas('fortnights', function ($query) use ($currentFortnight) {
                $query->where('fortnights.id' , $currentFortnight->id);
            });
        }

        // Filtering and sorting
        $search = $request->query('search') ?? null;
        $status = $request->query('status') ?? null;
        $order = $request->query('order') ?? null;
        if ($search) {
            $tasks = $tasks->where('name', 'LIKE', '%'. $search . '%');
        } elseif ($status) {
            $tasks = $tasks->where('status', $status);
        } elseif ($order){
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

        if (isset($request['day'])) {
            dd($request['day']);
        }

        $fortnights = Fortnight::get();

        $assignedUsers = [];

        $parent_task_id = $request->input('parent_task_id', null);

        return view('tasks.create', compact('targets', 'parent_tasks', 'departments', 'users', 'fortnights', 'assignedUsers', 'parent_task_id'));
    }

    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();

        if (isset($data['parent_task_id'])) {
            $data['is_subtask'] = true;
        } else {
            $data['is_subtask'] = false;
        }
        $data['is_subtask'] = $data['parent_task_id'] ? true : false;
        $data['created_by'] = request()->user()->id;

        $departments = $request['department_id'];
        $fortnights = $request['fortnight_id'];
        $users = request()->user()->hasRole('EMPLOYEE') ? [0 => request()->user()->id] : $request['user_id'];

        // dd($departments);
        unset($data['department_id']);
        unset($data['fortnight_id']);
        unset($data['user_id']);

        $task = Task::create($data);

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
        $assignedUsers = $task->users()->pluck('users.id')->toArray();

        $targets = Target::get();

        $departments = Department::get();

        $parent_tasks = Task::where('is_subtask', false)->get();

        $users = User::get();

        $fortnights = Fortnight::get();

        return view('tasks.edit', compact('task', 'targets', 'parent_tasks', 'departments', 'users', 'fortnights', 'assignedUsers'));
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
        $users = $request['user_id'];

        $task->departments()->detach();
        $task->fortnights()->detach();
        $task->users()->detach();

        unset($data['department_id']);
        unset($data['fortnight_id']);
        unset($data['user_id']);

        $task->update($data);
        if (!request()->user()->hasRole('EMPLOYEE')) {
            $task->departments()->attach($departments);
            $task->users()->attach($users);
            # code...
        }

        return redirect()->route('tasks.index')->with('status', 'Task has been successfully Updated.');
    }

    public function destroy(Task $task)
    {
        if (request()->user()->cannot('manageTask', $task)) {
            abort(403);
        }

        if($task->kpis()->exists() || $task->deliverables()->exists() || $task->feedbacks()->exists())
        {
            return redirect()->route('tasks.index')
            ->with('related', 'task-deleted');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('status', 'Task has been successfully Deleted.');
    }

    public function listByStatus($status)
    {
        $tasks = Task::where('status', $status)->paginate(10);

        if(request()->user()->hasAnyRole(['DEPARTMENT_HEAD']))
        {
            $tasks = request()->user()->headOf->tasks()->with(['target', 'departments'])->where('status', $status)->paginate(10);

        } else if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN'])) {

            $tasks = Task::with(['target', 'departments'])->where('status', $status)->paginate(10);

        } else {
            $tasks = request()->user()->tasks()->with(['target', 'departments'])->where('status', $status)->paginate(10);
        }
        return view('tasks.index', compact('tasks'));
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
