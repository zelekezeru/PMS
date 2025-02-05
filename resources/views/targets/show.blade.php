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
                        <td>{{ $target->goal ? $target->goal->strategy->pillar_name : 'Not Assigned to any' }}</td>
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
                        <th>Kpi:</th>
                        <td>{{ $target->name }} </td>
                    </tr>
                    <tr>
                        <th>Departments:</th>
                        <div class="row">
                            <div class="col-md-6">
                                <td>
                                    @if($target->departments && $target->departments->count() > 0)
                                        @foreach($target->departments as $department)
                                            <strong>{{ $department->department_name }}</strong>, {{" "}}
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
                    @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                        <a href="{{ route('targets.edit', $target->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $target->id }})">
                            <i class="fas fa-trash"></i> Delete
                        </button>

                        <form id="delete-form-{{ $target->id }}" action="{{ route('targets.destroy', $target->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @if (!$target->kpi)
            @can ('create-kpis')
                <div class="col">
                    <a class="btn btn-success btn-sm mr-2" href="{{ route('kpis.create_target', ['target' => $target->id]) }}"><i class="fa fa-plus"></i> Add Target Indicators</a>
                </div>
            @endcan
        @endif

        {{-- @if ($target->kpi)
            @php
                $kpis = [];
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Indicators of this Target</h3>
            </div>

            @include('kpis.list')
        @else
            <div class="alert alert-warning mt-3">
                <p>No indicators found for this target.</p>
            </div>
        @endif --}}
    </div>

@endsection
