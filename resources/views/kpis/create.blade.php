@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">Add Key Indicator</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-primary btn-sm" href="{{ route('kpis.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>

                @php
                    $task = $task ?? null;
                    $target = $target ?? null;
                @endphp

                @if($task != null)
                    @include('kpis.form', [
                        'action' => route('kpis.store'),
                        'method' => 'POST',
                        'target' => null,
                        'buttonText' => 'Create'
                    ])
                @elseif($target != null)
                    @include('kpis.form', [
                        'action' => route('kpis.store'),
                        'method' => 'POST',
                        'task' => null,
                        'buttonText' => 'Create'
                    ])
                @else
                    @include('kpis.form', [
                        'action' => route('kpis.store'),
                        'method' => 'POST',
                        'buttonText' => 'Create'
                    ])
                @endif
            </div>
        </div>
    </div>

@endsection
