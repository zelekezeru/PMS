@extends('layouts.app')

@section('contents')

<div class="container mt-3">
    <div class="card pt-5">
        <h2 class="card-header text-center">deliverables List</h2>
        <div class="card-body">
            @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('deliverables.create') }}"><i class="fa fa-plus"></i> Add New deliverable</a>
                </div>
            @endif

            @include('deliverables.list')

            {{ $deliverables->links() }}
            <!-- SweetAlert Success Notifications -->
            @if (session('status'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'deliverable {{ ucfirst(session('status')) }}',
                            text: 'Your deliverable has been successfully {{ session('status') }}.',
                            confirmButtonText: 'Okay'
                        });
                    });
                </script>
            @endif

        </div>
    </div>
</div>

@endsection
