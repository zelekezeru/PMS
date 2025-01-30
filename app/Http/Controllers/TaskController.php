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
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['target'])->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $targets = Target::get();

        $departments = Department::get();

        $parent_tasks = Task::get();

        return view('tasks.create', compact('targets', 'parent_tasks', 'departments'));
    }

    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();

        $data['is_subtask'] = $data['parent_task_id'] ? true : false;

        $departments = $data['departments'];

        unset($data['departments']);

        $task = Task::create($data);

        $task->departments()->attach($departments);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');

    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $targets = Target::get();

        $departments = Department::get();

        $parent_tasks = Task::where('is_subtask', false)->get();

        return view('tasks.edit', compact('task', 'targets', 'parent_tasks', 'departments'));
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $data = $request->validated();

        $task->update($data);

        $departments = $request['departments'];

        unset($data['departments']);

        $task->departments()->attach($departments);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
