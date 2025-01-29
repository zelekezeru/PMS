@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Year Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('years.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Year:</th>
                        <td>{{ $year->year }}</td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ $year->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At:</th>
                        <td>{{ $year->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </table>

                <h3 class="mt-4">Quarters</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Quarter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($year->quarters as $index => $quarter)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $quarter->quarter }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection
