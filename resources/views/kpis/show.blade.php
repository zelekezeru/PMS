@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Key Indicator Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('tasks.show', $kpi->task_id) }}">
                        <i class="fa fa-arrow-left"></i> Back to Task
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
                        <th>Status:</th>
                        @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']) || Auth::user()->tasks->contains($kpi->id))
                            @if ($kpi->status != 'Completed')
                                <td>
                                    <div class="col-6">
                                        <form action="{{ route('kpis.status', $kpi->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" id="status" class="form-control col-6 @error('status') is-invalid @enderror" optional>
                                                <option value="Pending" {{ $kpi->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Progress" {{ $kpi->status == 'Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Completed" {{ $kpi->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                                        </form>
                                    </div>
                                </td>
                                @error('status')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <td class="badge badge-success me-4">Completed !</td>
                            @endif
                        @endif
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
    </div>

@endsection
