@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">{{ $quarter->quarter }} ({{ $quarter->year->year }}) : Quarter Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('quarters.index') }}">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Start Date:</th>
                        <td>{{ \Carbon\Carbon::parse($quarter->start_date)->format('M - d - Y') }}</td>
                    </tr>
                    <tr>
                        <th>End Date:</th>
                        <td>{{ \Carbon\Carbon::parse($quarter->end_date)->format('M - d - Y') }}</td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ \Carbon\Carbon::parse($quarter->created_at)->format('M - d - Y') }}</td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('quarters.edit', $quarter->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('quarters.destroy', $quarter->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this quarter?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
