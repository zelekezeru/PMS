@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Fortnight Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a class="btn btn-primary btn-sm" href="{{ route('fortnights.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Quarter:</th>
                        <td>{{ $fortnight->quarter->quarter }} ({{ $fortnight->quarter->year->year }})</td>
                    </tr>
                    <tr>
                        <th>Start Date:</th>
                        <td>{{ $fortnight->start_date }}</td>
                    </tr>
                    <tr>
                        <th>End Date:</th>
                        <td>{{ $fortnight->end_date }}</td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ $fortnight->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At:</th>
                        <td>{{ $fortnight->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

@endsection
