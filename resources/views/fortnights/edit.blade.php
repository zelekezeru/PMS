@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Edit Fortnight</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a class="btn btn-primary btn-sm" href="{{ route('fortnights.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                @include('fortnights.form', ['fortnight' => $fortnight])

            </div>
        </div>
    </div>

@endsection
