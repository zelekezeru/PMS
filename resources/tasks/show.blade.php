<x-admin-layout>
    <div class="container mt-5 pt-5">
        <div class="container mt-5">
            <div class="row">
                <!-- Task Details Section -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Task Details</h3>
                            <a href="#" class="btn btn-primary btn-sm float-end">Back to Tasks</a>
                        </div>
                        <div class="card-body">
                            <h4 class="mb-3"><i class="fas fa-tasks"></i> Task Title: {{ $task->title }}</h4>
                            <p><strong>Description:</strong> {{ $task->description }}</p>
                            <p><strong>Budget:</strong> ${{ number_format($task->budget, 2) }}</p>
                            <p>
                                <strong>Status:</strong>
                                <span class="badge bg-info">{{ $task->status }}</span>
                            </p>
                            <p><strong>Duration:</strong> {{ $task->duration ?? 'N/A' }} Days</p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" id="showFeedbackModal"
                                data-bs-target="#feedbackModal">
                                <i class="fas fa-comments"></i> Show Feedback
                            </button>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit Task
                            </a>
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="alert('Delete functionality not implemented yet!')">
                                <i class="fas fa-trash"></i> Delete Task
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Feedback Modal -->
                    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Feedback Form -->
                                    <form class="mb-3" method="POST" action="{{ route('feedbacks.store', $task) }}">
                                        @csrf
                                        <div class="input-group">
                                            <textarea class="form-control" id="feedback" name="comment" rows="1" placeholder="Write your feedback..."></textarea>
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </div>
                                        @error('comment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </form>

                                    <hr>

                                    <!-- Feedback Chat -->
                                    <div class="feedback-section" style="max-height: 400px; overflow-y: auto;">
                                        <h5 class="mb-3">Recent Feedback</h5>
                                        <div class="feedback-list">
                                            <!-- Feedback Item -->
                                            @forelse ($task->feedbacks as $feedback)
                                                @if ($feedback->feedback_id == null)
                                                    <div class="feedback-item mb-4">
                                                        <div class="d-flex align-items-start">
                                                            <div class="avatar me-3">
                                                                <img src="{{ $feedback->user->avatar_url ?? 'default-avatar.png' }}"
                                                                    alt="{{ $feedback->user->name }}"
                                                                    class="rounded-circle"
                                                                    style="width: 40px; height: 40px;">
                                                            </div>
                                                            <div class="chat-bubble">
                                                                <strong>{{ $feedback->user->name }}</strong>
                                                                <small
                                                                    class="text-muted ms-2">{{ $feedback->created_at->diffForHumans() }}</small>
                                                                <p class="mb-2">{{ $feedback->comment }}</p>

                                                                <!-- Reply Toggle with Counter -->
                                                                <a href="javascript:void(0);"
                                                                    class="text-primary toggle-reply-btn"
                                                                    style="font-size: 0.9rem;">
                                                                    {{ $feedback->replies->count() }}
                                                                    {{ Str::plural('Reply', $feedback->replies->count()) }}
                                                                </a>

                                                                <!-- Reply Section -->
                                                                <div class="reply-section d-none mt-3">
                                                                    <!-- Reply Form -->
                                                                    <form
                                                                        action="{{ route('feedbacks.store', $task) }}"
                                                                        method="POST" class="d-flex">
                                                                        @csrf
                                                                        <input type="hidden"
                                                                            value="{{ $feedback->id }}"
                                                                            name="reply_to">
                                                                        <textarea class="form-control me-2" name="comment" rows="1" placeholder="Reply..."></textarea>
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-sm">Send</button>
                                                                    </form>
                                                                    @error('comment')
                                                                        <div class="text-danger mt-2">{{ $message }}
                                                                        </div>
                                                                    @enderror

                                                                    <!-- Replies -->
                                                                    <div class="mt-3">
                                                                        @forelse ($feedback->replies as $reply)
                                                                            <div
                                                                                class="reply-item border-start ps-3 mb-2">
                                                                                <strong>{{ $reply->user->name }}</strong>
                                                                                <small
                                                                                    class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                                                <p>{{ $reply->comment }}</p>
                                                                            </div>
                                                                        @empty
                                                                            <p class="text-muted">No replies yet.</p>
                                                                        @endforelse
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @empty
                                                <p class="text-muted">No feedbacks available yet.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Toggle reply section visibility
                        document.querySelectorAll('.toggle-reply-btn').forEach(link => {
                            link.addEventListener('click', function() {
                                const replySection = this.nextElementSibling; // Target the reply section
                                replySection.classList.toggle('d-none');
                            });
                        });
                    </script>



                    <!-- Add New KPI Form (Collapsible) -->
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Add New KPI</h3>
                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#addKPIForm">
                                Add KPI
                            </button>
                        </div>
                        <div id="addKPIForm" class="collapse">
                            <div class="card-body">
                                <form action="{{ route('kpis.store', $task->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="performance_indicators" class="form-label">Performance Indicators</label>
                                        <textarea name="performance_indicators" id="performance_indicators" class="form-control" rows="2" required></textarea>
                                        @error('performance_indicators')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                        
                                    <!-- Selection for KPI Type -->
                                    <div class="mb-3">
                                        <label for="kpi_type" class="form-label">KPI Type</label>
                                        <select name="kpi_type" id="kpi_type" class="form-control" required>
                                            <option value="" disabled selected>Select KPI Type</option>
                                            <option value="qualitative">Qualitative</option>
                                            <option value="quantitative">Quantitative</option>
                                        </select>
                                        @error('kpi_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                        
                                    <!-- Qualitative Input -->
                                    <div class="mb-3 d-none" id="qualitative-container">
                                        <label for="qualitative" class="form-label">Qualitative</label>
                                        <textarea name="qualitative" id="qualitative" class="form-control" rows="2"></textarea>
                                        @error('qualitative')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                        
                                    <!-- Quantitative Input -->
                                    <div class="mb-3 d-none" id="quantitative-container">
                                        <label for="quantitative" class="form-label">Quantitative</label>
                                        <input type="number" name="quantitative" id="quantitative" class="form-control">
                                        @error('quantitative')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                        
                                    <!-- Ratings Input -->
                                    <div class="mb-3 d-none" id="ratings-container">
                                        <label for="ratings" class="form-label">Ratings (0-5)</label>
                                        <input type="number" name="ratings" id="ratings" class="form-control" step="0.1" min="0" max="5">
                                        @error('ratings')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                        
                                    <button type="submit" class="btn btn-success btn-sm">Submit KPI</button>
                                </form>
                            </div>
                        </div>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const kpiType = document.getElementById('kpi_type');
                                const qualitativeContainer = document.getElementById('qualitative-container');
                                const quantitativeContainer = document.getElementById('quantitative-container');
                                const ratingsContainer = document.getElementById('ratings-container');
                        
                                kpiType.addEventListener('change', function () {
                                    if (this.value === 'qualitative') {
                                        qualitativeContainer.classList.remove('d-none');
                                        quantitativeContainer.classList.add('d-none');
                                        ratingsContainer.classList.add('d-none');
                                    } else if (this.value === 'quantitative') {
                                        qualitativeContainer.classList.add('d-none');
                                        quantitativeContainer.classList.remove('d-none');
                                        ratingsContainer.classList.remove('d-none');
                                    } else {
                                        qualitativeContainer.classList.add('d-none');
                                        quantitativeContainer.classList.add('d-none');
                                        ratingsContainer.classList.add('d-none');
                                    }
                                });
                            });
                        </script>
                        



                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- List of Existing KPIs -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Key Performance Indicators (KPIs)</h3>
                        </div>
                        <div class="card-body">
                            @if ($task->kpis->isEmpty())
                                <p>No KPIs have been added yet for this task.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Performance Indicators</th>
                                            <th>Qualitative</th>
                                            <th>Quantitative</th>
                                            <th>Ratings</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($task->kpis as $kpi)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <!-- Editable fields -->
                                                <form action="{{ route('kpis.update', $kpi->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <td>
                                                        <input type="text" name="performance_indicators"
                                                            class="form-control"
                                                            value="{{ $kpi->performance_indicators }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="qualitative" class="form-control"
                                                            value="{{ $kpi->qualitative }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="quantitative"
                                                            class="form-control" value="{{ $kpi->quantitative }}"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="ratings" class="form-control"
                                                            value="{{ $kpi->ratings }}" step="0.1"
                                                            min="0" max="5" required>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm me-2">Update</button>
                                                        </div>
                                                    </td>
                                                </form>
                                                <!-- Delete Form -->
                                                <td>
                                                    <form action="{{ route('kpis.destroy', $kpi->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this KPI?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CLICK ON MODAL TOGGLER BUTTON IF THE PAGE IS APPEARING RIGHT AFTER A USER SENDS A FEEDBACK --}}

                
                @if (session('showFeedback'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.getElementById('showFeedbackModal').click();
                        });
                    </script>
                @endif  
</x-admin-layout>
