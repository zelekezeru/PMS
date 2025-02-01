@extends('layouts.app')

@section('contents')
<div class="container mt-3">
    @if (session('status') === 'users-approved')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Users Approved!',
            text: 'Now they can login.',
            confirmButtonText: 'Okay'
        });
    </script>
    @endif

    <div class="card pt-5">
        <h2 class="card-header text-center">Waiting Users List</h2>
        <div class="card-body">
            <!-- Approve Button and Waiting Button at the Top -->
            <div class="mb-3 d-flex justify-content-between">
                <a href="{{ route('users.waiting') }}" class="btn btn-warning btn-sm">
                    <i class="fa fa-clock"></i> Waiting Users
                </a>
                <button class="btn btn-info btn-sm" type="submit">
                    Approve The Selected
                </button>
            </div>

            <form action="{{ route('users.approve') }}" method="POST">
                @method('PATCH')
                @csrf
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Approve</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <input type="checkbox" name="approve[]" value="{{ $user->id }}">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                  <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> View
                                </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection
