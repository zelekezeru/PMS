<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\ApproveConfirmed;
use App\Models\Day;
use App\Models\Department;
use App\Models\Fortnight;
use App\Models\User;
use App\Services\FilterTasksService;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->user()->hasRole('DEPARTMENT_HEAD')) {
            $department = request()->user()->department;
            $users = $department->users()->paginate(25);
        } else {
            $users = User::paginate(25);
        }

        return view('users.index', compact('users'));
    }

    /**
     * Display a listing of the resource.
     */
    public function waitingApproval()
    {

        $users = User::where('is_approved', 0)->paginate(15);

        return view('users.waiting', compact('users'));
    }

    public function approve(Request $request)
    {
        $request->validate([
            'approve' => 'required',
        ]);

        foreach ($request->approve as $key => $value) {

            $user = User::find($value);

            $user->is_approved = true;

            $user->is_active = true;

            $user->save();
        }

        return redirect()->route('users.index')->with('status', 'User has been successfully Approved.');
    }

    public function approved(Request $request, User $user)
    {
        $user->is_approved = true;
        $user->is_active = true;
        $user->save();

        // Generate the login link
        $loginLink = route('login');

        // Send the approval email with the login link
        Mail::to($user->email)->send(new ApproveConfirmed($loginLink));

        return redirect()->route('users.index')->with('status', 'User has been successfully Approved.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User;

        $roles = Role::all();

        $departments = Department::get();

        return view('users.create', compact('user', 'departments', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make('pms@SITS');
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $data['is_approved'] = $request->is_approved ? 1 : 0;
        $data['is_active'] = $request->is_active ? 1 : 0;
        $user = User::create($data);
        $user->assignRole('EMPLOYEE');

        if ($data['is_approved']) {
            return redirect()->route('users.index')->with('status', 'User has been successfully created.');
        }

        return redirect()->route('users.waiting')->with('status', 'User has been successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        // Attempt to find the user
        $user = User::with('tasks', 'department')->find($id);

        if (! $user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        // Prevent unauthorized access to SUPER_ADMIN data
        if ($user->hasRole('SUPER_ADMIN') && ! $request->user()->hasRole('SUPER_ADMIN')) {
            return abort(403);
        }

        // Set selected date from query or use today's date
        $selectedDate = $request->query('date', Carbon::today()->format('Y-m-d'));
        $day = Day::whereDate('date', $selectedDate)->first();

        // Set current or requested fortnight
        $fortnight = $request->query('fortnight')
            ? Fortnight::find($request->query('fortnight'))
            : Fortnight::currentFortnight();

        // Initialize task counts to avoid undefined variables
        $fortnightPendingTasks = $fortnightInProgressTasks = $fortnightCompletedTasks = 0;
        $dailyPendingTasks = $dailyInProgressTasks = $dailyCompletedTasks = 0;

        if ($fortnight) {
            $fortnightPendingTasks = $user->tasks()->where('status', 'Pending')
                ->whereHas('fortnights', fn($q) => $q->where('fortnights.id', $fortnight->id))
                ->count();

            $fortnightInProgressTasks = $user->tasks()->where('status', 'Progress')
                ->whereHas('fortnights', fn($q) => $q->where('fortnights.id', $fortnight->id))
                ->count();

            $fortnightCompletedTasks = $user->tasks()->where('status', 'Completed')
                ->whereHas('fortnights', fn($q) => $q->where('fortnights.id', $fortnight->id))
                ->count();
        }

        if ($day) {
            $dailyPendingTasks = $user->tasks()->where('status', 'Pending')
                ->whereHas('days', fn($q) => $q->where('days.id', $day->id))
                ->count();

            $dailyInProgressTasks = $user->tasks()->where('status', 'Progress')
                ->whereHas('days', fn($q) => $q->where('days.id', $day->id))
                ->count();

            $dailyCompletedTasks = $user->tasks()->where('status', 'Completed')
                ->whereHas('days', fn($q) => $q->where('days.id', $day->id))
                ->count();
        }

        // Overall task stats
        $allPendingTasks = $user->tasks()->where('status', 'Pending')->count();
        $allInProgressTasks = $user->tasks()->where('status', 'Progress')->count();
        $allCompletedTasks = $user->tasks()->where('status', 'Completed')->count();

        // Get department
        $department = $user->department;

        // Apply filtering
        $tasksQuery = $user->tasks(); // base query
        $filterTasksService = new FilterTasksService;
        [$tasksQuery] = $filterTasksService->filterByScope($tasksQuery, $request);
        $tasksQuery = $filterTasksService->filterByColumns($tasksQuery, $request);
        $tasks = $tasksQuery->paginate(15);

        $fortnights = Fortnight::latest()->take(15)->get();

        // Return view with all necessary data
        return view('users.show', compact(
            'user',
            'tasks',
            'department',
            'fortnights',
            'fortnight',
            'allPendingTasks',
            'allInProgressTasks',
            'allCompletedTasks',
            'fortnightPendingTasks',
            'fortnightInProgressTasks',
            'fortnightCompletedTasks',
            'dailyPendingTasks',
            'dailyInProgressTasks',
            'dailyCompletedTasks'
        ));
    }

    public function printableReport(Request $request, Fortnight $fortnight)
    {
        // $fortnightStartDate = Fortnight::currentFortnight()->start_date;
        $fortnight = $fortnight ? $fortnight : Fortnight::currentFortnight();
        $fortnightId = $fortnight->id;
        $users = User::withCount([
            'tasks as all_tasks' => function ($query) use ($fortnightId) {
                $query->whereHas('fortnights', function ($q) use ($fortnightId) {
                    $q->where('fortnights.id', $fortnightId);
                });
            },

            'tasks as pending_tasks' => function ($query) use ($fortnightId) {
                $query->where('status', 'pending')
                    ->whereHas('fortnights', function ($q) use ($fortnightId) {
                        $q->where('fortnights.id', $fortnightId);
                    });
            },
            'tasks as progress_tasks' => function ($query) use ($fortnightId) {
                $query->where('status', 'progress')
                    ->whereHas('fortnights', function ($q) use ($fortnightId) {
                        $q->where('fortnights.id', $fortnightId);
                    });
            },
            'tasks as completed_tasks' => function ($query) use ($fortnightId) {
                $query->where('status', 'completed')
                    ->whereHas('fortnights', function ($q) use ($fortnightId) {
                        $q->where('fortnights.id', $fortnightId);
                    });
            },

        ])->get();

        // Load the Blade view into DomPDF
        $pdf = PDF::loadView('users.printableReport', [
            'users' => $users,
            'fortnight' => $fortnight,
        ]);

        return $pdf->download('Fortnight_Tasks_Report.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->hasRole('SUPER_ADMIN') && ! request()->user()->hasRole('SUPER_ADMIN')) {
            return abort(403);
        }

        $roles = Role::all();

        $departments = Department::all();

        return view('users.edit', compact('roles', 'departments', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        // Get the department ID if provided
        $department = $data['department_id'] ?? null;

        $data['is_approved'] = $request->is_approved ? 1 : 0;
        $data['is_active'] = $request->is_active ? 1 : 0;

        // Check if the user is assigned as DEPARTMENT_HEAD (role_id = 3)
        if ($data['role_id'] == 3) {
            // Ensure department is required for this role
            if ($department === null) {
                return redirect()->back()->withErrors(['department_id' => 'Department is required for this role.'])->withInput();
            }

            // Prevent a user from being assigned to multiple departments as head
            elseif ($user->headOf()->exists()) {
                return redirect()->back()->withErrors([
                    'department_id' => 'The User is already a department head of "' . $user->headOf->department_name . '".',
                ])->withInput();
            } else {
                // Find the department
                $department = Department::find($data['department_id']);

                // If the department already has a different head, downgrade that head to 'EMPLOYEE'
                if ($department->department_head !== null && $department->department_head != $user->id) {
                    $department->departmentHead->assignRole('EMPLOYEE'); // Remove department head role from the current head
                }

                // Assign the user as the new department head
                $department->department_head = $user->id;

                $department->save();
            }
        }

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->update($data);

        if (! empty($data['role_id'])) {

            $user->roles()->detach();

            $role = Role::findById($data['role_id']);

            $user->assignRole($role);
        }

        return redirect()->route('users.show', $user)->with('status', 'User has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('SUPER_ADMIN')) {
            return redirect()->route('users.index')->with('status', 'not-allowed.');
        }

        if ($user->department()->exists()) {

            $department = $user->department;

            if ($user->id == $department->department_head) {
                return redirect()->route('users.index')
                    ->with('related', 'Item-related');
            }
        } elseif ($user->tasks()->exists()) {
            return redirect()->route('users.index')
                ->with('related', 'Item-related');
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'User has been successfully Removed.');
    }
}
