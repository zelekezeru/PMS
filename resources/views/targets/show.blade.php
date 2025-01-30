@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Target Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('targets.index') }}">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Pillar Name:</th>
                        <td>{{ $target->goal->strategy->pilar_name }}</td>
                    </tr>
                    <tr>
                        <th>Target:</th>
                        <td>{{ $target->name }}</td>
                    </tr>
                    <tr>
                        <th>Budget:</th>
                        <td>{{ $target->budget }}</td>
                    </tr>
                    <tr>
                        <th>Value:</th>
                        <td>{{ $target->value }} {{ $target->unit }}</td>
                    </tr>
                    <tr>
                        <th>Departments:</th>
                        <div class="row">
                            <div class="col-md-6">
                                <td>
                                    @if($target->departments && $target->departments->count() > 0)
                                        @foreach($target->departments as $department)
                                            <strong>{{ $department->department_name }}</strong>,
                                        @endforeach
                                    @endif
                                </td>
                            </div>
                        </div>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ \Carbon\Carbon::parse($target->created_at)->format('M - d - Y') }}</td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('targets.edit', $target->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('targets.destroy', $target->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this target?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if ($target->kpis)
            @php
                $kpis = $target->kpis;
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Indicators of this Target</h3>
            </div>

            @include('kpis.list')
        @else
            <div class="alert alert-warning mt-3">
                <p>No indicators found for this target.</p>
            </div>
        @endif
    </div>

@endsection
