<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApproveConfirmed;

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
            'approve' => 'required'
        ]);

        foreach ($request->approve as $key => $value) {

            $user = User::find($value);

            $user->is_approved = true;

            $user->is_active = true;

            $user->save();
        };

        return redirect()->route('users.index')->with('status', 'User has been successfully Approved.');
    }

    public function approved(Request $request, User $user)
    {
        
        $user->is_approved = true;
        $user->is_active = true;
        $user->save();
    
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

        $phone_end = substr($data['phone_number'], -4);
        
        // Set the default password
        $data['password'] = Hash::make('sits@' . $phone_end);

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
    public function show($id)
    {
        $user = User::find($id)->load('tasks', 'department');

        if ($user->hasRole('SUPER_ADMIN') && !request()->user()->hasRole('SUPER_ADMIN')) {
            return abort(403);
        }

        $tasks = $user->tasks()->paginate(15);

        $department = $user->department;

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        return view('users.show', compact('user', 'tasks', 'department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->hasRole('SUPER_ADMIN') && !request()->user()->hasRole('SUPER_ADMIN')) {
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
        $data = $request->all();
        
        // Get the department ID if provided
        $department = $data['department_id'] ?? null;
        
        $data['is_approved'] = $request->is_approved ? 1 : 0;
        $data['is_active'] = $request->is_active ? 1 : 0;

        // Check if the user is assigned as DEPARTMENT_HEAD (role_id = 3)
        
        if ($data['role_id'] == 'DEPARTMENT_HEAD') {
            // Ensure department is required for this role
            if ($department == null) {    dd($department);
                return redirect()->back()->withErrors(['department_id' => 'Department is required for this role.'])->withInput();
                }
            
            // Prevent a user from being assigned to multiple departments as head
            else if ($user->headOf()->exists()) {
                return redirect()->back()->withErrors([
                    'department_id' => 'The User is already a department head of "' . $user->headOf->department_name . '".'
                ])->withInput();
            } 

            else {
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

        if (!empty($data['role_id'])) {

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
        if ($user->hasRole('SUPER_ADMIN') ) {
            return redirect()->route('users.index')->with('status', 'not-allowed.');
        }

        if ($user->department()->exists() ) {

            $department = $user->department;

            if($user->id == $department->department_head)
            {
                return redirect()->route('users.index')
                ->with('related', 'Item-related');
            }

        }
        elseif($user->tasks()->exists())
        {
            return redirect()->route('users.index')
            ->with('related', 'Item-related');

        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'User has been successfully Removed.');

    }
}
