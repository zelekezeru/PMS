<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="row">
        <!-- Task Information Card -->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <strong>Task Information</strong>
                </div>
                <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" id="name" value="{{ Auth::user()->id }}" readonly hidden>

                <div class="card-body">
                    <div class="row">
                        <!-- Task Title and Description -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Task Title:</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $task->name ?? '') }}" placeholder="Title" required>
                            @error('name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3" placeholder="Description">{{ old('description', $task->description ?? '') }}</textarea>
                            @error('description')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Parent Task -->
                        <div class="col-md-6 mb-3">
                            <label for="parent_task_id" class="form-label">Parent Task:</label>
                            <select name="parent_task_id" class="form-control @error('parent_task_id') is-invalid @enderror" id="parent_task_id">
                                <option value="">None</option>
                                @foreach($parent_tasks as $parent_task)
                                    <option value="{{ $parent_task->id }}" {{ old('parent_task_id', $task->parent_task_id ?? '') == $parent_task->id ? 'selected' : '' }}>{{ $parent_task->name }}</option>
                                @endforeach
                            </select>
                            @error('parent_task_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label"><strong>Status:</strong></label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="Pending" {{ old('status', $kpi->status ?? '') == 'Pending' ? 'selected' : '' }}> Pending</option>
                                <option value="Progress" {{ old('status', $kpi->status ?? '') == 'Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ old('status', $kpi->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assign Users in Two Columns -->
        @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN', 'DEPARTMENT_HEAD']))
            <!-- Assign Users and Assign Departments Card -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Assign Users & Departments</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="users" class="form-label">Select Users:</label>
                                <div class="row">
                                    @foreach($users as $index => $user)
                                        @if ($index % 2 == 0 && $index > 0)
                                            </div><div class="row"> <!-- New Row -->
                                        @endif
                                        <div class="col-md-6">
                                            <input class="form-check-input" type="checkbox" name="user_id[]" value="{{ $user->id }}" id="user-{{ $user->id }}" {{ (in_array($user->id, old('user_id', [])) ? 'checked' :  in_array($user->id, $assignedUsers)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="user-{{ $user->id }}">{{ $user->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('user_id')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Assign Departments -->
                            @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                                <div class="col-md-6">
                                    <label for="department_id" class="form-label">Responsible Departments:</label>
                                    <select name="department_id[]" class="form-control @error('department_id') is-invalid @enderror" id="department_id" multiple required>
                                        @php
                                            $selectedDepartments = old('department_id', isset($task) && $task->departments()->count() !== 0 ? $task->departments->pluck('id')->toArray() : []);
                                        @endphp
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ in_array($department->id, $selectedDepartments) ? 'selected' : '' }}>{{ $department->department_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>Target & Fortnight Selection</strong>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="row">

                        <div class="col card mt-3">
                            <div class="card-header">
                                <strong>Target Selection</strong>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12 mb-3">
                                    <label for="target_id" class="form-label"><strong>Target:</strong></label>
                                    <select name="target_id" class="form-control @error('target_id') is-invalid @enderror" id="target_id" required>
                                        <option value="">Select Target</option>
                                        @foreach($targets as $target)
                                            <option value="{{ $target->id }}" {{ old('target_id', $task->target_id ?? '') == $target->id ? 'selected' : '' }}>
                                                {{ $target->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('target_id')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col card mt-3">
                            <div class="card-header">
                                <strong>Fortnight Task</strong>
                            </div>
                            <div class="card-body">
                                <!-- Fortnight Task Selection -->
                                <div class="col-md-12 mb-3">
                                    <label for="fortnight" class="form-label">Is this a Fortnight Task? if so, please select the fornights the task belongs to.</label>
                                    <select name="fortnight_id[]" class="form-control @error('fortnight_id') is-invalid @enderror" id="fortnight" multiple>
                                        @php
                                            $taskFortnights = $task ? $task->fortnights()->pluck('fortnights.id')->toArray() : [];
                                        @endphp
                                        <option value=""> Select Fortnights</option>
                                        @foreach($fortnights as $fortnight)
                                            <option value="{{ $fortnight->id }}" {{ (in_array($fortnight->id, old('fortnight_id', [])) ? 'selected' : in_array($fortnight->id, $taskFortnights)) ? 'selected' : '' }}> From: {{ \Carbon\Carbon::parse($fortnight->start_date)->format('M - d - Y') }} <span  class="text-info"> - To - </span> {{ \Carbon\Carbon::parse($fortnight->end_date)->format('M - d - Y') }} </option>
                                        @endforeach
                                    </select>
                                    @error('fortnight')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Card -->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <strong>Additional Information</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Budget and Responsibilities -->
                        <div class="col-md-6 mb-3">
                            <label for="budget" class="form-label">Budget:</label>
                            <input type="text" name="budget" class="form-control @error('budget') is-invalid @enderror" id="budget" value="{{ old('budget', $task->budget ?? '') }}" placeholder="Budget">
                            @error('budget')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Barriers and Communication Plan -->
                        <div class="col-md-6 mb-3">
                            <label for="barriers" class="form-label">Barriers:</label>
                            <input type="text" name="barriers" class="form-control @error('barriers') is-invalid @enderror" id="barriers" value="{{ old('barriers', $task->barriers ?? '') }}" placeholder="Barriers">
                            @error('barriers')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Starting and Due Date -->
                        <div class="col-md-6 mb-3">
                            <label for="starting_date" class="form-label">Starting Date:</label>
                            <input type="date" name="starting_date" class="form-control @error('starting_date') is-invalid @enderror" id="starting_date" value="{{ old('starting_date', $task->starting_date ?? '') }}">
                            @error('starting_date')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Due (End) Date:</label>
                            <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" value="{{ old('due_date', $task->due_date ?? '') }}">
                            @error('due_date')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="comunication" class="form-label">Communication Plan:</label>
                            <input type="text" name="comunication" class="form-control @error('comunication') is-invalid @enderror" id="comunication" value="{{ old('comunication', $task->comunication ?? '') }}" placeholder="Communication">
                            @error('comunication')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
        </div>
    </div>
</form>
