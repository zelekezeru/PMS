<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Year</th>
            <th class="text-center" style="width: 40%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($years as $year)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $year->year }}</td>
                <td class="text-center">
                    <a href="{{ route('years.show', $year->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                    <a href="{{ route('years.edit', $year->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <form action="{{ route('years.destroy', $year->id) }}" method="POST" class="d-inline" id="delete-form-{{ $year->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $year->id }})">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No years found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
