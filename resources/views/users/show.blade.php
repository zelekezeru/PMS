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
        <h2 class="card-header text-center">{{ $user->name }}</h2>
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
                {{$user}}
                @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))

                    @if($user->default_password)
                        <tr>
                            <th>Default Password:</th>
                            <td>
                                <span id="password-masked">********</span>
                                <span id="password-text" style="display: none;">{{ $user->default_password }}</span>
                                <button id="toggle-password" onclick="togglePasswordVisibility()" class="btn btn-sm btn-outline-secondary ms-2">Show</button>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <th>Password Status:</th>
                            <td>
                                <span class="badge badge-success mb-2">Password Changed</span>
                                    {{-- Reset Button --}}
                                <form action="{{ route('users.resetPassword', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reset the password for this user?');">
                                    @csrf
                                    <input type="text" name="new_password" class="form-control mb-2" value="sits.{{ isset($user->phone_number) ? substr($user->phone_number, -4) : '' }}" hidden required>
                                    
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <i class="fas fa-key"></i> Reset Password
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endif
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
            <li class="list-group-item active d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Tasks for {{ isset($selectedDate) ? \Carbon\Carbon::parse($selectedDate)->format('M j, Y') : now()->format('M j, Y') }}</h5>
                </div>
                
                <div class="d-flex align-items-end gap-2">
                    <form method="get" id="dateForm" class="d-flex align-items-end gap-2">
                        <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                        <div class="input-group input-group-sm shadow-sm rounded-pill overflow-hidden" style="width:240px; border: 1px solid rgba(88, 59, 59, 0.06);">
                            <span class="input-group-text bg-primary text-white border-0 pe-2" id="date-addon" style="padding-left:0.9rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="text-white" viewBox="0 0 16 16" aria-hidden>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h.5A1.5 1.5 0 0 1 15 2.5v11A1.5 1.5 0 0 1 13.5 15h-11A1.5 1.5 0 0 1 1 13.5v-11A1.5 1.5 0 0 1 2.5 1H3V.5A.5.5 0 0 1 3.5 0zM2 4v9.5a.5.5 0 0 0 .5.5H13.5a.5.5 0 0 0 .5-.5V4H2z"/>
                                </svg>
                            </span>

                            <input
                                type="date"
                                id="dateInput"
                                name="date"
                                value="{{ $selectedDate ?? now()->toDateString() }}"
                                class="form-control border-0"
                                onchange="this.form.submit()"
                                aria-label="Select date"
                                style="background: linear-gradient(180deg, #e0f7fa, #fbfbfd);"
                            >

                            <button
                                type="button"
                                class="btn btn-sm btn-success rounded-end"
                                title="Today"
                                onclick="(function(){ const d = new Date().toISOString().slice(0,10); document.getElementById('dateInput').value = d; document.getElementById('dateForm').submit(); })()"
                                aria-label="Set date to today"
                                style="border-left:1px solid rgba(0,0,0,0.04);"
                            >
                                Today
                            </button>
                        </div>
                    </form>
                </div>
            </li>

            <script>
                // small helper to shift the shown date and resubmit form
                function adjustDate(delta) {
                    const input = document.getElementById('dateInput');
                    // ensure a valid date
                    const cur = input.value ? new Date(input.value) : new Date();
                    cur.setDate(cur.getDate() + delta);
                    // format YYYY-MM-DD
                    const iso = cur.toISOString().slice(0,10);
                    input.value = iso;
                    document.getElementById('dateForm').submit();
                }
            </script>

            @if($dailyTasks->isEmpty())
                <li class="list-group-item">
                    <em>No tasks assigned for this date.</em>
                </li>
            @else
                <div class="list-group">
                    @forelse($dailyTasks as $dtask)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $dtask->title }}</h6>
                                @if(!empty($dtask->description))
                                    <small class="text-muted d-block">{{ \Illuminate\Support\Str::limit($dtask->description, 120) }}</small>
                                @endif
                                @if(isset($dtask->due_date))
                                    <small class="text-muted d-block">Due: {{ \Carbon\Carbon::parse($dtask->due_date)->format('M j, Y') }}</small>
                                @endif
                            </div>

                            <div class="d-flex align-items-center">
                                @php
                                    $status = $dtask->status ?? 'Unknown';
                                    $badgeClass = $status === 'Completed' ? 'success' : ($status === 'In Progress' ? 'warning' : 'secondary');
                                @endphp
                                <span class="badge bg-{{ $badgeClass }} me-3">{{ $status }}</span>
                                <a href="{{ route('daily_tasks.show', $dtask) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item">No daily tasks found.</div>
                    @endforelse
                </div>
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
    function togglePasswordVisibility() {
        const text = document.getElementById('password-text');
        const masked = document.getElementById('password-masked');
        const button = document.getElementById('toggle-password');
        if (text.style.display === 'none') {
            text.style.display = 'inline';
            masked.style.display = 'none';
            button.textContent = 'Hide';
        } else {
            text.style.display = 'none';
            masked.style.display = 'inline';
            button.textContent = 'Show';
        }
    }
</script>
@endsection
