@extends('layouts.app')

@section('contents')
    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">KPIs List</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('kpis.create') }}"><i class="fa fa-plus"></i> Add New KPI</a>
                </div>

                @include('kpis.list')

                <div class="mt-3">
                    {{ $kpis->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
