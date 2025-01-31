<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Quarter</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th class="text-center" style="width: 40%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fortnights as $fortnight)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $fortnight->quarter->quarter }}</td>
                <td>{{ \Carbon\Carbon::parse($fortnight->start_date)->format('M - d - Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($fortnight->end_date)->format('M - d - Y') }}</td>
                <td class="text-center" style="white-space: nowrap;">
                    <a href="{{ route('fortnights.show', $fortnight->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                    <a href="{{ route('fortnights.edit', $fortnight->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('fortnights.destroy', $fortnight->id) }}" method="POST" class="d-inline" id="delete-form-{{ $fortnight->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $fortnight->id }})">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
