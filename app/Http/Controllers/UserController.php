<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Display a listing of the resource.
     */
    public function waitingApproval()
    {
        $users = User::where('is_approved', false)->get();
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
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserUpdateRequest $request)
    {
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        
        return view('users.show', compact('user'));
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

        return redirect()->route('users.show', $user)->with('status', "user-updated");
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('SUPER_ADMIN')) {
            return redirect()->route('users.index')->with('status', 'not-allowed.');
        }
        $user->delete();

        return redirect()->route('users.index')->with('status', 'user-deleted.');
    }
}