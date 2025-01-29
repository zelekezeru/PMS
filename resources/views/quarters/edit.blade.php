@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Edit Quarter</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('quarters.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
                @include('quarters.form', ['quarter' => $quarter])

            </div>
        </div>
    </div>

@endsection
