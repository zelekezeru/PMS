@extends('layouts.app')

@section('contents')

    <div class="container mt-5 pt-5">
        <!-- Task Details Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Task Details</h3>
                <a href="{{ route('home.index') }}" class="btn btn-primary btn-sm float-end">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <!-- Task Title -->
                <h3 class="mb-3"><i class="fas fa-book"></i><strong class=" m-2 h2">Task Name:</strong>  {{ $task->name }}</h3>

                <!-- Task Details -->
                <div class="row">
                    <div class="col-md-6">
                        <p><strong class="h3">Task Description:</strong> {{ $task->description }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong class="h3">Target:</strong> {{ $task->target->name }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong class="h3">Starting Date:</strong> {{ \Carbon\Carbon::parse($task->starting_date)->format('M - d - Y') }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong class="h3">Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('M - d - Y') }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong class="h3">Budget:</strong> {{ $task->budget }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong class="h3">Barriers:</strong> {{ $task->barriers }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong class="h3">Communication:</strong> {{ $task->comunication }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong class="h3">Departments:</strong>
                                @if($task->departments && $task->departments->count() > 0)
                                    @foreach($task->departments as $department)
                                        <strong> -> </strong>{{ $department->department_name }},
                                    @endforeach
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong class="h3">Subtasks:</strong>
                                {{-- @if($task->is_subtask == 1)
                                    @foreach($task->subtasks as $subtask)
                                        <strong> -> </strong{{ $subtask->name }},
                                    @endforeach
                                @endif --}}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Edit and Delete buttons -->
                <div class="mt-4">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit Task
                    </a>

                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">
                            <i class="fas fa-trash"></i> Delete Task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
