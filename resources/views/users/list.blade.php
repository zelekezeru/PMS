<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Approve</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th class="text-center" style="width: 40%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            @if (!$user->hasRole('SUPER_ADMIN'))
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($user->is_approved)
                            <p class="badge badge-success">Approved!</p>
                        @else
                            <a href="{{ route('users.waiting') }}"><p class="badge badge-warning">Waiting!</p>!</a>
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td class="text-center">
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" id="delete-form-{{ $user->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                    </td>
                </tr>
            @endif
            @empty
            <tr>
              <td colspan="3" class="text-center">No users found.</td>
            </tr>
            @endforelse
    </tbody>
  </table>
