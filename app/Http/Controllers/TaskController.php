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
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index()
    {
        if(request()->user()->hasAnyRole(['DEPARTMENT_HEAD']))
        {
            $tasks = request()->user()->headOf->tasks()->with(['target', 'departments'])->paginate(10);
        } else if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN'])) {
            $tasks = Task::with(['target', 'departments'])->paginate(10);
        } else {
            $tasks = request()->user()->tasks()->with(['target', 'departments'])->paginate(10);
        }
        return view('tasks.index', compact('tasks'));
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

        return view('tasks.create', compact('targets', 'parent_tasks', 'departments', 'users', 'fortnights', 'assignedUsers'));
    }

    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();
        $data['is_subtask'] = $data['parent_task_id'] ? true : false;
        $data['created_by'] = request()->user()->id;

        $departments = $request['department_id'];
        $fortnights = $request['fortnight_id'];
        $users = $request['user_id'];

        unset($data['department_id']);
        unset($data['fortnight_id']);
        unset($data['user_id']);

        $task = Task::create($data);

        $task->departments()->attach($departments);

        $task->fortnights()->attach($fortnights);

        $task->users()->attach($users);


        return redirect()->route('tasks.index')->with('status', 'Task has been successfully created.');
    }

    public function show(Task $task)
    {
        $task = $task->load('departments', 'users', 'kpis');

        $users = $task->users;
        return view('tasks.show', compact('task', 'users'));
    }

    public function edit(Task $task)
    {

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
        $data = $request->validated();


        $data['is_subtask'] = $data['parent_task_id'] ? true : false;

        $departments = $data['department_id'];
        $fortnights = $data['fortnight_id'];
        $users = $data['user_id'];

        $task->departments()->detach();
        $task->fortnights()->detach();
        $task->users()->detach();

        unset($data['department_id']);
        unset($data['fortnight_id']);
        unset($data['user_id']);

        $task->update($data);

        $task->departments()->attach($departments);
        $task->fortnights()->attach($fortnights);
        $task->users()->attach($users);



        return redirect()->route('tasks.index')->with('status', 'Task has been successfully Updated.');
    }

    public function destroy(Task $task)
    {
        if($task->kpi()->exists() || $task->deliverables()->exists())
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
