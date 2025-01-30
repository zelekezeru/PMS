@extends('layouts.app')

@section('contents')

<div class="container mt-3">

    <div class="card pt-5">
        <h2 class="card-header text-center">Users List</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Add New Year</a>
            </div>

            @include('users.list')

            <div class="mt-3">
                {{ $users->links() }}
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
                title = "Successfuly Approved!";
                text = "Your User can now login to the system.";
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
