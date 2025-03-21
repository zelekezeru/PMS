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
            </div>
            
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>View</th>
                        <th>Approve</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td>

                                <a href="{{ route('users.approved', $user->id) }}" class="btn btn-success btn-sm me-2">
                                    <i class="fa-solid fa-user-check"> </i> Approve
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
        </div>
    </div>
</div>
@endsection
