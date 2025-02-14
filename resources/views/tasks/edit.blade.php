@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">Edit task</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-primary btn-sm" href="{{ route('tasks.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>

                @include('tasks.form', [
                    'action' => route('tasks.store', ),
                    'action' => route('tasks.update', $task->id),
                    'method' => 'PUT',
                    'task' => $task,
                    'buttonText' => 'Update'
                ])
            </div>
        </div>
    </div>

@endsection
