@extends('layouts.app')

@section('contents')
    <div class="container mt-3">
        <div class="card mt-5">
            <div class="card-header bg-white border-0">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center">
                        <span class="badge rounded-pill bg-primary text-white me-3 p-2 shadow-sm">
                            <i class="fa fa-tasks"></i>
                        </span>
                        <div>
                            <h1 class="mb-0 fw-semibold text-dark">
                                {{
                                    (request('myTasks') || request()->user()->hasRole('EMPLOYEE') ? 'My ' : '') .
                                    (request('currentFortnight') 
                                        ? 'Current Fortnight Tasks' 
                                        : (request('onlyToday') ? 'Tasks For Today' : 'All Tasks'))
                                }}
                            </h1>
                            <small class="text-muted">
                                @if(request('currentFortnight') && isset($currentFortnight))
                                    {{ \Carbon\Carbon::parse($currentFortnight->start_date)->format('M d, Y') }} — {{ \Carbon\Carbon::parse($currentFortnight->end_date)->format('M d, Y') }}
                                @elseif(request('onlyToday'))
                                    {{ \Carbon\Carbon::now()->format('M d, Y') }}
                                @else
                                    Tasks list is shown below.
                                @endif
                            </small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <form method="GET" action="{{ route('tasks.index') }}" class="d-flex align-items-center gap-2">
                            {{-- preserve other query params --}}
                            @foreach(request()->except(['status','page']) as $name => $value)
                                @if(is_array($value))
                                    @foreach($value as $v)
                                        <input type="hidden" name="{{ $name }}[]" value="{{ $v }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                @endif
                            @endforeach

                            <label for="selectStatus" class="form-label mb-0 small">Filter by Status</label>
                            <select class="form-select form-select-sm" id="selectStatus" name="status" onchange="this.form.submit()" style="width:170px;">
                                <option value="">All Status</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="progress" {{ request('status') == 'progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>

                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary d-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-plus me-1"></i> Create Task
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('daily_tasks.create', ['dailyTask' => true]) }}">
                                        <i class="fa fa-calendar-day me-2 text-muted"></i> Create Daily Task
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('tasks.create') }}">
                                        <i class="fa fa-calendar-alt me-2 text-muted"></i> Create Fortnight Task
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            @if (request('currentFortnight') && isset($currentFortnight) )
                <div class="col text-center">
                    @can('view-fortnights')
                        <a href="{{ route('fortnights.show', $currentFortnight->id) }}">
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


                <div class="d-flex justify-content-between align-items-center flex-wrap gap-4 my-2">
                    {{-- Left group: All / My --}}
                    <div class="btn-group" role="group" aria-label="Main task filters">
                        @if (request()->user()->hasAnyRole(['SUPER_ADMIN','ADMIN', 'DEPARTMENT_HEAD']))
                            @hasrole('DEPARTMENT_HEAD')
                                <a href="{{ route('tasks.index') }}"
                                   class="btn btn-sm {{ (request('currentFortnight') || request('onlyToday') || request('myTasks')) ? 'btn-outline-primary' : 'btn-primary' }}">
                                   <i class="fa fa-building me-1"></i> {{ (request('currentFortnight') || request('onlyToday') || request('myTasks')) ? 'All Department Tasks' : 'All Department Tasks' }}
                                </a>
                            @else
                                <a href="{{ route('tasks.index') }}"
                                   class="btn btn-sm {{ (request('currentFortnight') || request('onlyToday') || request('myTasks')) ? 'btn-outline-primary' : 'btn-primary' }}">
                                   <i class="fa fa-list me-1"></i> {{ (request('currentFortnight') || request('onlyToday') || request('myTasks')) ? 'All Tasks' : 'All Tasks' }}
                                </a>
                            @endhasrole

                            <a href="{{ route('tasks.index', ['myTasks' => true]) }}"
                               class="btn btn-sm {{ request('myTasks') ? 'btn-primary' : 'btn-outline-primary' }}">
                               <i class="fa fa-user me-1"></i> My Tasks
                            </a>

                        @elseif(request()->user()->hasRole('SUPER-ADMIN'))
                            <a href="{{ route('tasks.index') }}"
                               class="btn btn-sm {{ request('myTasks') ? 'btn-outline-primary' : 'btn-primary' }}">
                               <i class="fa fa-user-secret me-1"></i> My Tasks
                            </a>
                        @endif
                    </div>

                    {{-- Right group: quick filters --}}
                    <div class="btn-group" role="group" aria-label="Quick filters">
                        <a href="{{ route('tasks.index', ['currentFortnight' => true, 'myTasks' => request('myTasks')]) }}"
                           class="btn btn-sm {{ request('currentFortnight') ? 'btn-primary' : 'btn-outline-primary' }}">
                           <i class="fa fa-calendar-alt me-1"></i> {{ request('myTasks') ? 'My' : 'All' }} Current Fortnight
                        </a>

                        <a href="{{ route('tasks.index', [
                                'onlyToday' => true,
                                'myTasks' => request('myTasks'),
                                'date' => request()->query('date', now()->format('Y-m-d')),
                                'user_id' => request()->query('user_id'),
                            ]) }}"
                           class="btn btn-sm {{ request('onlyToday') ? 'btn-primary' : 'btn-outline-primary' }}">
                           <i class="fa fa-calendar-day me-1"></i> {{ request('myTasks') ? 'My' : 'All' }} Today
                        </a>
                    </div>
                </div>

                
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
