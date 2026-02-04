<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::query();

        if ($request->filled('department_id')) {
            $query->where('id', $request->department_id);
        }

        $departments = $query->paginate(30); // Paginate with 10 records per page
        $allDepartments = Department::all(); // For dropdown filter

        return view('departments.index', compact('departments', 'allDepartments'));
    }

    public function create()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'SUPER_ADMIN');
        })->get();

        return view('departments.create', compact('users'));
    }

    public function store(DepartmentStoreRequest $request)
    {
        $data = $request->validated();

        // Check if a department head is assigned
        if ($data['department_head']) {
            $user = User::find($data['department_head']);

            // Prevent assigning SUPER_ADMIN as a department head
            if ($user->hasRole('SUPER_ADMIN')) {
                return redirect()->back()->withErrors([
                    'department_head' => 'SUPER_ADMIN cannot be assigned as a department head.',
                ])->withInput();
            }

            // Prevent assigning a user who is already a department head in another department
            if ($user->headOf()->exists()) {
                return redirect()->back()->withErrors([
                    'department_head' => 'The user is already a department head of "'.$user->headOf->department_name.'".',
                ])->withInput();
            }

            // Assign the user as DEPARTMENT_HEAD
            $user->roles()->detach(); // Remove existing roles
            $user->assignRole('DEPARTMENT_HEAD'); // Assign department head role
        }

        // Create the department
        $department = Department::create($data);

        // If a department head was assigned, also make them a member of the department
        if ($data['department_head']) {
            $user->department_id = $department->id;
            $user->save();
        }

        // Redirect with success message
        return redirect()->route('departments.index')->with('status', 'Department has been successfully created.');
    }

    public function edit(Department $department)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'SUPER_ADMIN');
        })->get();

        return view('departments.edit', compact('department', 'users'));
    }

    public function update(DepartmentUpdateRequest $request, Department $department)
    {
        $data = $request->validated();

        // Load the department's current department head
        $department = $department->load('departmentHead');

        // Check if the department head has changed
        if ($data['department_head'] && $data['department_head'] !== $department->department_head) {

            // Get the new department head user
            $user = User::find($data['department_head']);

            // Ensure the user is not a SUPER_ADMIN
            if ($user->hasRole('SUPER_ADMIN')) {
                return redirect()->back()->withErrors([
                    'department_head' => 'SUPER_ADMIN cannot be assigned as a department head.',
                ])->withInput();
            }

            // Ensure the user is not already assigned to another department
            if ($user->department()->exists()) {
                return redirect()->back()->withErrors([
                    'department_head' => 'The user is already a department head of "'.$user->headOf->department_name.'".',
                ])->withInput();
            }

            // Detach previous department head's roles, and assign them as an EMPLOYEE
            if ($department->department_head !== null) {
                $department->departmentHead->roles()->detach();
                $department->departmentHead->assignRole('EMPLOYEE');
            }

            // If the user is not the first user, assign them as DEPARTMENT_HEAD
            if (! $user->hasRole('SUPER_ADMIN')) {

                $user->roles()->detach(); // Remove any existing roles
                $user->assignRole('DEPARTMENT_HEAD'); // Assign department head role

            } else {
                return redirect()->back()->withErrors([
                    'department_head' => 'SUPER_ADMIN cannot be assigned as a department head.',
                ])->withInput();

            }
        }

        // Update the department details
        $department->update($data);

        // If the department head has been updated, assign the user to this department
        if ($data['department_head'] !== $department->department_head) {
            $user->department_id = $department->id; // Assign the department to the user
            $user->save(); // Save the user with the updated department_id
        }

        // Return with success status
        return redirect()->route('departments.index')->with('status', 'Department has been successfully updated.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        // Return with success status
        return redirect()->route('departments.index')->with('status', 'Department has been successfully Deleted.');
    }

    public function show(Department $department)
    {
        $head = User::find($department->department_head);

        return view('departments.show', compact('department', 'head'));
    }
}
