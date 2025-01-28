<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label"><strong>Name:</strong></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $task->name ?? '') }}" placeholder="Name" required>
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="description" class="form-label"><strong>Description:</strong></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3" placeholder="Description">{{ old('description', $task->description ?? '') }}</textarea>
            @error('description')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="budget" class="form-label"><strong>Budget:</strong></label>
            <input type="text" name="budget" class="form-control @error('budget') is-invalid @enderror" id="budget" value="{{ old('budget', $task->budget ?? '') }}" placeholder="Budget">
            @error('budget')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="responsibilities" class="form-label"><strong>Responsibilities:</strong></label>
            <input type="text" name="responsibilities" class="form-control @error('responsibilities') is-invalid @enderror" id="responsibilities" value="{{ old('responsibilities', $task->responsibilities ?? '') }}" placeholder="Responsibilities" required>
            @error('responsibilities')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="barriers" class="form-label"><strong>Barriers:</strong></label>
            <input type="text" name="barriers" class="form-control @error('barriers') is-invalid @enderror" id="barriers" value="{{ old('barriers', $task->barriers ?? '') }}" placeholder="Barriers">
            @error('barriers')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="comunication" class="form-label"><strong>Communication:</strong></label>
            <input type="text" name="comunication" class="form-control @error('comunication') is-invalid @enderror" id="comunication" value="{{ old('comunication', $task->comunication ?? '') }}" placeholder="Communication">
            @error('comunication')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="target_id" class="form-label"><strong>Target:</strong></label>
            <select name="target_id" class="form-control @error('target_id') is-invalid @enderror" id="target_id" required>
                @foreach($targets as $target)
                    <option value="{{ $target->id }}" {{ old('target_id', $task->target_id ?? '') == $target->id ? 'selected' : '' }}>{{ $target->name }}</option>
                @endforeach
            </select>
            @error('target_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="parent_task_id" class="form-label"><strong>Parent Task:</strong></label>
            <select name="parent_task_id" class="form-control @error('parent_task_id') is-invalid @enderror" id="parent_task_id">
                <!-- Assuming you have a list of parent tasks -->
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
            <label for="starting_date" class="form-label"><strong>Starting Date:</strong></label>
            <input type="date" name="starting_date" class="form-control @error('starting_date') is-invalid @enderror" id="starting_date" value="{{ old('starting_date', $task->starting_date ?? '') }}">
            @error('starting_date')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="due_date" class="form-label"><strong>Due Date:</strong></label>
            <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" value="{{ old('due_date', $task->due_date ?? '') }}">
            @error('due_date')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>


    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
</form>
