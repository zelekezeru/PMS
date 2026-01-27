<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="mb-3">
        <label for="year" class="form-label"><strong>Year:</strong></label>
        <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" id="year" value="{{ old('year', $year->year ?? '') }}" placeholder="Enter Year" required>
        <label for="active" class="form-check-label"><strong>Status</strong></label>
        <input type="checkbox" name="active" class="form-check-input mt-2" id="active" value="1" {{ old('active', isset($year) && $year->active ? 'checked' : '') }}>
        @error('year')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
</form>
