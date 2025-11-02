@extends('layouts.app')

@section('contents')
<div class="container py-5">

    <!-- Header Card -->
    <div class="card border-0 shadow-lg rounded-4 mb-4 bg-light-subtle">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start gap-4">

                <!-- Status Pill -->
            @php
                $status = strtolower(str_replace(' ', '', $dailyTask->status ?? 'Pending'));
            @endphp

            <!-- Left: Task User Info -->
            <div class="d-flex align-items-start gap-3">
                <!-- Avatar -->
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow"
                     style="width:30px;height:30px;font-size:1.5rem;font-weight:600;">
                    {{ strtoupper(substr(optional($dailyTask->user)->name ?? 'U', 0, 1)) }}
                </div>

                <!-- User & Status Info -->
                <div>
                    <h5 class="fw-bold mb-1 text-primary">
                        {{ $dailyTask->title }}
                    </h5>
                </div>

                <!-- Back Button (aligned to end of the row) -->
                </div>
                <div class="ms-auto d-flex align-items-center">
                    <a id="backButton" href="{{ route('daily_tasks.index') }}" class="btn btn-sm btn-outline-info" role="button" onclick="event.stopPropagation();">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-4">
        <!-- Left Section -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted mb-3">Task Details</h6>

                    <p><strong>Title:</strong> <span class="fs-5 text-dark">{{ $dailyTask->title }}</span></p>

                    <p class="mb-2"><strong>Description:</strong></p>
                    @if($dailyTask->description)
                        <div class="bg-light p-3 rounded-3 border" style="white-space: pre-wrap;">{{ $dailyTask->description }}</div>
                    @else
                        <p class="text-muted">No description provided.</p>
                    @endif

                    <div class="mt-3">
                        <p class="mb-1"><strong>Status:</strong>
                            @if($status === 'completed')
                                <span class="badge bg-success rounded-pill"><i class="fa-solid fa-check me-1"></i> Completed</span>
                            @elseif($status === 'inprogress')
                                <span class="badge bg-warning text-dark rounded-pill"><i class="fa-solid fa-hourglass-half me-1"></i> In Progress</span>
                            @else
                                <span class="badge bg-secondary rounded-pill"><i class="fa-regular fa-circle-dot me-1"></i> Pending</span>
                            @endif
                        </p>

                        <p class="mb-1"><strong>Assigned To:</strong> {{ $dailyTask->assigned_to ?? 'Unassigned' }}</p>
                        <p class="mb-0"><strong>Date:</strong> {{ \Carbon\Carbon::parse($dailyTask->date ?? $dailyTask->created_at)->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top:90px;">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted mb-3">Additional Informations</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <span class="text-muted">Created:</span><br>
                            <strong>{{ \Carbon\Carbon::parse($dailyTask->created_at)->format('F j, Y \a\t g:ia') }}</strong>
                        </li>
                        @if($dailyTask->updated_at)
                            <li class="mb-2">
                                <span class="text-muted">Last updated:</span><br>
                                <strong>{{ \Carbon\Carbon::parse($dailyTask->updated_at)->diffForHumans() }}</strong>
                            </li>
                        @endif
                    </ul>

                    <div class="d-grid gap-2 mt-4">
                        @if($dailyTask->status == 'Completed')

                            <button type="button" class="btn btn-success w-100" disabled>
                                <i class="fa-solid fa-check me-2"></i> Completed Task
                            </button>

                        @else
                            <p><strong>Change Status:</strong></p>
                            <form action="{{ route('daily_tasks.updateStatus', $dailyTask) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                @php $current = strtolower(str_replace(' ', '', $dailyTask->status ?? 'Pending')); @endphp
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="Pending" {{ $current === 'pending' ? 'selected' : '' }} style="color: gray; background-color: #f8f9fa;">Pending</option>
                                    <option value="In Progress" {{ $current === 'inprogress' ? 'selected' : '' }} style="color: orange; background-color: #fff3cd;">In Progress</option>
                                    <option value="Completed" {{ $current === 'completed' ? 'selected' : '' }} style="color: green; background-color: #d4edda;">Completed</option>
                                </select>
                            </form>

                            <div>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-trash me-1"></i> Delete
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <form action="{{ route('daily_tasks.destroy', $dailyTask) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel"><i class="fa-solid fa-triangle-exclamation me-2"></i>Confirm Delete</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete the task "<strong>{{ $dailyTask->title }}</strong>"?
                        <br><span class="text-muted small">This action cannot be undone.</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- Copy ID Script -->
<script>
function copyId() {
    const id = document.getElementById('taskId').textContent.trim();
    navigator.clipboard.writeText(id).then(() => {
        alert('✅ Task ID copied: ' + id);
    }).catch(() => alert('❌ Unable to copy ID'));
}
</script>
@endsection
