<style>
    .custom-dropdown-menu {
        background-color: #343a40; /* Matches the dark background of the table header */
        border-color: #454d55; /* Slightly lighter border to match the theme */
    }
    .custom-dropdown-menu .dropdown-item {
        color: #fff; /* White text to maintain readability */
    }
    .custom-dropdown-menu .dropdown-item:hover {
        background-color: #495057; /* Slightly lighter hover color */
    }
</style>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th class="d-flex align-items-center text-white">
                    <span class="me-2">Deliverable</span>
                </th>
                <th>Deadline</th>
                <th>Status</th>
                <th style="width: 10%; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($deliverables as $deliverable)
                <tr>
                    <td onclick="window.location='{{ route('deliverables.show', $deliverable->id) }}'">{{ ($deliverables->currentPage() - 1) * $deliverables->perPage() + $loop->iteration }}</td>
                    <td onclick="window.location='{{ route('deliverables.show', $deliverable->id) }}'">{{ $deliverable->name }}</td>
                    <td onclick="window.location='{{ route('deliverables.show', $deliverable->id) }}'">
                        @if ($deliverable->deadline)
                            {{ \Carbon\Carbon::parse($deliverable->deadline)->format('M d, Y') }}
                        @else
                            No Deadline
                        @endif
                    </td>
                    <td onclick="window.location='{{ route('deliverables.show', $deliverable->id) }}'">
                        @if ($deliverable->is_completed)
                            <span class="badge bg-success">Achieved</span>
                        @else
                            <span class="badge bg-danger">Not Achieved</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="form-button-action">
                            <a href="{{ route('deliverables.show', $deliverable->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('deliverables.edit', $deliverable->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $deliverable->id }})">
                                <i class="fa fa-times"></i>
                            </button>
                            <form id="delete-form-{{ $deliverable->id }}" action="{{ route('deliverables.destroy', $deliverable->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No deliverables found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
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
