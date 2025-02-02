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
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->user()->hasRole('DEPARTMENT_HEAD')) {
            $users = request()->user()->headOf->users()->paginate(15);

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

        return redirect()->route('users.index')->with('status', 'users-approved');
    }

    public function approved(Request $request, User $user)
    {
        // $request->validate([
        //     'approve' => 'required|boolean'
        // ]);

        $user->is_approved =  1;
        $user->is_active =  1;
        $user->save();

        return redirect()->route('users.index')->with('status', 'user-approved');
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['pms@SITS'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.waiting')->with('status', "user-updated");

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id)->load('tasks', 'department');

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

        $user->update($data);

        if ($data['role_id']) {
            $user->roles()->detach();
            $role = Role::findById($data['role_id']);
            $user->assignRole($role);
        }

        return redirect()->route('users.show', $user)->with('status', "user-updated");
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

        return redirect()->route('users.index')->with('status', 'Item-related.');

    }
}
