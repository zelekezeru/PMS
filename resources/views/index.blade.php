@extends('layouts.app')

@section('contents')

{{-- Main Quantities --}}
<div class="d-flex align-items-center justify-content-center flex-column pt-2 pb-4">
    <div class="text-center">
        <h3 class="fw-bold mb-3">SITS Performance Management System</h3>
        <h6 class="op-7 mb-2">Shiloh International Theological Seminary performance overview</h6>
    </div>
</div>

<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <a href="{{ route('tasks.index', ['myTasks' => true]) }}" class="btn btn-label-info btn-round me-2">My Tasks</a>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-round">Add Fortnight Task</a>
        <a href="{{ route('tasks.create', ['dailyTask' => true]) }}" class="btn btn-info btn-round">Add Daily Task</a>
        
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="row">
            <a href="{{ route('tasks.index') }}">
                <div class="col-sm-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fa-solid fa-list-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3">
                                    <div class="numbers">
                                        <p class="card-category">All Tasks</p>
                                        <h4 class="card-title">{{ is_countable($tasks) ? count($tasks) : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-3">
                <a href="{{ route('tasks.list', 'Pending') }}">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-danger bubble-shadow-small">
                                        <i class="fa-solid fa-spinner"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3">
                                    <div class="numbers">
                                        <p class="card-category">Pending Tasks</p>
                                        <h4 class="card-title">{{ is_countable($tasks) ? $tasks->where('status', 'Pending')->count() : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-3">
                <a href="{{ route('tasks.list', 'Progress') }}">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-warning bubble-shadow-small">
                                        <i class="fa-solid fa-arrow-up-right-dots"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3">
                                    <div class="numbers">
                                        <p class="card-category">Tasks InProgress</p>
                                        <h4 class="card-title">{{ is_countable($tasks) ? $tasks->where('status', 'Progress')->count() : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-3">
                <a href="{{ route('tasks.list', 'Completed') }}">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3">
                                    <div class="numbers">
                                        <p class="card-category">Completed Tasks</p>
                                        <h4 class="card-title">{{ is_countable($tasks) ? $tasks->where('status', 'Completed')->count() : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
            <!-- Task Status Overview -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <canvas id="taskChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{ route('departments.index') }}">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                <i class="fa-solid fa-building"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3">
                                            <div class="numbers">
                                                <p class="card-category">Departments</p>
                                                <h4 class="card-title">{{ is_countable($departments) ? count($departments) : 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{ route('users.index') }}">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                <i class="fa-solid fa-users"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3">
                                            <div class="numbers">
                                                @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                                                    <p class="card-category">All Registered Users</p>
                                                @else
                                                    <p class="card-category">Employees in your department</p>
                                                @endif
                                                <h4 class="card-title">{{ is_countable($users) ? count($users) : 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </div>    
        {{-- Pillars   --}}
         
    {{-- 5-Year Goals Section --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">SITS Strategic Pillars</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">

                    @forelse ($strategies as $strategy)

                        <li class="list-group-item p-4"><i class="fas fa-check-circle text-success me-2"></i> {{$strategy->pillar_name}}</li>

                    @empty

                    @endforelse

                </ul>
            </div>
        </div>
    </div>
        <!-- User List -->
        
                
        @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
    
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Message Users </h4>
                    </div>
                    <div class="card-body user-list">
                        <ul class="list-unstyled">
                            @foreach ($users as $user)
                                <li class="d-flex align-items-center mb-3">
                                    @if ($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="rounded-circle" width="40" height="40">
                                    @else
                                        <span class="avatar-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    @endif
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <small class="text-muted">{{ $user->role }}</small>
                                    </div>
                                    <div class="ms-auto d-flex">
                                        <a href="mailto:{{ $user->email }}" class="text-primary me-2"><i class="fas fa-envelope"></i></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif    
        
    </div>
   
</div>


@endsection


<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("taskChart").getContext("2d");

        var taskChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Pending", "Progress", "Completed"],
                datasets: [{
                    data: [{{ $pendingTasks }}, {{ $inProgressTasks }}, {{ $completedTasks }}],
                    backgroundColor: ["#f25961", "#ffad46", "#31ce36"]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom" // Move legend below the pie chart
                    }
                }
            }
        });
    });
</script>
