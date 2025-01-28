<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label"><strong>Name:</strong></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $kpi->name ?? '') }}" placeholder="Name" required>
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="value" class="form-label"><strong>Value:</strong></label>
            <input type="number" step="0.01" name="value" class="form-control @error('value') is-invalid @enderror" id="value" value="{{ old('value', $kpi->value ?? '') }}" placeholder="Value">
            @error('value')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="unit" class="form-label"><strong>Unit:</strong></label>
            <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" id="unit" value="{{ old('unit', $kpi->unit ?? '') }}" placeholder="Unit">
            @error('unit')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="task_id" class="form-label"><strong>Task:</strong></label>
            <select name="task_id" class="form-control @error('task_id') is-invalid @enderror" id="task_id" required>
                <!-- Assuming you have a list of tasks -->
                @foreach($tasks as $task)
                    <option value="{{ $task->id }}" {{ old('task_id', $kpi->task_id ?? '') == $task->id ? 'selected' : '' }}>{{ $task->name }}</option>
                @endforeach
            </select>
            @error('task_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
</form>
