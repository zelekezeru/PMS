@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Pillar Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('strategies.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Pillar:</th>
                        <td>{{ $strategy->pilar_name }}</td>
                    </tr>
                    <tr>
                        <th>Strategy:</th>
                        <td>{{ $strategy->name }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $strategy->description }}</td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('strategies.edit', $strategy->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $strategy->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $strategy->id }}" action="{{ route('strategies.destroy', $strategy->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <script>
                        function confirmDelete(strategyId) {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "Once deleted, this strategy cannot be recovered!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#3085d6",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('delete-form-' + strategyId).submit();
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>

        @if ($strategy->goals)
            @php
                $goals = $strategy->goals;
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Goals of this Strategy</h3>
            </div>

            @include('goals.list')
        @else
            <div class="alert alert-warning mt-3">
                <p>No goals found for this strategy.</p>
            </div>
        @endif
    </div>

@endsection
