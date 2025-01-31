@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Goal Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('goals.index') }}">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Pillar Name:</th>
                        <td>{{ $goal->strategy->pilar_name }}</td>
                    </tr>
                    <tr>
                        <th>Strategic Goal:</th>
                        <td>{{ $goal->strategy->name }}</td>
                    </tr>
                    <tr>
                        <th>Goal:</th>
                        <td>{{ $goal->name }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $goal->description }}</td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('goals.edit', $goal->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <button type="button" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $goal->id }}" action="{{ route('goals.destroy', $goal->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

        @if ($goal->targets)

        @php
            $targets = $goal->targets;
        @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Targets of this Goal</h3>
            </div>
            @include('targets.list')
        @else
            <div class="alert alert-warning mt-3">
                <p>No targets found for this goal.</p>
            </div>
        @endif
    </div>

    <script>
        function confirmDelete(goalId) {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, this goal cannot be recovered!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + goalId).submit();
                }
            });
        }
    </script>

@endsection
