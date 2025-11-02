@extends('layouts.app')

@section('contents')

<div class="container mt-3">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white shadow-sm rounded-3 border-0">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" aria-hidden>
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h.5A1.5 1.5 0 0 1 15 2.5v11A1.5 1.5 0 0 1 13.5 15h-11A1.5 1.5 0 0 1 1 13.5v-11A1.5 1.5 0 0 1 2.5 1H3V.5A.5.5 0 0 1 3.5 0zM2 4v9.5a.5.5 0 0 0 .5.5H13.5a.5.5 0 0 0 .5-.5V4H2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">Daily Tasks</h3>
                            <p class="mb-0 text-muted small">Tasks assigned to employees for <strong>{{ $selectedDate }}</strong>.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <form method="get" id="dateForm" class="d-flex align-items-center gap-2">
                            <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                            <div class="input-group input-group-sm shadow-sm rounded-pill overflow-hidden" style="width:240px; border: 1px solid rgba(0,0,0,0.06);">
                                <span class="input-group-text bg-primary text-white border-0 pe-2" id="date-addon" style="padding-left:0.9rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="text-white" viewBox="0 0 16 16" aria-hidden>
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h.5A1.5 1.5 0 0 1 15 2.5v11A1.5 1.5 0 0 1 13.5 15h-11A1.5 1.5 0 0 1 1 13.5v-11A1.5 1.5 0 0 1 2.5 1H3V.5A.5.5 0 0 1 3.5 0zM2 4v9.5a.5.5 0 0 0 .5.5H13.5a.5.5 0 0 0 .5-.5V4H2z"/>
                                    </svg>
                                </span>

                                <input
                                    type="date"
                                    id="dateInput"
                                    name="date"
                                    value="{{ $selectedDate }}"
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

                        <div class="gap-2">
                            <a href="{{ route('daily_tasks.create', ['dailyTask' => true]) }}" class="btn btn-primary rounded-pill shadow-sm" style="transition: background-color 0.3s, transform 0.3s;" onmouseover="this.style.backgroundColor='#0056b3'; this.style.transform='scale(1.05)';" onmouseout="this.style.backgroundColor=''; this.style.transform='';">Create Daily Task</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

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

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="mb-0">Tasks for {{ $selectedDate }} </h5>
					<div>
						<span class="text-muted small">Showing {{ $dailyTasks->count() }} task(s)</span>
					</div>
				</div>
				<div class="card-body p-0">
					@if($dailyTasks->isEmpty())
						<div class="p-4 text-center text-muted">No tasks for this day.</div>
					@else
						<div class="table-responsive">
							<table class="table table-hover mb-0">
								<thead>
									<tr>
										<th style="width:60px">#</th>
										<th>Title</th>
										<th>Description</th>
										<th>Assigned</th>
										<th style="width:140px">Status</th>
										<th style="width:160px">Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($dailyTasks as $i => $task)
										<tr onclick="window.location='{{ route('daily_tasks.show', $task) }}'" style="cursor:pointer">
											<td>{{ $i + 1 }}</td>
											<td>{{ $task->title }}</td>
											<td class="text-truncate" style="max-width:320px">{{ \Illuminate\Support\Str::limit($task->description, 80) }}</td>
											<td>{{ optional($task->user)->name ?? '—' }}</td>
											<td>
												@if($task->status === 'Completed')
													<span class="badge bg-success">Completed</span>
												@elseif($task->status === 'In Progress' || $task->status === 'InProgress')
													<span class="badge bg-warning text-dark">In Progress</span>
												@else
													<span class="badge bg-secondary">Pending</span>
												@endif
											</td>
											<td>
												<a href="{{ route('daily_tasks.show', $task) }}" class="btn btn-sm btn-info">View</a>
												<a href="{{ route('daily_tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">Edit</a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>

</div>

@endsection
