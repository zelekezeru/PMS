<x-admin-layout>
    <div class="container topCard pt-5">
        <div class="card mt-5 ">
            <h2 class="card-header text-center">List of Tasks</h2>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-success btn-sm" href="{{ route('tasks.create') }}">
                        <i class="fa fa-plus"></i> Create New Task
                    </a>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="80px">No</th>
                                <th>Title</th>
                                <th>Duration (hours)</th>
                                <th>Budget</th>
                                <th>Status</th>
                                <th width="250px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->duration ?? 'N/A' }}</td>
                                    <td>${{ number_format($task->budget, 2) }}</td>
                                    <td>{{ $task->status }}</td>
                                    <td class="d-flex">
                                        <a class="btn btn-info btn-sm mx-2" href="{{ route('tasks.show', $task->id) }}">
                                            <i class="fa-solid fa-list"></i> Show
                                        </a>
                                        <a class="btn btn-primary btn-sm mx-2" href="{{ route('tasks.edit', $task->id) }}">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="mx-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">There are no tasks available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {!! $tasks->links() !!}

            </div>
        </div>
    </div>
</x-admin-layout>
