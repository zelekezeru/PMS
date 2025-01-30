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
        <h2 class="card-header text-center">Users List</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Add New Year</a>
            </div>

            <form action="{{ route('users.approve') }}" method="post">
              @method('PATCH')
            @csrf
              <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Approve</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th  style="width: 40%;">Status</th>
                        <th class="text-center" style="width: 40%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                              <input type="checkbox" name="approve[]" value="{{$user->id}}" id="">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td class="text-center">
                                <p class="btn btn-info btn-sm"><i class="fa fa-eye"></i>Not Approved</p>
                            </td>
                            <td class="text-center">
                              <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                              {{-- <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="m-1 btn  btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                      <i class="fa fa-trash"></i> Delete
                                  </button>
                              </form> --}}
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="3" class="text-center">No users found.</td>
                        </tr>
                        @endforelse
                        <tr>
                            <td></td>
                            <td>
                              <button class="btn btn-info btn-sm" type="submit">Approve The Selected</button>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                </tbody>
              </table>
            
            </form>

        </div>
    </div>
</div>

@endsection
