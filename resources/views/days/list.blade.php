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
                <td>{{ $days->firstItem() + $index }}</td> <!-- Works with pagination -->
                <td>{{ $day->fortnight->quarter->year->year }}</td>
                <td>{{ $day->fortnight->quarter->quarter }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($day->fortnight->start_date)->format('M d') }} -
                    {{ \Carbon\Carbon::parse($day->fortnight->end_date)->format('M d, Y') }}
                </td>
                <td>{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</td>
                <td class="text-center">
                    <a href="{{ route('days.show', $day->id) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i> View
                    </a>
                    <a href="{{ route('days.edit', $day->id) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('days.destroy', $day->id) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
