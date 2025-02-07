@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <img src="{{ auth()->user()->profile_image ? Storage::url(auth()->user()->profile_image) : asset('img/user.png') }}" 
                alt="Profile Image" style="width: 15%; border-radius: 50%; margin: 0 auto;">
            <h2 class="card-header text-center">
                User Details
            </h2>
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
                        @if($user->department_id != null)
                            <td>{{ $user->department->department_name }}</td>
                        @else
                            <td><p class="badge badge-info">Not Assigned</p></td>
                        @endif

                    </tr>

                    @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                        <tr>
                            <th>Role</th>
                            @if(count($user->roles) >0)
                                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                            @else
                                <td><p class="badge badge-info">Not Assigned</p></td>
                            @endif

                        </tr>
                    @endif
                </table>
                @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                    <div class="d-flex justify-content-end mt-4">
                        @if($user->is_approved == false)
                            <a href="{{ route('users.approved', $user->id) }}" class="btn btn-success btn-sm me-2">
                                <i class="fa-solid fa-user-check"> </i> Approve
                            </a>
                        @endif

                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">
                            <i class="fas fa-trash"></i> Delete
                        </button>

                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endif

            </div>
        </div>

        <div class="card pt-5">
            <h2 class="card-header text-center">Assigned Tasks</h2>
            @include('tasks.list')
        </div>

    </div>
@endsection
