@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Add New User</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>

                @include('users.form', [
                    'action' => route('users.store'),
                    'method' => 'POST',
                    'buttonText' => 'Create'
                ])
            </div>
        </div>
    </div>

@endsection
