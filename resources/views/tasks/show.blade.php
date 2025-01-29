@extends('layouts.app')

@section('contents')

    <div class="container mt-5 pt-5">
        <!-- Task Details Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Task Details</h3>
                <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm float-end">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <!-- Task Pilar Name -->
                <h3 class="mb-3">
                    <i class="fas fa-book"></i>
                    <strong class="m-2 h2">Pilar Name:</strong>  
                    {{ $task->pilar_name }}
                </h3>

                <!-- Task Details -->
                <div class="row">
                    <div class="col-md-6">
                        <p><strong class="h4">Task Name:</strong> {{ $task->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong class="h4">Description:</strong> {{ $task->description }}</p>
                    </div>
                </div>

                <!-- Task Create Date -->
                <div class="row">
                    <div class="col-md-6">
                        <p><strong class="h4">Created At:</strong> {{ $task->created_at->format('d-m-Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong class="h4">Updated At:</strong> {{ $task->updated_at->format('d-m-Y') }}</p>
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
