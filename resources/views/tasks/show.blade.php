@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Task Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3 mx-4" href="{{ route('tasks.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <a class="btn btn-success btn-sm mb-3" href="{{ route('kpis.create_task', ['task' => $task->id]) }}"><i class="fa fa-plus"></i> Add Task KPI</a>
                    
                </div>

                <table class="table table-bordered">

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#feedbackModal" data-task-id="{{ $task->id }}">
                        View Feedback
                    </button>

                    <tr>
                        <th>Task Title:</th>
                        <td>{{ $task->name }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $task->description }}</td>
                    </tr>
                    <tr>
                        <th>Target:</th>
                        <td>{{ $task->target ? $task->target->name : "Not Assigned Yet" }}</td>
                    </tr>
                    <tr>
                        <th>Starting Date:</th>
                        <td>{{ $task->starting_date ? \Carbon\Carbon::parse($task->starting_date)->format('M - d - Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Due Date:</th>
                        <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M - d - Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Budget:</th>
                        <td>{{ $task->budget }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN', 'DEPARTMENT_HEAD']) || Auth::user()->tasks->contains($task->id))
                            @if ($task->status != 'Completed')
                                <td>
                                    <div class="col-6">
                                        <form action="{{ route('tasks.status', $task->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" id="status" style="border: 2px solid black;" class="form-control col-lg-4 col-sm-6 @error('status') is-invalid @enderror"  onchange="this.form.submit()" optional>
                                                <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Progress" {{ $task->status == 'Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </form>
                                    </div>
                                </td>
                                @error('status')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <td class="badge badge-success me-4">Completed !</td>
                            @endif
                        @endif
                    </tr>
                    <tr>
                        <th>Barriers:</th>
                        <td>{{ $task->barriers }}</td>
                    </tr>
                    <tr>
                        <th>Comunication:</th>
                        <td>{{ $task->comunication }}</td>
                    </tr>
                    <tr>
                        <th>Created By:</th>
                        <td>{{$task->createdBy->name}}</td>
                    </tr>
                    <tr>
                        <th>Departments:</th>
                        <td>
                            @if($task->departments && $task->departments->count() > 0)
                                @foreach($task->departments as $department)
                                    <strong>
                                        @if(!request()->user()->hasAnyRole('EMPLOYEE', 'DEPARTMENT_HEAD'))
                                            <a href="{{route('departments.show', $department)}}"> {{ $department->department_name }} </a>,
                                        @else
                                            {{ $department->department_name }},
                                        @endif
                                    </strong>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('tasks.create', ['parent_task_id' => $task->id]) }}" class="btn btn-primary btn-sm me-2">
                        <i class="fas fa-add"></i> Add Sub Task
                    </a>
                    @can('manageTask', $task)
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $task->id }})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    @endcan

                    <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

        @if($task->subtasks->isNotEmpty())
            
            <div class="card-header">
                <h3 class="card-title mb-5">Sub Task of this task</h3>
            </div>

            @include('tasks.subtask')
            
        @endif

        @if ($task->kpis)
            @php
                $kpis = $task->kpis()->paginate(15);
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">KPIs of this task</h3>
            </div>

            <div class="col mb-4">
                <a class="btn btn-success btn-sm mr-2" href="{{ route('kpis.create_task', ['task' => $task->id]) }}"><i class="fa fa-plus"></i> Add Task KPI</a>
            </div>

            @include('kpis.list')
        @else
            <div class="alert alert-warning mt-3">
                <p>No KPIs found for this task.</p>
            </div>
        @endif
    </div>

@endsection
<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Task Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="feedback-list" class="feedback-chat-container">
                    <!-- Feedback messages will be dynamically inserted here -->
                </div>

                <!-- Add Feedback Form -->
                <form id="feedbackForm" class="d-flex align-items-center mt-3">
                    @csrf
                    <input type="hidden" id="task_id" name="task_id">
                    <input type="hidden" id="feedback_id" name="feedback_id"> <!-- For replies -->

                    <div class="flex-grow-1 me-2">
                        <textarea id="comment" class="form-control chat-input" name="comment" placeholder="Write a comment..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let feedbackModal = document.getElementById("feedbackModal");

        // When the modal is about to be shown
        feedbackModal.addEventListener("show.bs.modal", function (event) {
            let button = event.relatedTarget; // The button that triggered the modal
            let taskId = button.getAttribute("data-task-id");

            document.getElementById("task_id").value = taskId;
            document.getElementById("feedback_id").value = ""; // Reset reply field

            loadFeedback(taskId);
        });

        // Submit feedback form
        document.getElementById("feedbackForm").addEventListener("submit", function (event) {
            event.preventDefault();
            submitFeedback();
        });
    });

    // Load feedback for the task
    function loadFeedback(taskId) {
        fetch(`/feedbacks/${taskId}`)
            .then(response => response.json())
            .then(data => {
                let feedbackList = document.getElementById("feedback-list");
                feedbackList.innerHTML = "";

                if (data.length === 0) {
                    feedbackList.innerHTML = "<p class='text-muted text-center'>No feedback yet. Be the first to comment!</p>";
                } else {
                    data.forEach(feedback => {
                        let feedbackHtml = renderFeedback(feedback);
                        feedbackList.innerHTML += feedbackHtml;
                    });
                }
            })
            .catch(error => console.error("Error fetching feedback:", error));
    }

    // Submit feedback (for new feedback and replies)
    function submitFeedback() {
        let formData = new FormData(document.getElementById("feedbackForm"));

        fetch("/feedback", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(response => response.json())
        .then(data => {
            loadFeedback(document.getElementById("task_id").value);
            document.getElementById("comment").value = "";
            document.getElementById("feedback_id").value = ""; // Reset reply field
        })
        .catch(error => console.error("Error submitting feedback:", error));
    }

    // Delete feedback or reply without confirmation
    function deleteFeedback(feedbackId) {
        fetch(`/feedback/${feedbackId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === "Feedback deleted successfully") {
                loadFeedback(document.getElementById("task_id").value);
            } else {
                alert(data.message); // Display error if the user is not authorized
            }
        })
        .catch(error => console.error("Error deleting feedback:", error));
    }

    // Render feedback and replies in HTML
    function renderFeedback(feedback) {
        let replies = feedback.replies ? feedback.replies.map(reply => `
            <div class="feedback-message replies">
                <div class="feedback-avatar"></div>
                <div class="feedback-content">
                    <div class="feedback-username">${reply.user.name}</div>
                    <div class="feedback-text">${reply.comment}</div>
                    <div class="feedback-time">${new Date(reply.created_at).toLocaleString()}</div>
                    <button class="btn btn-sm border-0 text-danger" onclick="deleteFeedback(${reply.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `).join("") : "";

        return `
            <div class="feedback-message">
                <div class="feedback-avatar"></div>
                <div class="feedback-content">
                    <div class="feedback-username">${feedback.user.name}</div>
                    <div class="feedback-text">${feedback.comment}</div>
                    <div class="feedback-time">${new Date(feedback.created_at).toLocaleString()}</div>
                    <span class="reply-btn" onclick="setReply(${feedback.id})">Reply</span>
                    <button class="btn btn-sm border-0 text-danger" onclick="deleteFeedback(${feedback.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                    ${replies}
                </div>
            </div>
        `;
    }

    // Set feedback to reply to
    function setReply(feedbackId) {
        document.getElementById("feedback_id").value = feedbackId;
        document.getElementById("comment").focus();
    }
</script>
@endsection
