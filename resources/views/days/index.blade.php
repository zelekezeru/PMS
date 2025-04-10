@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Days List</h2>
            <div class="card-body">

                @if(!request()->user()->hasRole('DEPARTMENT_HEAD'))
                    <div class="d-flex justify-content-end mb-3">
                        <a class="btn btn-success btn-sm" href="{{ route('days.create') }}">
                            <i class="fa fa-plus"></i> Add New Day
                        </a>
                    </div>
                @endif
                
                @include('days.list')

                <!-- SweetAlert Success Notifications -->
                @if (session('status'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            Swal.fire({
                                icon: 'success',
                                title: 'Day {{ ucfirst(session('status')) }}',
                                text: 'Your day has been successfully {{ session('status') }}.',
                                confirmButtonText: 'Okay'
                            });
                        });
                    </script>
                @endif

            </div>
        </div>
    </div>

@endsection
