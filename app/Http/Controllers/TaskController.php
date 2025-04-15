<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Mail\TaskAssigned;
use App\Models\Day;
use App\Models\Department;
use App\Models\Fortnight;
use App\Models\Target;
use App\Models\Task;
use App\Models\User;
use App\Services\FilterTasksService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $this->getAuthUserTasks($request);

        /**
         * ______HERE WE FILTER THE TASKS_____
         *
         *
         * Fetch currentFortnight by checking to which fortnight the current day belongs to(we need it to fetch current)
         *
         * we need the currentFortnight variable to fetch tasks of currentFortnight and
         *
         * to create Day just in case the current day doesnt exist
         *
         * */

        // initiate a new FilterTasksService class to be able to uses the methods in it
        $filterTasksService = new FilterTasksService;

        /**
         * Filter by tasks by scopes
         * Scopes refer to how long the task takes to complete...(for today, for this(current) fortnight)
         *
         * the filterByScope method in the service class also returns check app/Services/FilterTasksService.php to understand more
         */
        [$tasks, $currentFortnight] = $filterTasksService->filterByScope($tasks, $request);

        // This Filters the tasks as the user requested
        $tasks = $filterTasksService->filterByColumns($tasks, $request);

        $tasks = $tasks->with(['target', 'departments', 'createdBy'])
            ->where('is_subtask', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('tasks.index', compact('tasks', 'currentFortnight'));
    }

    /**
     * Get user tasks based on role and request parameters
     */
    private function getAuthUserTasks(Request $request)
    {
        $user = $request->user();

        if ($user->hasAnyRole(['DEPARTMENT_HEAD'])) {
            return $request->query('myTasks')
                ? $user->tasks()
                : optional($user->load('headOf')->headOf)->tasks() ?? Task::query();
        }

        if ($user->hasAnyRole(['SUPER_ADMIN', 'ADMIN'])) {
            return $request->query('myTasks') ? $user->tasks() : Task::query();
        }

        return $user->tasks();
    }

    public function create(Request $request)
    {
        $targets = Target::get();

        $departments = (request()->user()->hasROle('DEPARTMENT_HEAD') ? [request()->user()->headOf] : request()->user()->hasROle('EMPLOYEE')) ? [] : Department::get();

        $parent_tasks = Task::get();

        $users = request()->user()->hasROle('DEPARTMENT_HEAD') ? request()->user()->headOf->users : (request()->user()->hasRole('EMPLOYEE') ? [] : User::orderBy('name', 'asc')->get());

        $forToday = (bool) request()->query('dailyTask') === true ? Carbon::now()->format('Y-m-d') : null;

        $fortnights = Fortnight::get();

        $assignedUsers = [];

        $parent_task_id = $request->input('parent_task_id', null);

        return view('tasks.create', compact('targets', 'parent_tasks', 'departments', 'users', 'fortnights', 'assignedUsers', 'parent_task_id', 'forToday'));
    }

    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();

        $data['is_subtask'] = $data['parent_task_id'] ? true : false;
        $data['created_by'] = request()->user()->id;

        /**
         * Sets assigned departments ($departments) to the department of the logged user if the role of the user is EMPLOYEE or DEPARMENT_HEAD
         * But sets the assigned departments to what the logged in user requested to assign if the role is any other than the above(^)
         *
         * sets the assigned users ($users) to the logged in user if the role is employee or sets it to the users the logged in user assigned if the role is otherwise
         *
         * Note that this only creates the correct array that will be attached to the task that will be create right after the task is created
         */
        $user = request()->user();

        // Determine departments
        if ($user->hasAnyRole(['EMPLOYEE', 'DEPARTMENT_HEAD'])) {
            $departments = [0 => $user->department->id];
        } else {
            $departments = $request['department_id'];
        }
        
        // Get fortnight IDs directly from the request
        $fortnights = $request['fortnight_id'] ?? [];
        
        // Determine users
        if ($user->hasRole('EMPLOYEE')) {
            $users = [0 => $user->id];
        } elseif (!empty($request['user_id'])) {
            $users = $request['user_id'];
        } else {
            $users = [];
        }

        // unsets(removes) fields from the $data array which dont belong to the tasks table

        unset($data['department_id']);
        unset($data['fortnight_id']);
        unset($data['user_id']);

        $task = Task::create($data);

        /**
         * If the task created is daily the client form will send a query called forToday in the url
         *
         * in that case we will fetch the current day from the database and attach it to the task that was just created and if the day doesnt exist we will create it
         */
        if ($request->query('forToday')) {

            $today = Carbon::now()->format('Y-m-d');

            $currentFortnightId = Fortnight::whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)->first()->id;

            $day = Day::firstOrCreate([
                'fortnight_id' => $currentFortnightId,
                'date' => $today,
            ]);

            $day->tasks()->attach($task);
        }

        /**
         * Attaches the departments, users and fortnights that were created above to the newly created task
         */
        $task->departments()->attach($departments);
        $task->fortnights()->attach($fortnights);
        $task->users()->attach($users);

        // Get the assigning user
        $assigningUser = request()->user();

        // Send email to assigned users
        foreach ($users as $userId) {
            $user = User::find($userId);
            Mail::to($user->email)->send(new TaskAssigned($task, $assigningUser));
        }

        return redirect()->route('tasks.show', $task)->with('status', 'Task has been successfully created.');
    }

    public function show(Task $task)
    {
        $task = $task->load('departments', 'users', 'kpis', 'subtasks');

        $users = $task->users()->orderBy('name', 'asc')->paginate(15);

        return view('tasks.show', compact('task', 'users'));
    }

    public function edit(Task $task)
    {
        if (request()->user()->cannot('manageTask', $task)) {
            abort(403);
        }

        $task = $task->load('days');

        $isDaily = $task->days()->exists();

        $forToday = $isDaily ? $task->days()->first()->date : null;

        $assignedUsers = $task->users()->pluck('users.id')->toArray();

        $targets = Target::get();

        $departments = Department::get();

        $parent_tasks = Task::where('is_subtask', false)->get();

        $users = request()->user()->hasROle('DEPARTMENT_HEAD') ? request()->user()->headOf->users : (request()->user()->hasRole('EMPLOYEE') ? [] : User::orderBy('name', 'asc')->get());

        $fortnights = Fortnight::get();

        return view('tasks.edit', compact('task', 'targets', 'parent_tasks', 'departments', 'users', 'fortnights', 'assignedUsers', 'forToday'));
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        /**
         * The manageTask is a custom made permission to check if the employee, department_head can affect the task (TaskPolicy.php)
         */
        if (request()->user()->cannot('manageTask', $task)) {
            abort(403);
        }
        /**
         * Most of the logic is listed in the store method
         */
        $data = $request->validated();
        $data['is_subtask'] = $data['parent_task_id'] ? true : false;

        $departments = request()->user()->hasAnyRole(['EMPLOYEE', 'DEPARTMENT_HEAD']) ? [0 => request()->user()->department->id] : $request['department_id'];
        $fortnights = $request['fortnight_id'];
        $users = request()->user()->hasRole('EMPLOYEE') ? [0 => request()->user()->id] : $request['user_id'];

        // Detach the existing relations with this 3 models and this this task in order to reset them based on what the user has adjusted
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
        
        if (request()->user()->cannot('manageTask', $task)) {
            abort(403);
        }
        
        if ($task->kpis()->exists() || $task->feedbacks()->exists()) {
            
            return redirect()->route('tasks.index')
                ->with('related', 'You can\'t Delete This pending Task it have feedback on it.');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('status', 'Task has been successfully Deleted.');
    }

    public function listByStatus($status)
    {
        $tasks = Task::where('status', $status)->get();

        if (count($tasks) > 0) {

            if (request()->user()->hasAnyRole(['DEPARTMENT_HEAD'])) {

                $headOf = request()->user()->load('headOf')->headOf;

                if ($headOf) {
                    $tasks = $headOf->tasks()->with(['target', 'departments'])->where('status', $status)->paginate(15);
                } else {
                    $tasks = Task::with(['target', 'departments'])->where('status', $status)->paginate(15);
                }
            } elseif (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN'])) {

                $tasks = Task::with(['target', 'departments'])->where('status', $status)->paginate(15);
            } else {

                $tasks = request()->user()->tasks()->with(['target', 'departments'])->where('status', $status)->paginate(15);
            }

            $currentFortnight = null;

            return view('tasks.index', compact('tasks', 'currentFortnight'));
        } else {
            return redirect()->route('index');
        }
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
