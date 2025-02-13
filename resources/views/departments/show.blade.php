@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Department Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('departments.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Department Name:</th>
                        <td>{{ $department->department_name }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $department->description }}</td>
                    </tr>
                    <tr>
                        <th>Department Head:</th>
                        <td>
                            @if ($department->departmentHead)
                                @can('view-strategies')
                                    <a href="{{route('users.show', $department->departmentHead->id)}}"> {{ $department->departmentHead->name }} </a>
                                @elsecan
                                    {{ $department->departmentHead->name }},
                                @endcan
                            @else
                                Not Assigned To Any
                            @endif

                        </td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <button type="button" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $department->id }}" action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>

            </div>
        </div>


        @if ($department->users)

            @php
                $users = $department->users()->paginate(15);
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Users of this Department</h3>
            </div>

            @include('users.list')

        @else
            <div class="alert alert-warning mt-3">
                <p>No users found for this Department.</p>
            </div>
        @endif
    </div>

@endsection
