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
        $tasks = Task::with(['target', 'departments'])->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $targets = Target::get();

        $departments = Department::get();

        $parent_tasks = Task::get();

        $users = User::get();

        $fortnights = Fortnight::get();

        return view('tasks.create', compact('targets', 'parent_tasks', 'departments', 'users', 'fortnights'));
    }

    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();

        $data['is_subtask'] = $data['parent_task_id'] ? true : false;

        $departments = $request['department_id'];
        $fortnights = $request['fortnight_id'];
        $users = $request['user_id'];

        unset($request['department_id']);
        unset($request['fortnight_id']);
        unset($request['user_id']);

        $task = Task::create($data);

        $task->departments()->attach($departments);
        $task->fortnights()->attach($fortnights);
        $task->users()->attach($users);


        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task = $task->load('departments', 'users');

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

        $departments = $request['department_id'];
        $fortnights = $request['fortnight_id'];
        $users = $request['user_id'];

        $oldDepartments = $task->departments()->pluck('departments.id')->toArray();

        unset($request['department_id']);
        unset($request['fortnight_id']);
        unset($request['user_id']);

        $task->update($data);

        $task->departments()->attach($departments);
        $task->fortnights()->attach($fortnights);
        $task->users()->attach($users);



        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        if($task->kpi()->exists() || $task->deliverables()->exists())
        {
            return redirect()->route('tasks.index')
            ->with('related', 'task-deleted');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
