<form action="{{ isset($fortnight) ? route('fortnights.update', $fortnight->id) : route('fortnights.store') }}" method="POST">
    @csrf
    @if(isset($fortnight))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="quarter_id" class="form-label"><strong>Select Quarter:</strong></label>
        <select name="quarter_id" id="quarter_id" class="form-control @error('quarter_id') is-invalid @enderror" required>
            <option value="">Choose Quarter</option>
            @foreach($quarters as $quarter)
                <option value="{{ $quarter->id }}" {{ isset($fortnight) && $fortnight->quarter_id == $quarter->id ? 'selected' : '' }}>
                    {{ $quarter->quarter }} ({{ $quarter->year->year }})
                </option>
            @endforeach
        </select>
        @error('quarter_id')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="start_date" class="form-label"><strong>Start Date:</strong></label>
        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" 
               value="{{ old('start_date', isset($fortnight) ? $fortnight->start_date : '') }}" required>
        @error('start_date')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="end_date" class="form-label"><strong>End Date:</strong></label>
        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" 
               value="{{ old('end_date', isset($fortnight) ? $fortnight->end_date : '') }}" required>
        @error('end_date')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">
        <i class="fa-solid fa-floppy-disk"></i> {{ isset($fortnight) ? 'Update' : 'Submit' }}
    </button>
</form>
