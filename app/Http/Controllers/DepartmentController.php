<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(10);

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $users = User::get();
        return view('departments.create', compact('users'));
    }

    public function store(DepartmentStoreRequest $request)
    {
        $data = $request->validated();

        if ($data['department_head']) {
            $user = User::find($data['department_head']);
            $user->roles()->detach();
            $user->assignRole('DEPARTMENT_HEAD');
        }

        Department::create($data);

        // Return with success status
        return redirect()->route('departments.index')->with('status', 'created');
    }

    public function edit(Department $department)
    {
        $users = User::get();

        return view('departments.edit', compact('department', 'users'));
    }

    public function update(DepartmentUpdateRequest $request, Department $department)
    {
        $data = $request->validated();
        if ($data['department_head'] !== $department->department_head) {
            $department->departmentHead->roles()->detach();
            $department->departmentHead->assignRole('EMPLOYEE');

            $user = User::find($data['department_head']);
            $user->roles()->detach();
            $user->assignRole('DEPARTMENT_HEAD');
        }

        $department->update($data);

        // Return with success status
        return redirect()->route('departments.index')->with('status', 'updated');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        // Return with success status
        return redirect()->route('departments.index')->with('status', 'deleted');
    }

    public function show(Department $department)
    {
        $head = User::find($department->department_head);

        return view('departments.show', compact('department', 'head'));
    }
}
