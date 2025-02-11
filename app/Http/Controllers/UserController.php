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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->user()->hasRole('DEPARTMENT_HEAD')) {
            $department = request()->user()->department;
            $users = $department ? $department->users()->paginate(15) : collect();
            
        } else {
            $users = User::paginate(15);
        }

        return view('users.index', compact('users'));
    }

    /**
     * Display a listing of the resource.
     */
    public function waitingApproval()
    {

        $users = User::where('is_approved', 0)->get();

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
    public function show($id)
    {
        $user = User::find($id)->load('tasks', 'department');
        if ($user->hasRole('SUPER_ADMIN') && !request()->user()->hasRole('SUPER_ADMIN')) {
            return abort(403);
        }

        $tasks = $user->tasks;

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
        $data = $request->validated();
        $data['is_approved'] = $request->is_approved ? 1 : 0;
        $data['is_active'] = $request->is_active ? 1 : 0;

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
