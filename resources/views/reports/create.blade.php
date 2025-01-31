@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">Create New Report</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-primary btn-sm" href="{{ route('reports.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>

                @include('reports.form', [
                    'action' => route('reports.store'),
                    'method' => 'POST',
                    'report' => null,
                    'buttonText' => 'Create'
                ])
            </div>
        </div>
    </div>

@endsection
