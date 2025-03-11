@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Report Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('reports.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Report Date:</th>
                        <td>{{ \Carbon\Carbon::parse($report->start_date)->format('M - d - Y') }} - To - {{ \Carbon\Carbon::parse($report->end_date)->format('M - d - Y') }}</td>
                    </tr>
                    <tr>
                        <th>User:</th>
                        <td>{{ $report->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Department:</th>
                        <td>{{ $report->user->department->department_name }}</td>
                    </tr>
                </table>
                
                <h4 class="text-center my-3">Task Report:</h4>
                    
                <table id="add-row" class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>All Tasks</th>
                            <th>Pending</th>
                            <th>In Progress</th>
                            <th>Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taskSummaries as $task)
                            <tr>
                                <td>{{ $task['all_tasks'] }}</td>
                                <td>{{ $task['pending_tasks'] }}</td>
                                <td>{{ $task['progress_tasks'] }}</td>
                                <td>{{ $task['completed_tasks'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h4 class="text-center my-3">Task KPI Summary:</h4>
                    
                <table id="add-row" class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Task ID</th>
                            <th>Total KPIs</th>
                            <th>Pending KPIs</th>
                            <th>In Progress KPIs</th>
                            <th>Completed KPIs</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taskKpiSummaries as $kpi)
                            <tr>
                                <td>{{ $kpi['task_id'] }}</td>
                                <td>{{ $kpi['task_kpis'] }}</td>
                                <td>{{ $kpi['pending_kpis'] }}</td>
                                <td>{{ $kpi['progress_kpis'] }}</td>
                                <td>{{ $kpi['completed_kpis'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $report->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $report->id }}" action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <script>
                        function confirmDelete(reportId) {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "Once deleted, this report cannot be recovered!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#3085d6",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('delete-form-' + reportId).submit();
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>

@endsection
