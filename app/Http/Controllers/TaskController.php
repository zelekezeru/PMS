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
                $date = Day::where('date', $today)->first()->id;
            } else {
                $date = Day::create([
                    'fortnight_id' => $currentFortnight->id,
                    'date' => $today
                ])->id;
            }

            $tasks = $tasks->whereHas('days', function ($query) use ($date) {
                $query->where('days.id', $date);
            });

            $currentFortnight = null;
        }

        // Filtering and sorting
        $search = $request->query('search') ?? null;
        $status = $request->query('status') ?? null;
        $dueDays = is_numeric($request->query('due_days')) ? intval($request->query('due_days')) : null;
        $order = strtolower($request->query('order'));

        if ($search) {
            $tasks = $tasks->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('createdBy', function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        if ($status) {
            $tasks = $tasks->where('status', $status);
        }

        if ($dueDays) {
            $dueDate = Carbon::now()->addDays($dueDays);
            $tasks = $tasks->whereNotNull('due_date')->whereDate('due_date', '<=', $dueDate);
        }

        if (in_array($order, ['asc', 'desc'])) {
            $tasks = $tasks->orderBy('name', $order);
        }


        $tasks = $tasks->with(['target', 'departments', 'createdBy'])->paginate(10);

        return view('tasks.index', compact('tasks', 'currentFortnight'));
    }

    public function create(Request $request)
    {
        $targets = Target::get();

        $departments = (request()->user()->hasROle('DEPARTMENT_HEAD') ? [request()->user()->headOf] :  request()->user()->hasROle('EMPLOYEE')) ? [] : Department::get();

        $parent_tasks = Task::get();

        $users = request()->user()->hasROle('DEPARTMENT_HEAD') ? request()->user()->headOf->users :  (request()->user()->hasRole('EMPLOYEE') ? [] : User::get());

        $today = (bool) request()->query('dailyTask') === true ? Carbon::now()->format('Y-m-d') : null;

        $fortnights = Fortnight::get();

        $assignedUsers = [];

        $parent_task_id = $request->input('parent_task_id', null);

        $forToday = null;

        return view('tasks.create', compact('targets', 'parent_tasks', 'departments', 'users', 'fortnights', 'assignedUsers', 'parent_task_id', 'today', 'forToday'));
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
        elseif (request()->user()->hasRole('DEPARTMENT_HEAD')) {
            $task->departments()->attach($departments);
        }
        else {
            $task->departments()->attach($departments);
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

        $forToday = null;

        return view('tasks.edit', compact('task', 'targets', 'parent_tasks', 'departments', 'users', 'fortnights', 'assignedUsers', 'today', 'forToday'));
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
            $task->fortnights()->detach();
            $task->users()->detach();
        }


        unset($data['department_id']);
        unset($data['fortnight_id']);
        unset($data['user_id']);

        $task->update($data);

        if (!request()->user()->hasRole('EMPLOYEE')) {
            $task->departments()->attach($departments);
            $task->fortnights()->attach($fortnights);
            $task->users()->attach($users);
        }

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

        if(count($tasks) > 0)
        {

            if (request()->user()->hasAnyRole(['DEPARTMENT_HEAD'])) {

                $headOf = request()->user()->load('headOf')->headOf;

                if ($headOf) {
                    $tasks = $headOf->tasks()->with(['target', 'departments'])->where('status', $status)->paginate(10);
                } else {
                    $tasks = Task::with(['target', 'departments'])->where('status', $status)->paginate(10);
                }
            
            } else if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN'])) {
                
                $tasks = Task::with(['target', 'departments'])->where('status', $status)->paginate(10);
            
            } else {
                
                $tasks = request()->user()->tasks()->with(['target', 'departments'])->where('status', $status)->paginate(10);
            }

            $currentFortnight = null;

            return view('tasks.index', compact('tasks', 'currentFortnight'));
        }else{
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
