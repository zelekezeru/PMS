@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Key Indicator Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('kpis.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Performance Indicator:</th>
                        <td>{{ $kpi->name }}</td>
                    </tr>
                    <tr>
                        <th>Measurement Unit:</th>
                        <td>{{ $kpi->unit }}</td>
                    </tr>
                    <tr>
                        <th>Value:</th>
                        <td>{{ $kpi->value }}</td>
                    </tr>
                    <tr>
                        <th>status:</th>
                        <td>{{ $kpi->status }}</td>
                    </tr>
                    <tr>
                        @if($kpi->task_id != null)
                            <th>Task:</th>
                            <td>{{ $kpi->task->name }}</td>
                        @elseif($kpi->target_id != null)
                            <th>Target:</th>
                            <td>{{ $kpi->target->name }}</td>
                        @endif
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('kpis.edit', $kpi->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $kpi->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $kpi->id }}" action="{{ route('kpis.destroy', $kpi->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <script>
                        function confirmDelete(kpiId) {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "Once deleted, this kpi cannot be recovered!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#3085d6",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('delete-form-' + kpiId).submit();
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>

        @if ($kpi->goals)
            @php
                $goals = $kpi->goals;
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Goals of this kpi</h3>
            </div>

            @include('goals.list')
        @else
            <div class="alert alert-warning mt-3">
                <p>No goals found for this kpi.</p>
            </div>
        @endif
    </div>

    <div class="container mt-5 pt-5">
        <!-- Strategie Details Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">kpi Details</h3>
                <a href="{{ route('kpis.index') }}" class="btn btn-primary btn-sm float-end">Back to kpis</a>
            </div>
            <div class="card-body">
                <!-- Strategie Title -->
                <h3 class="mb-3"><i class="fas fa-book"></i><strong class=" m-2 h2">Pilar Name:</strong>  {{ $kpi->name }}</h3>

                <!-- kpi Details -->
                <div class="row">
                    <div class="col-md-6">
                        <p><strong class="h3">Name:</strong> {{ $kpi->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong class="h3">Description:</strong> {{ $kpi->description }}</p>
                    </div>
                </div>

                <!-- Edit and Delete buttons -->
                <div class="mt-4">
                    <a href="{{ route('kpis.edit', $kpi->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit kpi
                    </a>

                    <form action="{{ route('kpis.destroy', $kpi->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this strategie?')">
                            <i class="fas fa-trash"></i> Delete kpi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
