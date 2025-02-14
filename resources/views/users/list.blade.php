<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>
                                <div class="d-flex justify-content-between align-items-center">
                                    Full Name
                                </div>
                            </th>
                            <th>Email</th>
                            <th>Department</th>
                            @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                                <th class="text-center" style="width: 20%;">Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                                <tr>
                                    <td onclick="window.location='{{ route('users.show', $user->id) }}'">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                    <td onclick="window.location='{{ route('users.show', $user->id) }}'" class="d-flex align-items-center">                                        
                                        @if ($user->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="rounded-circle mr-2" width="40" height="40">
                                        @else
                                            <span class="avatar-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        @endif
                                        <span class="ml-3">{{ $user->name }}</span>
                                        
                                    </td>
                                    <td onclick="window.location='{{ route('users.show', $user->id) }}'">{{ $user->email }}</td>

                                    <td onclick="window.location='{{ route('users.show', $user->id) }}'">                                        
                                        @if($user->department_id != null)
                                            {{ $user->department->department_name }}
                                        @else
                                            <p class="badge badge-info">Not Assigned</p>
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
