@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">Edit kpi</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-primary btn-sm" href="{{ route('kpis.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>

                @include('kpis.form', [
                    'action' => route('kpis.update', $kpi->id),
                    'method' => 'PUT',
                    'kpi' => $kpi,
                    'buttonText' => 'Update'
                ])
            </div>
        </div>
    </div>

@endsection
