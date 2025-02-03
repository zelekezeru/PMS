<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    
    public function index(Request $request)
    {
        $query = Department::query();
    
        if ($request->filled('department_id')) {
            $query->where('id', $request->department_id);
        }
    
        $departments = $query->paginate(10); // Paginate with 10 records per page
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

        if ($data['department_head']) {
            $user = User::find($data['department_head']);
            if ($user->id != User::first()->id) {
                $user->roles()->detach();
                $user->assignRole('DEPARTMENT_HEAD');
            } else {
                return redirect()->back();
            }
        }

        Department::create($data);

        // Return with success status
        return redirect()->route('departments.index')->with('status', 'created');
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
        $department = $department->load('departmentHead');
        if ($data['department_head'] !== $department->department_head) {
            if ($department->department_head !== null ) {
                $department->departmentHead->roles()->detach();
                $department->departmentHead->assignRole('EMPLOYEE');
            }

            $user = User::find($data['department_head']);
            if ($user->id != User::first()->id) {
                $user->roles()->detach();
                $user->assignRole('DEPARTMENT_HEAD');
            } else {
                return redirect()->back();
            }
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
