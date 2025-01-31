@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">User Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('users.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Name:</th>
                        <td>{{ $user->name }}</td>
                    </tr>

                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>


                    <tr>
                        <th>Phone number:</th>
                        <td>{{ $user->phone_number }}</td>
                    </tr>

                    <tr>
                        <th>Department:</th>
                        <td>{{ $user->department->department_name }}</td>
                    </tr>

                    <tr>
                        <th>Created At:</th>
                        <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </table>

            </div>
        </div>

        <div class="card pt-5">
            <h2 class="card-header text-center">Assigned Tasks</h2>
            @include('tasks.list')
        </div>

    </div>
@endsection
