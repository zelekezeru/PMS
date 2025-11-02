@extends('layouts.app')

@section('contents')
<div class="container mt-3">

    <div class="d-flex justify-content-end">
        <a class="btn btn-primary btn-sm mb-3" href="{{ url()->previous() }}">
            <i class="fa fa-arrow-left"></i> Back to Previous Page
        </a>
        <a class="btn btn-primary btn-sm mb-3 mx-4" href="{{ route('users.index') }}">
            <i class="fa fa-arrow-left"></i> Back to Users List
        </a>
        <a class="btn btn-success btn-sm mb-3" href="{{ route('users.printReport', $user->id) }}">
            <i class="fa fa-print"></i> Print Current Fortnight Report
        </a>
    </div>

    <!-- Summary View -->
    <div id="user-summary" class="card p-3" style="cursor: pointer;">
        
        <div class="d-flex gap-4 align-items-center">
            <div class="mr-4">
                <img src="{{ $user->profile_image ? Storage::url($user->profile_image) : asset('img/user.png') }}" 
                     alt="Profile Image" 
                     style="width:80px; height:80px; border-radius: 50%;">
            </div>
            <div>
                <h3>{{ $user->name }}</h3>
                <p class="mb-0">
                    @if($user->department_id)
                        {{ $user->department->department_name }}
                    @else
                        <span class="badge badge-info">Not Assigned</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="mt-3 text-center">
            <small class="text-muted">Click to expand</small>
        </div>
    </div>

    <!-- Full Details View (Initially Hidden) -->
    <div id="user-details" class="card pt-5 d-none">
        <img src="{{ $user->profile_image ? Storage::url($user->profile_image) : asset('img/user.png') }}" 
             alt="Profile Image" 
             style="width: 15%; border-radius: 50%; margin: 0 auto;">
        <h2 class="card-header text-center">User Details</h2>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary btn-sm mb-3" href="{{ route('users.index') }}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <table class="table table-bordered">
                <tr>
                    <th>Name:</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Phone number:</th>
                    <td>{{ $user->phone_number }}</td>
                </tr>
                <tr>
                    <th>Department:</th>
                    @if($user->department_id)
                        <td>{{ $user->department->department_name }}</td>
                    @else
                        <td><p class="badge badge-info">Not Assigned</p></td>
                    @endif
                </tr>
                @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                    <tr>
                        <th>Role</th>
                        @if($user->roles->isNotEmpty())
                            <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                        @else
                            <td><p class="badge badge-info">Not Assigned</p></td>
                        @endif
                    </tr>
                @endif
                @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']) && !$user->department)
                    @php
                        $password = 'sits@' . substr($user->phone_number, -4);
                    @endphp
                    <tr>
                        <th class="text-danger">Original Password (User Must Change)</th>
                        <td>{{ $password }}</td>
                    </tr>
                    @endif
                </table>
            @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                <div class="d-flex justify-content-end mt-4">
                    @if(!$user->is_approved)
                        <a href="{{ route('users.approved', $user->id) }}" class="btn btn-success btn-sm me-2">
                            <i class="fa-solid fa-user-check"></i> Approve
                        </a>
                    @endif
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endif
            <div class="mt-4 text-center">
                <a href="#" id="collapse-details">Click to collapse</a>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
<div class="row mt-4">
    <!-- Today's Performance -->
    <div class="col-12 col-md-6 col-lg-8 mb-6">

        {{-- List daily tasks --}}
        <ul class="list-group">
            <li class="list-group-item active">
                <h5 class="mb-0">Today's Tasks ({{ now()->format('M j, Y') }})</h5>
            </li>
            @if($dailyTasks->isEmpty())
                <li class="list-group-item">
                    <em>No tasks assigned for today.</em>
                </li>
            @else
                @foreach($dailyTasks as $dtask)
                    <div class="list-group">
                        @forelse($dailyTasks as $dtask)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
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
                            </div>
                        @empty
                            <div class="list-group-item">No daily tasks found.</div>
                        @endforelse
                    </div>
                @endforeach
            @endif
        </ul>
    </div>
    
    <!-- Fortnight Performance -->
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $fortnight ? \Carbon\Carbon::parse($fortnight->start_date)->format('M j') .' - '. \Carbon\Carbon::parse($fortnight->end_date)->format('M j') : 'This Fortnight' }} Performance</h5>
                <form action="" method="get">
                    <select name="fortnight" onchange="getElementById('fortnightSelectorBtn').click()" class="form-select form-select-sm w-auto text-truncate" id="fortnight-filter" style="max-width: 130px;" id="fortnight-filter">
                        <option value="">This Fortnight</option>
                        {{-- The loop items name is $fort because $fortnight is already in use --}}
                        @foreach ($fortnights as $fort) 
                        <option {{ request()->query('fortnight') && request()->query('fortnight') == $fort->id ? 'selected' : '' }} value="{{ $fort->id }}"> {{ \Carbon\Carbon::parse($fort->start_date)->format('M j') }} - {{ \Carbon\Carbon::parse($fort->end_date)->format('M j') }} </option>                                
                        @endforeach
                    </select>
                    <button type="submit" id="fortnightSelectorBtn" hidden></button>
                </form>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center">
                <canvas id="fortnightTasksChart" style="max-width: 100%; height: auto;"></canvas>
            </div>
        </div>
    </div>
    
</div>

<!-- Performance Summary Table -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Task Summary Table</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Period</th>
                        <th>Pending</th>
                        <th>In Progress</th>
                        <th>Completed</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ request()->query('date') ? \Carbon\Carbon::parse(request()->query('date'))->format('M j') : 'Today\'s' }}</td>
                        <td>{{ $dailyPendingTasks }}</td>
                        <td>{{ $dailyInProgressTasks }}</td>
                        <td>{{ $dailyCompletedTasks }}</td>
                        <td>{{ $dailyPendingTasks + $dailyInProgressTasks + $dailyCompletedTasks }}</td>
                    </tr>
                        <td>
                            {{ $fortnight ? \Carbon\Carbon::parse($fortnight->start_date)->format('M j') .' - '. \Carbon\Carbon::parse($fortnight->end_date)->format('M j') : 'This Fortnight' }}
                            {{ $fortnight ? \Carbon\Carbon::parse($fortnight->start_date)->format('M j') .' - '. \Carbon\Carbon::parse($fortnight->end_date)->format('M j') : 'This Fortnight' }} Performance
                        </td>
                        <td>{{ $fortnightPendingTasks }}</td>
                        <td>{{ $fortnightInProgressTasks }}</td>
                        <td>{{ $fortnightCompletedTasks }}</td>
                        <td>{{ $fortnightPendingTasks + $fortnightInProgressTasks + $fortnightCompletedTasks }}</td>
                    </tr>
                    <tr>
                        <td>All Time</td>
                        <td>{{ $allPendingTasks }}</td>
                        <td>{{ $allInProgressTasks }}</td>
                        <td>{{ $allCompletedTasks }}</td>
                        <td>{{ $allPendingTasks + $allInProgressTasks + $allCompletedTasks }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


    <!-- Assigned Tasks -->
    <div class="card pt-5">
        <h2 class="card-header text-center">
            @if (request()->query('date'))
                {{ request()->query('date') }} Tasks
            @elseif (request()->query('fortnight') && $fortnight)
                {{ \Carbon\Carbon::parse($fortnight->start_date)->format('M j') }} - 
                {{ \Carbon\Carbon::parse($fortnight->end_date)->format('M j') }} Tasks
            @else
                All Assigned Tasks
            @endif
        </h2>
        
        @include('tasks.list')
        
        <div class="mt-3">
            {{ $tasks->appends(request()->query())->links() }}
        </div>


        @if ($fortnight)
            @php
                $deliverables = $fortnight->deliverables()->where('user_id', $user->id)->paginate(30);
            @endphp
            <h2 class="card-header text-center">
                    Deliverables for the selected fortnight
            </h2>

            @include('deliverables.list')
            
        @endif
    </div>
</div>


<script>
    
    
    document.addEventListener("DOMContentLoaded", function () {
        // Toggle to show the full details view when the summary is clicked.
        document.getElementById('user-summary').addEventListener('click', function() {
            document.getElementById('user-summary').classList.add('d-none');
            document.getElementById('user-details').classList.remove('d-none');
        });
    
        // Toggle to collapse back to the summary view when the collapse link is clicked.
        document.getElementById('collapse-details').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('user-details').classList.add('d-none');
            document.getElementById('user-summary').classList.remove('d-none');
        });


        var ctx1 = document.getElementById("dailyTasksChart").getContext("2d");
        var ctx2 = document.getElementById("fortnightTasksChart").getContext("2d");
        var ctx = document.getElementById("allTasksChart").getContext("2d");

        var dailyTasksChart = new Chart(ctx1, {
            type: "pie",
            data: {
                labels: ["Pending", "Progress", "Completed"],
                datasets: [{
                    data: [{{ $dailyPendingTasks }}, {{ $dailyInProgressTasks }}, {{ $dailyCompletedTasks }}],
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

        var fortnightTasksChart = new Chart(ctx2, {
            type: "pie",
            data: {
                labels: ["Pending", "Progress", "Completed"],
                datasets: [{
                    data: [{{ $fortnightPendingTasks }}, {{ $fortnightInProgressTasks }}, {{ $fortnightCompletedTasks }}],
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

        var allTasksChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Pending", "Progress", "Completed"],
                datasets: [{
                    data: [{{ $allPendingTasks }}, {{ $allInProgressTasks }}, {{ $allCompletedTasks }}],
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
@endsection
