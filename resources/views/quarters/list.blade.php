<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Year</th>
            <th>Quarter</th>
            <th class="text-center" style="width: 40%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quarters as $quarter)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $quarter->year->year }}</td>
                <td>{{ $quarter->quarter }}</td>
                <td class="text-center" style="white-space: nowrap;">
                    <a href="{{ route('quarters.show', $quarter->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                    <a href="{{ route('quarters.edit', $quarter->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('quarters.destroy', $quarter->id) }}" method="POST" class="d-inline" id="delete-form-{{ $quarter->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $quarter->id }})">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
