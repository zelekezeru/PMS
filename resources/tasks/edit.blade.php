<x-admin-layout>
    <div class="container mt-5 pt-5">
        <div class="card mt-5">
            <!-- Display success message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="card-header text-center">Edit Task</h2>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-primary btn-sm" href="{{ route('tasks.list') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <!-- Form to edit the task -->
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Task Title -->
                        <div class="col-md-6 mb-3">
                            <label for="inputTitle" class="form-label"><strong>Task Title:</strong></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="inputTitle" placeholder="Task Title" value="{{ old('title', $task->title) }}" required>
                            @error('title')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Task Description -->
                        <div class="col-md-6 mb-3">
                            <label for="inputDescription" class="form-label"><strong>Description:</strong></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="inputDescription" placeholder="Task Description" required>{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Task Duration -->
                        <div class="col-md-6 mb-3">
                            <label for="inputDuration" class="form-label"><strong>Duration (hours):</strong></label>
                            <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror" id="inputDuration" placeholder="Duration" value="{{ old('duration', $task->duration) }}">
                            @error('duration')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Task Budget -->
                        <div class="col-md-6 mb-3">
                            <label for="inputBudget" class="form-label"><strong>Budget:</strong></label>
                            <input type="number" step="0.01" name="budget" class="form-control @error('budget') is-invalid @enderror" id="inputBudget" placeholder="Budget" value="{{ old('budget', $task->budget) }}" required>
                            @error('budget')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Task Status -->
                        <div class="col-md-6 mb-3">
                            <label for="inputStatus" class="form-label"><strong>Status:</strong></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" id="inputStatus" required>
                                <option value="Pending" {{ old('status', $task->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ old('status', $task->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ old('status', $task->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
