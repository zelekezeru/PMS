@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Days List</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('days.create') }}"><i class="fa fa-plus"></i> Add New Day</a>
                </div>

                @include('days.list')

            </div>
        </div>
    </div>

@endsection
