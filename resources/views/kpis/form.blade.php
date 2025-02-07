<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    @if($task != null)

        <div class="col-md-12 mb-3">
            <label for="task_id" class="form-label"><strong>Task Title: {{ $task->name }}</strong></label>
            <input type="text" name="task_id" value="{{ $task->id }}" readonly hidden>
            <input type="text" name="target_id" value="" readonly hidden>
        </div>

    @elseif($target != null)

        <div class="col-md-12 mb-3">
            <label for="target_id" class="form-label"><strong>Target: {{ $target->name }}</strong></label>
            <input type="text" name="target_id" value="{{ $target->id }}" readonly hidden>
            <input type="text" name="task_id" value="" readonly hidden>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label"><strong>Performance Indicator:</strong></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $kpi->name ?? '') }}" placeholder="Indicator" required>
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="unit" class="form-label"><strong>Measurement Unit:</strong></label>
            <select name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" required>
                <option value="">Choose Measurement Unit</option>
                <option value="%" {{ old('unit', $kpi->unit ?? '') == '%' ? 'selected' : '' }}>% (Percentage)</option>
                <option value="1-5" {{ old('unit', $kpi->unit ?? '') == '1-5' ? 'selected' : '' }}>1-5 (Rating)</option>
                <option value="Numerical" {{ old('unit', $kpi->unit ?? '') == 'Numerical' ? 'selected' : '' }}>Numerical</option>
            </select>
            @error('unit')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="value" class="form-label"><strong>Value:</strong></label>
            <input type="text" step="0.01" name="value" class="form-control @error('value') is-invalid @enderror" id="value" value="{{ old('value', $kpi->value ?? '') }}" placeholder="Value">
            @error('value')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="status" class="form-label"><strong>Status:</strong></label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="Pending" {{ old('status', $kpi->status ?? '') == 'Pending' ? 'selected' : '' }}> Pending</option>
                <option value="Progress" {{ old('status', $kpi->status ?? '') == 'Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Completed" {{ old('status', $kpi->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option>
                {{-- <option value="Approved'" {{ old('status', $kpi->status ?? '') == 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Confirmed'" {{ old('status', $kpi->status ?? '') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option> --}}
            </select>
            @error('status')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>


    </div>

    <div class="col-md-12">
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
    </div>
</div>
</form>

