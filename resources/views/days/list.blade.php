<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Year</th>
            <th>Quarter</th>
            <th>Fortnight</th>
            <th>Date</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($days as $index => $day)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $day->fortnight->quarter->year->year }}</td>
                <td>{{ $day->fortnight->quarter->quarter }}</td>
                <td>{{ \Carbon\Carbon::parse($day->fortnight->start_date)->format('M - d') }} to {{ \Carbon\Carbon::parse($day->fortnight->end_date)->format('M - d') }}</td>
                <td>{{ \Carbon\Carbon::parse($day->date)->format('M - d - Y') }}</td>
                <td class="text-center">
                    <a href="{{ route('days.show', $day->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('days.edit', $day->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('days.destroy', $day->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
