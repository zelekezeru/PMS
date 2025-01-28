@extends('layouts.app')

@section('contents')

    <div class="container mt-5 pt-5">
        <!-- Strategie Details Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">task Details</h3>
                <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm float-end">Back to tasks</a>
            </div>
            <div class="card-body">
                <!-- Strategie Title -->
                <h3 class="mb-3"><i class="fas fa-book"></i><strong class=" m-2 h2">Pilar Name:</strong>  {{ $task->pilar_name }}</h3>

                <!-- task Details -->
                <div class="row">
                    <div class="col-md-6">
                        <p><strong class="h3">Name:</strong> {{ $task->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong class="h3">Description:</strong> {{ $task->description }}</p>
                    </div>
                </div>

                <!-- Edit and Delete buttons -->
                <div class="mt-4">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit task
                    </a>

                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this strategie?')">
                            <i class="fas fa-trash"></i> Delete task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection