@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">Edit Strategy</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-primary btn-sm" href="{{ route('strategies.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>

                @include('strategies.form', [
                    'action' => route('strategies.update', $strategy->id),
                    'method' => 'PUT',
                    'strategy' => $strategy,
                    'buttonText' => 'Update'
                ])
            </div>
        </div>
    </div>

@endsection
