@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Task Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('tasks.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#feedbackModal" data-task-id="{{ $task->id }}">
                        View Feedback
                    </button>

                    <tr>
                        <th>Task Title:</th>
                        <td>{{ $task->name }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $task->description }}</td>
                    </tr>
                    <tr>
                        <th>Target:</th>
                        <td>{{ $task->target ? $task->target->name : "Not Assigned Yet" }}</td>
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
                        <th>Status:</th>
                        @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']) || Auth::user()->tasks->contains($task->id))
                            @if ($task->status != 'Completed')
                                <td>
                                    <div class="col-6">
                                        <form action="{{ route('tasks.status', $task->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" id="status" class="form-control col-6 @error('status') is-invalid @enderror" optional>
                                                <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Progress" {{ $task->status == 'Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-arrows-spin"></i> Change</button>
                                        </form>
                                    </div>
                                </td>
                                @error('status')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <td class="badge badge-success me-4">Completed !</td>
                            @endif
                        @endif
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
                                    <strong>
                                        @can('view-departments')
                                            <a href="{{route('departments.show', $department)}}"> {{ $department->department_name }}, </a>
                                        @elsecan
                                            {{ $department->department_name }},
                                        @endcan
                                    </strong>
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
                </div>
            </div>
        </div>

        <div class="col">
            <a class="btn btn-success btn-sm mr-2" href="{{ route('kpis.create_task', ['task' => $task->id]) }}"><i class="fa fa-plus"></i> Add Taskx Indicators</a>
        </div>

        @if ($task->kpis)
            @php
                $kpis = $task->kpis;
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
<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Task Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="feedback-list">
                    <!-- Feedback will be loaded here dynamically -->
                </div>

                <!-- Add Feedback Form -->
                <form id="feedbackForm">
                    @csrf
                    <input type="hidden" id="task_id" name="task_id">
                    <input type="hidden" id="feedback_id" name="feedback_id"> <!-- For replies -->
                    <div class="mb-3">
                        <textarea id="comment" class="form-control" name="comment" placeholder="Write a comment..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
