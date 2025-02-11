@extends('layouts.app')

@section('contents')
    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">{{ request('currentFortnight') ? 'Current Fortnight Tasks' : 'All Tasks List' }}</h2>
            @if ($currentFortnight)
                <h6 class="text-center">( {{$currentFortnight->start_date}} to {{$currentFortnight->end_date}} )</h3>
            @endif
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('tasks.create') }}"><i class="fa fa-plus"></i> Add New Task</a>
                </div>
                <ul class="nav nav-tabs nav-line nav-color-secondary" id="line-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link btn {{ request('currentFortnight') || request('todays') ? '' : 'active' }}" id="line-home-tab" href="{{route('tasks.index')}}" role="tab" aria-controls="pills-home" aria-selected="true">All Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn {{ request('currentFortnight') ? 'active' : '' }}" id="line-home-tab" href="{{route('tasks.index', ['currentFortnight' => true])}}" role="tab" aria-controls="pills-home" aria-selected="true">Current Fortnight</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn" id="line-home-tab" href="{{route('tasks.index', ['todays' => true])}}" role="tab" aria-controls="pills-home" aria-selected="true">Today's Tasks</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link btn" id="line-home-tab" href="{{route('tasks.index', ['status' => pending])}}" role="tab" aria-controls="pills-home" aria-selected="true">Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn" id="line-home-tab" href="{{route('tasks.index', ['status' => progress])}}" role="tab" aria-controls="pills-home" aria-selected="true">In Progress</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn" id="line-home-tab" href="{{route('tasks.index', ['currentFortnight' => true])}}" role="tab" aria-controls="pills-home" aria-selected="true">Completed</a>
                    </li> --}}
                </ul>
                @include('tasks.list')
                    <!-- SweetAlert Success Notifications -->
                    @if (session('status'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: '{{ ucfirst(session('status')) }}',
                                text: 'Your Task has been successfully {{ session('status') }}.',
                                confirmButtonText: 'Okay'
                            });
                        });
                    </script>
                @endif

                <div class="mt-3">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
