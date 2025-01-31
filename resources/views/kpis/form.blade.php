@if($task != null)

        <div class="col-md-12 mb-3">
            <label for="task_id" class="form-label"><strong>Task Title: {{ $task->name }}</strong></label>
            <input type="text" name="task_id" value="{{ $task->name }}" readonly hidden>
        </div>

    @elseif($target != null)

        <div class="col-md-12 mb-3">
            <label for="target_id" class="form-label"><strong>Target: {{ $target->name }}</strong></label>
            <input type="text" name="target_id" value="{{ $target->name }}" readonly hidden>
        </div>
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
        <label for="unit" class="form-label"><strong>unit:</strong></label>
        <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" id="unit" value="{{ old('unit', $kpi->unit ?? '') }}" placeholder="Unit">
        @error('unit')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

</div>
