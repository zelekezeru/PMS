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
                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this department?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No departments found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
