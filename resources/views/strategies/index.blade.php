@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">Strategies List</h2>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">  
                    <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search w-50 p-0 d-none d-md-flex">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="submit" class="btn btn-search pe-1">
                                    <i class="fa fa-search search-icon"></i>
                                </button>
                            </div>
                            <input type="text" placeholder="Search ..." class="form-control" />
                        </div>
                    </nav>
                    <a class="btn btn-success btn-sm" href="{{ route('strategies.create') }}">
                        <i class="fa fa-plus"></i> Add New Strategy
                    </a>
                </div>

                @include('strategies.list')

                <!-- SweetAlert Success Notifications -->
                @if (session('status'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: '{{ ucfirst(session('status')) }}',
                                text: 'Your strategy has been successfully {{ session('status') }}.',
                                confirmButtonText: 'Okay'
                            });
                        });
                    </script>
                @endif

                <div class="mt-3">
                    {{ $strategies->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
