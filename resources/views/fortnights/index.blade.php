@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Fortnights List</h2>
            <div class="card-body">
                
                @if(!request()->user()->hasRole('DEPARTMENT_HEAD'))
                    <div class="d-flex gap-3 justify-content-end mb-3">
                        <a class="btn btn-primary btn-sm" href="{{ route('fortnights.show', $currentFortnight) }}">
                            Current Fortnight
                        </a>
                        <a class="btn btn-success btn-sm" href="{{ route('fortnights.create') }}">
                            <i class="fa fa-plus"></i> Add New Fortnight
                        </a>
                    </div>
                @endif
                
                @include('fortnights.list')

                <!-- SweetAlert Success Notifications -->
                @if (session('status'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Fortnight {{ ucfirst(session('status')) }}',
                                text: 'Your fortnight has been successfully {{ session('status') }}.',
                                confirmButtonText: 'Okay'
                            });
                        });
                    </script>
                @endif

            </div>
        </div>
    </div>

@endsection
