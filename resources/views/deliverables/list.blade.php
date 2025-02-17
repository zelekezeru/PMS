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
                    <td>{{ ($deliverables->currentPage() - 1) * $deliverables->perPage() + $loop->iteration }}</td>
                    <td>{{ $deliverable->name }}</td>
                    <td>
                        @if ($deliverable->deadline)
                            {{ \Carbon\Carbon::parse($deliverable->deadline)->format('M d, Y') }}
                        @else
                            No Deadline
                        @endif
                    </td>

                        @if ($deliverable->is_completed)
                            <td class="badge badge-success me-4">Completed !</td>              
                        @else
                                    
                            <td>
                                <form action="{{ route('deliverables.status', $deliverable->id) }}" method="POST" enctype="multipart/form-data" class="status-form">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" style="border: 2px solid black;"  class="form-control @error('status') is-invalid @enderror" onchange="this.form.submit()">
                                        <option value="Pending" {{ $deliverable->is_completed == null ? 'selected' : '' }}>Not Completed</option>
                                        <option value="Completed" {{ $deliverable->is_completed == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                                @error('status')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                        @endif
                    <td class="text-center">
                        <div class="form-button-action">
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
