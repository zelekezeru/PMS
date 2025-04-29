<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method)
        @method($method)
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Deliverable Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $deliverable->name) }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="deadline" class="form-label">Deadline</label>
        <input type="date" value="{{ old('deadline', $deliverable->deadline) }}" min="{{ $fortnight->start_date }}" max="{{ $fortnight->end_date }}" class="form-control @error('deadline') is-invalid @enderror" name="deadline">
        @error('deadline')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_completed" name="is_completed" value="1" {{ old('is_completed', $deliverable->is_completed) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_completed">Achieved</label>
    </div>

    {{-- Created By user name --}}
        <input type="hidden" name="commented_by" value="{{ Auth::user()->name }}">

    {{-- Comment on the Deliverable --}}
    <div class="mb-3">
        <label for="comment" class="form-label">Comment</label>
        <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" rows="3">{{ old('comment', $deliverable->comment) }}</textarea>
        @error('comment')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">
        <i class="fa-solid fa-floppy-disk"></i> Save
    </button>
</form>
