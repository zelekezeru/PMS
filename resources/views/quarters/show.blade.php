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
                </table>

                @if(!request()->user()->hasRole('DEPARTMENT_HEAD'))
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('quarters.edit', $quarter->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $quarter->id }})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        
                        <form id="delete-form-{{ $quarter->id }}" action="{{ route('quarters.destroy', $quarter->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>

                    </div>
                @endif
            </div>
        </div>


        @if ($quarter->fortnights)

            @php
                $fortnights = $quarter->fortnights()->paginate(15);
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Fortnights of this quarter</h3>
            </div>

            @include('fortnights.list')

        @else
            <div class="alert alert-warning mt-3">
                <p>No fortnights found for this quarter.</p>
            </div>
        @endif
    </div>

@endsection
