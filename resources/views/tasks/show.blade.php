@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Task Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('tasks.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Task Title:</th>
                        <td>{{ $task->name }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $task->description }}</td>
                    </tr>
                    <tr>
                        <th>Target:</th>
                        <td>{{ $task->target ? $task->target->name : "Not Assigned Yet" }}</td>
                    </tr>
                    <tr>
                        <th>Starting Date:</th>
                        <td>{{ \Carbon\Carbon::parse($task->starting_date)->format('M - d - Y') }}</td>
                    </tr>
                    <tr>
                        <th>Due Date:</th>
                        <td>{{ \Carbon\Carbon::parse($task->due_date)->format('M - d - Y') }}</td>
                    </tr>
                    <tr>
                        <th>Budget:</th>
                        <td>{{ $task->budget }}</td>
                    </tr>
                    <tr>
                        <th>Barriers:</th>
                        <td>{{ $task->barriers }}</td>
                    </tr>
                    <tr>
                        <th>Comunication:</th>
                        <td>{{ $task->comunication }}</td>
                    </tr>
                    <tr>
                        <th>KPI:</th>
                        <td>{{ $task->kpi ? $task->kpi->name : "Not Assigned Yet" }}</td>
                    </tr>
                    <tr>
                        <th>Departments:</th>
                        <td>
                            @if($task->departments && $task->departments->count() > 0)
                                @foreach($task->departments as $department)
                                    <strong>
                                        @can('view-departments')
                                            <a href="{{route('departments.show', $department)}}"> {{ $department->department_name }}, </a>
                                        @elsecan
                                            {{ $department->department_name }},
                                        @endcan
                                    </strong>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $task->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

        @if (!$task->kpi)
            @can ('create-kpis')
                <div class="col">
                    <a class="btn btn-success btn-sm mr-2" href="{{ route('kpis.create_taskx', ['taskx' => $taskx->id]) }}"><i class="fa fa-plus"></i> Add Taskx Indicators</a>
                </div>
            @endcan
        @endif

        {{-- @if ($task->kpis)
            @php
                $kpis = $task->name;
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">KPIs of this task</h3>
            </div>

            @include('kpis.list')
        @else
            <div class="alert alert-warning mt-3">
                <p>No KPIs found for this task.</p>
            </div>
        @endif --}}
    </div>

@endsection
