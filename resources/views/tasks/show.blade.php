@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Pillar Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('tasks.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Pillar:</th>
                        <td>{{ $task->name }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $task->description }}</td>
                    </tr>
                    <tr>
                        <th>Target:</th>
                        <td>{{ $task->target->name }}</td>
                    </tr>
                    <tr>
                        <th>Starting Date:</th>
                        <td>{{ \Carbon\Carbon::parse($task->starting_date)->format('M - d - Y') }}</td>
                    </tr>
                    <tr>
                        <th>Due Date:</th>
                        <td>{{ \Carbon\Carbon::parse($task->due_date)->format('M - d - Y') }}</td>
                    </tr>
                    <tr>
                        <th>Budget:</th>
                        <td>{{ $task->budget }}</td>
                    </tr>
                    <tr>
                        <th>Barriers:</th>
                        <td>{{ $task->barriers }}</td>
                    </tr>
                    <tr>
                        <th>Comunication:</th>
                        <td>{{ $task->comunication }}</td>
                    </tr>
                    <tr>
                        <th>Departments:</th>
                        <td>
                            @if($task->departments && $task->departments->count() > 0)
                                @foreach($task->departments as $department)
                                    {{ $department->department_name }}
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $task->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <script>
                        function confirmDelete(taskId) {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "Once deleted, this task cannot be recovered!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#3085d6",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('delete-form-' + taskId).submit();
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>

        @if ($task->kpis)
            @php
                $kpis = $task->name;
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">KPIs of this task</h3>
            </div>

            @include('kpis.list')
        @else
            <div class="alert alert-warning mt-3">
                <p>No KPIs found for this task.</p>
            </div>
        @endif
    </div>

@endsection
