@extends('layouts.app')

@section('contents')
    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">Targets List</h2>
            <div class="card-body">
                @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                        <a class="btn btn-success btn-sm" href="{{ route('targets.create') }}"><i class="fa fa-plus"></i> Add New Target</a>
                    </div>
                @endif

                @include('targets.list')

                <!-- SweetAlert Success Notifications -->
                @if (session('status'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Target {{ ucfirst(session('status')) }}',
                                text: 'Your target has been successfully {{ session('status') }}.',
                                confirmButtonText: 'Okay'
                            });
                        });
                    </script>
                @endif

                <div class="mt-3">
                    {{ $targets->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
