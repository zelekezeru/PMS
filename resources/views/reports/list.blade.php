<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Report Date</th>
            <th>Department</th>
            <th>User</th>
            <th>Target</th>
            <th>Schedule</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reports as $report)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $report->report_date }}</td>
                <td>{{ $report->department->department_name }}</td>
                <td>{{ $report->user->name }}</td>
                <td>{{ $report->target->name }}</td>
                <td>{{ $report->schedule }}</td>
                <td class="text-center">
                    <a href="{{ route('reports.show', $report->id) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i> View
                    </a>
                    <a href="{{ route('reports.edit', $report->id) }}" class="m-1 btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $report->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $report->id }}" action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <script>
                        function confirmDelete(reportId) {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "Once deleted, this report cannot be recovered!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#3085d6",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('delete-form-' + reportId).submit();
                                }
                            });
                        }
                    </script>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No reports found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
