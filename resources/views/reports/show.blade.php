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
                        <td>{{ \Carbon\Carbon::parse($report->report_date)->format('M - d - Y') }}</td>
                    </tr>
                    <tr>
                        <th>Department:</th>
                        <td>{{ $report->department->department_name }}</td>
                    </tr>
                    <tr>
                        <th>User:</th>
                        <td>{{ $report->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Target:</th>
                        <td>{{ $report->target }}</td>
                    </tr>
                    <tr>
                        <th>Schedule:</th>
                        <td>{{ $report->schedule }}</td>
                    </tr>
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

        @if ($report->goals)
            @php
                $goals = $report->goals;
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Goals of this Report</h3>
            </div>

            @include('goals.list')
        @else
            <div class="alert alert-warning mt-3">
                <p>No goals found for this report.</p>
            </div>
        @endif
    </div>

@endsection
