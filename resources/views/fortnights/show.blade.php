@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            @if ($fortnight->quarter && $fortnight->quarter->year)
            <h2 class="card-header text-center">{{ $fortnight->quarter->quarter }} ({{ $fortnight->quarter->year->year }}) : Fortnight Details</h2>
                
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

                @if(!request()->user()->hasRole('EMPLOYEE'))
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('fortnights.edit', $fortnight->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('fortnights.destroy', $fortnight->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this fortnight?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                @endif
                
            </div>
        </div>
        @if ($fortnight->tasks)
        @php
            $tasks = $fortnight->tasks;
        @endphp

        <div class="card-header">
            <h3 class="card-title mb-5">Tasks of this fortnight</h3>
        </div>

        @include('tasks.list')
    @else
        <div class="alert alert-warning mt-3">
            <p>No Tasks found for this fortnight.</p>
        </div>
    @endif
    </div>
@endsection
