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
        $user = User::find($id)->load('tasks', 'department');
        if ($user->hasRole('SUPER_ADMIN') && ! request()->user()->hasRole('SUPER_ADMIN')) {
            return abort(403);
        }
        $selectedDate = $request->query('date') ? $request->query('date') : Carbon::today()->format('Y-m-d');

        $day = Day::whereDate('date', $selectedDate)->first();
        
        if(! $day) {
            return redirect(route('users.show', $user))->with('status', 'No Tasks Found');
        }
        
        $fortnight = $request->query('fortnight') ? Fortnight::where('id', $request->query('fortnight'))->first() : Fortnight::currentFortnight();

        if(! $fortnight) {
            return redirect(route('users.show', $user))->with('status', 'No Tasks Found');
        }
        
        $allPendingTasks = $user->tasks()->where('status', 'Pending')->count();
        $allInProgressTasks = $user->tasks()->where('status', 'Progress')->count();
        $allCompletedTasks = $user->tasks()->where('status', 'Completed')->count();

        $fortnightPendingTasks = $user->tasks()->where('status', 'Pending')->whereHas('fortnights', function ($query) use ($fortnight) {
            $query->where('fortnights.id', $fortnight->id);
        })->count();

        $fortnightInProgressTasks = $user->tasks()->where('status', 'Progress')->whereHas('fortnights', function ($query) use ($fortnight) {
            $query->where('fortnights.id', $fortnight->id);
        })->count();

        $fortnightCompletedTasks = $user->tasks()->where('status', 'Completed')->whereHas('fortnights', function ($query) use ($fortnight) {
            $query->where('fortnights.id', $fortnight->id);
        })->count();

        $dailyPendingTasks = $user->tasks()->where('status', 'Pending')->whereHas('days', function ($query) use ($day) {
            $query->where('days.id', $day->id);
        })->count();

        $dailyInProgressTasks = $user->tasks()->where('status', 'Progress')->whereHas('days', function ($query) use ($day) {
            $query->where('days.id', $day->id);
        })->count();

        $dailyCompletedTasks = $user->tasks()->where('status', 'Completed')->whereHas('days', function ($query) use ($day) {
            $query->where('days.id', $day->id);
        })->count();

        $department = $user->department;
        $tasks = $user->tasks();

        // Check tasks index and also the Service to understand how this functions work
        $filterTasksService = new FilterTasksService;

        [$tasks] = $filterTasksService->filterByScope($tasks, $request);
        $tasks = $filterTasksService->filterByColumns($tasks, $request);
        $tasks = $tasks->paginate(15);
        $fortnights = Fortnight::latest()->take(15)->get();

        if (! $user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        return view('users.show', compact('user', 'tasks', 'department','fortnights', 'fortnight', 'allPendingTasks', 'allInProgressTasks', 'allCompletedTasks', 'fortnightPendingTasks', 'fortnightInProgressTasks', 'fortnightCompletedTasks', 'dailyPendingTasks', 'dailyInProgressTasks', 'dailyCompletedTasks'));
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
                    'department_id' => 'The User is already a department head of "'.$user->headOf->department_name.'".',
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
