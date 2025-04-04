@extends('layouts.app')

@section('contents')

<div class="container mt-3">

    <div class="card pt-5">
        <h2 class="card-header text-center">Users List</h2>
        <div class="card-body">
            
            @if(!request()->user()->hasRole('DEPARTMENT_HEAD'))
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Add New User</a>
                </div>
            @endif

            @include('users.list')

            <div class="mt-3">
                @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $users->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@if(session('status'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let message = "{{ session('status') }}";
            let title = "";
            let text = "";

            if (message === "users-approved") {
                title = "Successfully Approved!";
                text = "Your User can now login to the system.";
            } else if (message === "user-deleted") {
                title = "User!";
                text = "The selected user has been deleted.";
            } else if (message === "not-allowed") {
                title = "User!";
                text = "Action Not Allowed.";
            }

            Swal.fire({
                icon: 'success',
                title: title,
                text: text,
                confirmButtonText: 'Okay'
            });
        });
    </script>
@endif
@endsection
