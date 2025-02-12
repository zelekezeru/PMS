@extends('layouts.app')

@section('contents')

<div class="container mt-3">
    <div class="card pt-5">
        <h2 class="card-header text-center">Quarters List</h2>
        <div class="card-body">
            
            @if(!request()->user()->hasRole('DEPARTMENT_HEAD'))
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('quarters.create') }}"> <i class="fa fa-plus"></i> Add New Quarter
                    </a>
                </div>
            @endif
            
            @include('quarters.list')

            <!-- SweetAlert Success Notifications -->
            @if (session('status'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Quarter {{ ucfirst(session('status')) }} Successfully!',
                            text: 'Your quarter has been successfully {{ session('status') }}.',
                            confirmButtonText: 'Okay'
                        });
                    });
                </script>
            @endif

        </div>
    </div>
</div>

@endsection
