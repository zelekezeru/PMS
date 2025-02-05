<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Approve</th>
                            @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                                <th class="text-center" style="width: 20%;">Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            @if (!$user->hasRole('SUPER_ADMIN'))
                                <tr>
                                    <td onclick="window.location='{{ route('users.show', $user->id) }}'">{{ $loop->iteration }}</td>
                                    <td onclick="window.location='{{ route('users.show', $user->id) }}'">{{ $user->name }}</td>
                                    <td onclick="window.location='{{ route('users.show', $user->id) }}'">{{ $user->email }}</td>

                                    @if(count($user->roles) > 0)
                                        <td onclick="window.location='{{ route('users.show', $user->id) }}'">{{ $user->roles->pluck('name')->join(', ') }}</td>
                                    @else
                                        <td><p class="badge badge-info">Not Assigned</p></td>
                                    @endif

                                    <td>
                                        @if ($user->is_approved)
                                            <p class="badge badge-success">Approved!</p>
                                        @else
                                            <a href="{{ route('users.waiting') }}"><p class="badge badge-warning">Waiting!</p></a>
                                        @endif
                                    </td>
                                    @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                                        <td class="text-center">
                                            <div class="form-button-action">
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $user->id }})">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
