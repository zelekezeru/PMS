<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tasks.index') }}" method="GET">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="searchNames" class="form-label">Search Task</label>
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control"
                                id="searchNames"
                                name="search"
                                value="{{ request('search') ?? '' }}"
                                placeholder="Type and press Enter..."
                            />
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="selectStatus" class="form-label">Filter by Status</label>
                        <select class="form-select" id="selectStatus" name="status" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="progress" {{ request('status') == 'progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="dueDate" class="form-label">Due In (Days)</label>
                        <div class="input-group">
                            <span class="input-group-text">In</span>
                            <input type="number" class="form-control" id="dueDate" name="due_days" value="{{ request('due_days') ?? '' }}">
                            <span class="input-group-text">Days</span>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table id="add-row" class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>
                                <div class="d-flex justify-content-between align-items-center">
                                    Title
                                    <div class="d-flex flex-column align-items-center">
                                        <div>
                                            <a href="{{ route('tasks.index', array_merge(request()->query(), ['order' => 'asc'])) }}">
                                                <i class="fa fa-sort-up"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{ route('tasks.index', array_merge(request()->query(), ['order' => 'desc'])) }}">
                                                <i class="fa fa-sort-down"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Created By</th>
                            <th style="width: 8%; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td onclick="window.location='{{ route('tasks.show', $task->id) }}'">{{ $loop->iteration }}</td>
                                <td onclick="window.location='{{ route('tasks.show', $task->id) }}'">{{ $task->name }}</td>
                                <td onclick="window.location='{{ route('tasks.show', $task->id) }}'">{{ $task->status }}</td>
                                <td onclick="window.location='{{ route('tasks.show', $task->id) }}'">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M - d - Y').' ('.\Carbon\Carbon::parse($task->due_date)->format('D').')' : 'N/A' }}</td>
                                <td onclick="window.location='{{ route('tasks.show', $task->id) }}'">{{ $task->createdBy->name }}</td>
                                <td class="text-center">
                                    <div class="form-button-action">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-link btn-info" data-bs-toggle="tooltip" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        @can('manageTask', $task)
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-link btn-primary" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            @if ($task->status == 'Pending')
                                                <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $task->id }})">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            @endif
                                        @endcan

                                        @can('manageTask', $task)
                                            <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No tasks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('script')
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

        document.getElementById('searchNames').addEventListener('keydown', function (e) {
            if (e.key == 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
    </script>
@endsection
