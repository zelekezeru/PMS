@extends('layouts.app')

@section('contents')
    <div class="container mt-3">
        <div class="card mt-5">
            <h2 class="card-header text-center">
                {{
                    request('currentFortnight') 
                        ? 'Current Fortnight Tasks' 
                        : (request('onlyToday') ? 'Tasks For Today' : 'All Tasks List')
                }}
            </h2>
            
            @if (request('currentFortnight') )
                <div class="col text-center">
                    @can('view-fortnights')
                        <a href="{{ route('fortnights.index') }}">
                            <h5 class="nav-item text-info justify-content-md-start "> ( {{ \Carbon\Carbon::parse($currentFortnight->start_date)->format('M - d - Y') }} <span class="text-success"> to </span> {{ \Carbon\Carbon::parse($currentFortnight->end_date)->format('M - d - Y') }} )</h5>    
                        </a>      
                    @elsecan                  
                        <h5 class="nav-item text-info justify-content-md-start "> ( {{ \Carbon\Carbon::parse($currentFortnight->start_date)->format('M - d - Y') }} <span class="text-success"> to </span> {{ \Carbon\Carbon::parse($currentFortnight->end_date)->format('M - d - Y') }} )</h5>    
                    @endcan
                </div>
                
            @elseif (request('onlyToday') )
                <div class="col text-center">
                    <h5 class="nav-item text-info justify-content-md-start "> ( {{ \Carbon\Carbon::now()->format('M - d - Y') }} )</h5>
                </div>
            @else
                <div class="col text-center">
                    <h5 class="nav-item text-info justify-content-md-start "> All Registered Tasks</h5>
                </div>

            @endif
            
            <div class="card-body">
                <div class="row d-grid gap-2 d-md-flex justify-content-md-end mb-3">

                    <div class="col-2 btn-group dropdown">
                        <button
                          class="btn btn-primary dropdown-toggle"
                          type="button"
                          data-bs-toggle="dropdown">
                          Create Task
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li>
                            <a class="dropdown-item" href="{{ route('tasks.create', ['dailyTask' => true]) }}"><i class="fa fa-plus"></i> Create Daily Task</a>
                            <a class="dropdown-item" href="{{ route('tasks.create') }}"><i class="fa fa-plus"></i> Create Fortnight Task</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <ul class="nav nav-tabs nav-line nav-color-secondary" id="line-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link btn {{ request('currentFortnight') || request('onlyToday') ? '' : 'active' }}" id="line-home-tab" href="{{route('tasks.index')}}" role="tab" aria-controls="pills-home" aria-selected="true">All Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn {{ request('currentFortnight') ? 'active' : '' }}" id="line-home-tab" href="{{route('tasks.index', ['currentFortnight' => true])}}" role="tab" aria-controls="pills-home" aria-selected="true">Current Fortnight</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn {{ request('onlyToday') ? 'active' : '' }}" id="line-home-tab" href="{{route('tasks.index', ['onlyToday' => true])}}" role="tab" aria-controls="pills-home" aria-selected="true">Today's Tasks</a>
                    </li>
                    
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
                    {{ $tasks->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
