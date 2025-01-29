@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Edit Day</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a class="btn btn-primary btn-sm" href="{{ route('days.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                @include('days.form', ['day' => $day])

            </div>
        </div>
    </div>

@endsection
