@extends('layouts.app')

@section('contents')
    <div class="container mt-3">
        @if (session('status') === 'goal-created')
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Goal Created!',
                    text: 'Your goal has been successfully created.',
                    confirmButtonText: 'Okay'
                });
            </script>
        @endif

        @if (session('status') === 'goal-updated')
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Goal Updated!',
                    text: 'Your goal has been successfully updated.',
                    confirmButtonText: 'Okay'
                });
            </script>
        @endif

        <div class="card mt-5">
            <h2 class="card-header text-center">Goals List</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    @if(request()->user()->hasAnyRole('ADMIN', 'SUPER_ADMIN'))
                    <a class="btn btn-success btn-sm" href="{{ route('goals.create') }}">
                        <i class="fa fa-plus"></i> Add New Goal
                    </a>
                    @endif
                </div>

                @include('goals.list')

                <div class="mt-3">
                    @if ($goals->isNotEmpty())
                        {{ $goals->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
