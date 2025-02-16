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
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssigned;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Fetch tasks based on roles
        if (request()->user()->hasAnyRole(['DEPARTMENT_HEAD'])) {

            $headOf = request()->user()->load('headOf')->headOf;

            $tasks = $headOf ? $headOf->tasks() : Task::query();
            
        } else if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN'])) {

            $tasks = Task::with(['target', 'departments']);
        } else {

            $tasks = request()->user()->tasks();
        }

        /** 
         * Fetch currentFortnight by checking to which fortnight the current day belongs to(we need it to fetch current)
         * 
         * we need the currentFortnight variable to fetch tasks of currentFortnight and 
         * 
         * to create Day just in case the current day doesnt exist
         * 
         * */
        $today = Carbon::now()->format('Y-m-d');

        $currentFortnight = $request->query('currentFortnight') || $request->query('onlyToday') ? Fortnight::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)->first() : null;

        // Only if The URL contains the currentFortnight or onlyToday
        if ($request->query('currentFortnight') || $request->query('onlyToday')) {

            /**
             * 
             * Filter by tasks by scopes 
             * Scopes refer to how long the task takes to complete...(for now)
             * 
             */
            $tasks = $this->filterByScope($tasks, $request, $currentFortnight, $today);
        }

        // This Filters the tasks as the user requested
        $tasks = $this->filterByColumns($tasks, $request);

        $tasks = $tasks->with(['target', 'departments', 'createdBy'])
        ->where('is_subtask', false)
        ->orderBy('created_at', 'desc')
        ->paginate(15);
    

        return view('tasks.index', compact('tasks', 'currentFortnight'));
    }

    public function create(Request $request)
    {
        $targets = Target::get();

        $departments = (request()->user()->hasROle('DEPARTMENT_HEAD') ? [request()->user()->headOf] :  request()->user()->hasROle('EMPLOYEE')) ? [] : Department::get();

        $parent_tasks = Task::get();

        $users = request()->user()->hasROle('DEPARTMENT_HEAD') ? request()->user()->headOf->users : (request()->user()->hasRole('EMPLOYEE') ? [] : User::get());

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
         * Sets assigned departments ($departments) to the department the logged in user belongs to if the role of the user is EMPLOYEE or DEPARMENT_HEAD 
         * But sets the assigned departments to what the logged in user requested to assign if the role is any other than the above(^)
         * 
         * sets the assigned users ($users) to the logged in user if the role is employee or sets it to the users the logged in user assigned if the role is otherwise
         */
    
        $departments = request()->user()->hasAnyRole(['EMPLOYEE', 'DEPARTMENT_HEAD']) ? [0 => request()->user()->department->id] : $request['department_id'];
        $fortnights = $request['fortnight_id'];
        $users = request()->user()->hasRole('EMPLOYEE') ? [0 => request()->user()->id] : $request['user_id'];

        // unsets(removes) fields from the $data array which dont belong to the tasks table
    
        unset($data['department_id']);
        unset($data['fortnight_id']);
        unset($data['user_id']);

        $task = Task::create($data);

        /** 
         * If the task created is daily the client form will send a query called forToday in the url
         * 
         * in that case we will fetch the current day from the database and attach it to the task that was just created and if the day doesnt exist we will create it
         * 
         */
    
        if ($request->query('forToday')) {

            $today = Carbon::now()->format('Y-m-d');

    
            $currentFortnightId = Fortnight::whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)->first()->id;

    
            $day = Day::firstOrCreate([
                'fortnight_id' => $currentFortnightId,
                'date' => $today
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
    
        return redirect()->route('tasks.index')->with('status', 'Task has been successfully created.');
    }
    
    public function show(Task $task)
    {
        $task = $task->load('departments', 'users', 'kpis', 'subtasks');

        $users = $task->users()->paginate(15);
        
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

        $users = request()->user()->hasROle('DEPARTMENT_HEAD') ? request()->user()->headOf->users : (request()->user()->hasRole('EMPLOYEE') ? [] : User::get());

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

        //Detach the existing relations with this 3 models and this this task in order to reset them based on what the user has adjusted
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

        if ($task->kpis()->exists() || $task->deliverables()->exists() || $task->feedbacks()->exists()) {
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
            } else if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN'])) {

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


    /**
     * 
     * Filters tasks base on the received $tasks and $requested
     * 
     * this function can filter using search, status and due_date
     * 
     */
    public function filterByColumns($tasks, $request)
    {

        $search = $request->query('search') ?? null;

        $status = $request->query('status') ?? null;

        $dueDays = is_numeric($request->query('due_days')) ? intval($request->query('due_days')) : null;

        $order = strtolower($request->query('order'));

        //Search Filter
        if ($search) {

            // This is a grouped query that lets the function search from task name and also their creator name
            $tasks = $tasks->where(function ($query) use ($search) {

                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('createdBy', function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        // This filters The tasks based on Status
        if ($status) {
            $tasks = $tasks->where('status', $status);
        }

        // This filters based on how many days is left before task expires (based on due date)
        if ($dueDays) {
            $dueDate = Carbon::now()->addDays($dueDays)->toDateString();
            $tasks = $tasks->whereNotNull('due_date')->whereDate('due_date', '<=', $dueDate);
        }

        // This adjusts the orders based on the name of the tasks
        if (in_array($order, ['asc', 'desc'])) {
            $tasks = $tasks->orderBy('name', $order);
        }

        // Return The query builder to the caller
        return $tasks;
    }

    /**
     * 
     * This Function is what enables us to filter currentFortnights or Daily Tasks
     * 
     */

    public function filterByScope($tasks, $request, $currentFortnight, $today)
    {
        /**
         * If There is ?currentFortnight=1 in the url we fetch the tasks of the current fortnight
         * If There is ?onlyToday=1 in the url we fetch the tasks of the current day
         */
        if ($request->query('currentFortnight')) {

            $currentFortnight = Fortnight::whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)->first();

            $tasks = $tasks->whereHas('fortnights', function ($query) use ($currentFortnight) {
                $query->where('fortnights.id', $currentFortnight->id);
            });
        } elseif ($request->query('onlyToday')) {

            // Check if the day exists and if it doesnt create the day
            if (Day::where('date', $today)->exists()) {
                $day = Day::where('date', $today)->first()->id;
            } else {
                $day = Day::create([
                    'fortnight_id' => $currentFortnight->id,
                    'date' => $today
                ])->id;
            }
            $tasks = $tasks->whereHas('days', function ($query) use ($day) {
                $query->where('days.id', $day);
            });
        }

        // Return the query builder
        return $tasks;
    }
}
