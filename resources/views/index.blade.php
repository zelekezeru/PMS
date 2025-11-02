@extends('layouts.app')

@section('contents')

@php
    $currentFortnight = App\Models\Fortnight::currentFortnight();
@endphp

{{-- Main Quantities --}}
<div class="d-flex align-items-center justify-content-center flex-column pt-2 pb-4">
    <div class="text-center">
        <h3 class="fw-bold mb-3">SITS Performance Management System</h3>
        <h6 class="op-7 mb-2">Shiloh International Theological Seminary performance overview</h6>
    </div>
</div>

<div class="col-12 mb-4">
    <div class="card w-200 h-40 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between flex-wrap">
            <div class="me-3 mb-3 mb-md-0 w-100 w-md-auto">
            @php $currentFortnightId = optional($currentFortnight)->id; @endphp

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-end align-items-center" role="toolbar" aria-label="Quick actions toolbar">
            <a href="{{ route('tasks.index', ['myTasks' => true]) }}"
               class="btn btn-lg btn-outline-success w-100 w-sm-auto"
               role="button"
               aria-label="My Tasks"
               title="View your tasks">
            <i class="fa-solid fa-user-check me-2" aria-hidden="true" style="font-size: 1.5rem;"></i>
            <span class="d-none d-sm-inline">My Tasks</span>
            </a>

            @if($currentFortnightId)
            <a href="{{ route('fortnights.show', ['fortnight' => $currentFortnightId]) }}"
               class="btn btn-lg btn-outline-warning w-100 w-sm-auto"
               role="button"
               aria-label="Current Fortnight"
               title="View current fortnight">
            <i class="fa-solid fa-calendar-check me-2" aria-hidden="true" style="font-size: 1.5rem;"></i>
            <span class="d-none d-sm-inline">Current Fortnight</span>
            </a>
            @else
            <a href="{{ route('fortnights.index') }}"
               class="btn btn-lg btn-outline-warning w-100 w-sm-auto"
               role="button"
               aria-label="Fortnights"
               title="No current fortnight — view all">
            <i class="fa-solid fa-calendar-days me-2" aria-hidden="true" style="font-size: 1.5rem;"></i>
            <span class="d-none d-sm-inline">Fortnights</span>
            </a>
            @endif

            <a href="{{ route('tasks.create') }}"
               class="btn btn-lg btn-primary text-white w-100 w-sm-auto"
               role="button"
               aria-label="Add Fortnight Task"
               title="Add a fortnight task">
            <i class="fa-solid fa-plus me-2" aria-hidden="true" style="font-size: 1.5rem;"></i>
            <span class="d-none d-sm-inline">Add Fortnight Task</span>
            </a>

            <a href="{{ route('daily_tasks.create', ['dailyTask' => true]) }}"
               class="btn btn-lg btn-info text-white w-100 w-sm-auto"
               role="button"
               aria-label="Add Daily Task"
               title="Add a daily task">
            <i class="fa-solid fa-calendar-day me-2" aria-hidden="true" style="font-size: 1.5rem;"></i>
            <span class="d-none d-sm-inline">Add Daily Task</span>
            </a>
            </div>
        </div>
    </div>
</div>

{{-- Daily Tasks show page --}}
    <div class="row mt-4 mb-4">
        <div class="col-md-8 mb-4">
            {{-- List the first few daily tasks --}}
            <div class="list-group">
                <div class="list-group-item">
                    <a href="{{ route('daily_tasks.index') }}" class="btn btn-primary w-100">Daily Tasks</a>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    @forelse($dailyTasks as $dtask)
                        <div>
                            <h6 class="mb-1">{{ $dtask->title }}</h6>
                            @if(!empty($dtask->description))
                                <small class="text-muted d-block">{{ \Illuminate\Support\Str::limit($dtask->description, 120) }}</small>
                            @endif
                        </div>

                        <div class="d-flex align-items-center">
                            @php
                                $status = $dtask->status ?? 'Unknown';
                                $badgeClass = $status === 'Completed' ? 'success' : ($status === 'Progress' ? 'warning' : 'secondary');
                            @endphp
                            <span class="badge bg-{{ $badgeClass }} me-3">{{ $status }}</span>
                            <a href="{{ route('daily_tasks.show', $dtask) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                    @empty
                        <div class="list-group-item">No daily tasks found.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="col-md-4">
            @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
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
                                                    <p class="card-category fw-bold">All Users</p>
                                                @else
                                                     <p class="card-category fw-bold">Employees in your department</p>
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
                                                 <p class="card-category fw-bold">Departments</p>
                                                <h4 class="card-title">{{ is_countable($departments) ? count($departments) : 0 }}</h4>
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

    <div class="row mt-4">
            <!-- Task Status Overview -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <canvas id="taskChart"></canvas>
                </div>
            </div>
        </div>
    
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
                                        <a href="{{ route('users.show', $user->id) }}" class="mb-0">{{ $user->name }}</a>
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
