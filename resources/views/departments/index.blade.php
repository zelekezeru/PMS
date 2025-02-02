@extends('layouts.app')

@section('contents')

<div class="container mt-3">
    <div class="card pt-5">
        <h2 class="card-header text-center">Departments List</h2>
        <div class="card-body">
            @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('departments.create') }}"><i class="fa fa-plus"></i> Add New Department</a>
                </div>
            @endif

            @include('departments.list')

            {{ $departments->links() }}
            <!-- SweetAlert Success Notifications -->
            @if (session('status'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Department {{ ucfirst(session('status')) }}',
                            text: 'Your department has been successfully {{ session('status') }}.',
                            confirmButtonText: 'Okay'
                        });
                    });
                </script>
            @endif

        </div>
    </div>
</div>

@endsection
