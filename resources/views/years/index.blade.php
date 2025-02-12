@extends('layouts.app')

@section('contents')

<div class="container mt-3">
    <div class="card pt-5">
        <h2 class="card-header text-center">Years List</h2>
        <div class="card-body">

            @if(!request()->user()->hasRole('DEPARTMENT_HEAD'))
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('years.create') }}"><i class="fa fa-plus"></i> Add New Year</a>
                </div>
            @endif
            
            @include('years.list')

            <!-- SweetAlert Success Notifications -->
            @if (session('status'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Year {{ ucfirst(session('status')) }} Successfully!',
                            text: 'Your year has been successfully {{ session('status') }}.',
                            confirmButtonText: 'Okay'
                        });
                    });
                </script>
            @endif

            <div class="mt-3">
                {{ $years->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
