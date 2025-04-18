<form action="{{ isset($day) ? route('days.update', $day->id) : route('days.store') }}" method="POST">
    @csrf
    @if(isset($day))
        @method('PUT')
    @endif

    <div class="col-6 mb-3">
        <label for="fortnight_id" class="form-label"><strong>Select Fortnight:</strong></label>
        <select name="fortnight_id" id="fortnight_id" class="form-control @error('fortnight_id') is-invalid @enderror" required>
            <option value="">Choose Fortnight</option>
            @foreach($fortnights as $fortnight)
                <option value="{{ $fortnight->id }}" {{ isset($day) && $day->fortnight_id == $fortnight->id ? 'selected' : '' }}>
                    <strong>{{ $fortnight->quarter->quarter }} ({{ $fortnight->quarter->year->year }}): </strong>
                    {{ \Carbon\Carbon::parse($fortnight->start_date)->format('M - d - Y') }} to {{ \Carbon\Carbon::parse($fortnight->end_date)->format('M - d - Y') }}
                </option>
            @endforeach
        </select>
        @error('fortnight_id')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-6 mb-3">
        <label for="date" class="form-label"><strong>Date:</strong></label>
        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date"
               value="{{ old('date', isset($day) ? $day->date : '') }}" required>
        @error('date')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">
        <i class="fa-solid fa-floppy-disk"></i> {{ isset($day) ? 'Update' : 'Submit' }}
    </button>
</form>
