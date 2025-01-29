<form action="{{ isset($quarter) ? route('quarters.update', $quarter->id) : route('quarters.store') }}" method="POST">
    @csrf
    @if(isset($quarter))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="year_id" class="form-label"><strong>Select Year:</strong></label>
        <select name="year_id" id="year_id" class="form-control @error('year_id') is-invalid @enderror" required>
            <option value="">Choose Year</option>
            @foreach($years as $year)
                <option value="{{ $year->id }}" {{ isset($quarter) && $quarter->year_id == $year->id ? 'selected' : '' }}>
                    {{ $year->year }}
                </option>
            @endforeach
        </select>
        @error('year_id')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="quarter" class="form-label"><strong>Select Quarter:</strong></label>
        <select name="quarter" id="quarter" class="form-control @error('quarter') is-invalid @enderror" required>
            <option value="Q1" {{ isset($quarter) && $quarter->quarter == 'Q1' ? 'selected' : '' }}>Q1</option>
            <option value="Q2" {{ isset($quarter) && $quarter->quarter == 'Q2' ? 'selected' : '' }}>Q2</option>
            <option value="Q3" {{ isset($quarter) && $quarter->quarter == 'Q3' ? 'selected' : '' }}>Q3</option>
            <option value="Q4" {{ isset($quarter) && $quarter->quarter == 'Q4' ? 'selected' : '' }}>Q4</option>
        </select>
        @error('quarter')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">
        <i class="fa-solid fa-floppy-disk"></i> {{ isset($quarter) ? 'Update' : 'Submit' }}
    </button>
</form>
