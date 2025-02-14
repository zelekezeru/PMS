@extends('layouts.app')

@section('contents')

<div class="container mt-3">
    <div class="card pt-5">
        @if ($fortnight->quarter && $fortnight->quarter->year)
        <h2 class="card-header text-center">{{ $fortnight->quarter->quarter }} ({{ $fortnight->quarter->year->year }}) :
            Fortnight Details</h2>

        @endif
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary btn-sm mb-3" href="{{ route('fortnights.index') }}">
                    <i class="fa fa-arrow-left"></i> Back to List
                </a>
            </div>

            <table class="table table-bordered">
                <tr>
                    <th>Start Date:</th>
                    <td>{{ \Carbon\Carbon::parse($fortnight->start_date)->format('M - d - Y') }}</td>
                </tr>
                <tr>
                    <th>Due Date:</th>
                    <td>{{ \Carbon\Carbon::parse($fortnight->end_date)->format('M - d - Y') }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end mt-4">
                @can('edit-fortnights')
                <a href="{{ route('fortnights.edit', $fortnight->id) }}" class="btn btn-warning btn-sm me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endcan
                @can('delete-fortnights')
                <form action="{{ route('fortnights.destroy', $fortnight->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this fortnight?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>

                @endcan
            </div>

        </div>
    </div>
    @if ($fortnight->tasks)
    @php
    $tasks = $fortnight->tasks()->paginate(15);
    @endphp

    <div class="card-header">
        <h3 class="card-title mb-5">Tasks of this fortnight</h3>
    </div>

    @include('tasks.list')

    <div class="d-flex justify-content-start mt-3">
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createDeliverableModal">
            <i class="fas fa-plus"></i> Add Deliverable
        </button>
    </div>
    
    @include('deliverables.list')
    @else
    <div class="alert alert-warning mt-3">
        <p>No Tasks found for this fortnight.</p>
    </div>
    @endif
</div>
@endsection

{{-- Deliverable create form modal --}}

<div class="modal fade" id="createDeliverableModal" tabindex="-1" aria-labelledby="createDeliverableLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDeliverableLabel">Create Deliverable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('deliverables.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="fortnight_id" value="{{ $fortnight->id }}">

                    <div class="mb-3">
                        <label for="name" class="form-label">Deliverable Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" min="{{ $fortnight->start_date }}" max="{{$fortnight->end_date}}" class="form-control" name="deadline">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Deliverable</button>
                </div>
            </form>
        </div>
    </div>
</div>