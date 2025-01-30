<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Department</th>
            <th>Description</th>
            <th class="text-center" style="width: 40%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($departments as $department)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $department->department_name }}</td>
                <td>{{ $department->description }}</td>
                <td class="text-center">
                    <a href="{{ route('departments.show', $department->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline" id="delete-form-{{ $department->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $department->id }})">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No departments found.</td>
            </tr>
        @endforelse
    </tbody>
</table>


<script>
    function confirmDelete(departmentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this department!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + departmentId).submit();
            }
        });
    }
</script>
