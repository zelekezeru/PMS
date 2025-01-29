@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">{{ $fortnight->quarter->quarter }} ({{ $fortnight->quarter->year->year }}) : Fortnight Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a class="btn btn-primary btn-sm" href="{{ route('fortnights.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered text-center">
                    <tr>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Date</th>
                    </tr>
                    <tr>
                        <th>Start Date:</th>
                        <td>{{ \Carbon\Carbon::parse($fortnight->start_date)->format('M - d - Y') }}</td>
                    </tr>
                    <tr>
                        <th>End Date:</th>
                        <td>{{ \Carbon\Carbon::parse($fortnight->end_date)->format('M - d - Y') }}</td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ \Carbon\Carbon::parse($fortnight->created_at)->format('M - d - Y') }}</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

@endsection
