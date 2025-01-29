<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Budget</th>
                <th>Responsibilities</th>
                <th>Barriers</th>
                <th>Communication</th>
                <th>Is Subtask</th>
                <th>Parent Task</th>
                <th>Starting Date</th>
                <th>Due Date</th>
                <th>Target</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->budget }}</td>
                    <td>{{ $task->responsibilities }}</td>
                    <td>{{ $task->barriers }}</td>
                    <td>{{ $task->comunication }}</td>
                    <td>{{ $task->is_subtask ? 'Yes' : 'No' }}</td>
                    <td>{{ $task->parent_task->name ?? 'None' }}</td>
                    <td>{{ $task->starting_date }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->target->name }}</td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="m-1 btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <a href="{{ route('tasks.show', $task->id) }}" class="m-1 btn btn-primary btn-sm"><i class="fa fa-book"></i> Show</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="m-1 btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="13" class="text-center">No tasks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>