@extends('layouts.app')

@section('contents')

<div class="container mt-3">
    <div class="card pt-5">
        <h2 class="card-header text-center">Departments List</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="{{ route('departments.create') }}"><i class="fa fa-plus"></i> Add New Year</a>
            </div>

            @include('departments.list')

            <div class="mt-3">
                {{ $departments->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
