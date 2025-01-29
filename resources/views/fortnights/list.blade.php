<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Quarter</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fortnights as $index => $fortnight)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $fortnight->quarter->quarter }}</td>
                <td>{{ $fortnight->start_date }}</td>
                <td>{{ $fortnight->end_date }}</td>
                <td class="text-center">
                    <a href="{{ route('fortnights.show', $fortnight->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('fortnights.edit', $fortnight->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('fortnights.destroy', $fortnight->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>