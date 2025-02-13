<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="add-row" class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Report Date</th>
                            <th>Department</th>
                            <th>User</th>
                            <th>Target</th>
                            <th>Schedule</th>
                            <th style="width: 10%; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td onclick="window.location='{{ route('reports.show', $report->id) }}'">{{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}</td>
                                <td onclick="window.location='{{ route('reports.show', $report->id) }}'">{{ $report->report_date }}</td>
                                <td onclick="window.location='{{ route('reports.show', $report->id) }}'">{{ $report->department->department_name }}</td>
                                <td onclick="window.location='{{ route('reports.show', $report->id) }}'">{{ $report->user->name }}</td>
                                <td onclick="window.location='{{ route('reports.show', $report->id) }}'">{{ $report->target }}</td>
                                <td onclick="window.location='{{ route('reports.show', $report->id) }}'">{{ $report->schedule }}</td>
                                <td class="text-center">
                                    <div class="form-button-action">
                                        <a href="{{ route('reports.show', $report->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $report->id }})">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <form id="delete-form-{{ $report->id }}" action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
