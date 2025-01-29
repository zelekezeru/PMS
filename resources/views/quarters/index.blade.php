@extends('layouts.app')

@section('contents')

<div class="container mt-3">
    <div class="card pt-5">
        <h2 class="card-header text-center">Quarters List</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="{{ route('quarters.create') }}">
                    Add New Quarter
                </a>
            </div>

            @include('quarters.list')

        </div>
    </div>
</div>

@endsection
