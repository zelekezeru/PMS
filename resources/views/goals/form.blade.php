<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label"><strong>Name:</strong></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $goal->name ?? '') }}" placeholder="Name" required>
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="description" class="form-label"><strong>Description:</strong></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3" placeholder="Description">{{ old('description', $goal->description ?? '') }}</textarea>
            @error('description')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="strategy_id" class="form-label"><strong>Strategy:</strong></label>
            <select name="strategy_id" class="form-control @error('strategy_id') is-invalid @enderror" id="strategy_id" required>
                <!-- Assuming you have a list of strategies -->
                @foreach($strategies as $strategy)
                    <option value="{{ $strategy->id }}" {{ old('strategy_id', $goal->strategy_id ?? '') == $strategy->id ? 'selected' : '' }}>{{ $strategy->name }}</option>
                @endforeach
            </select>
            @error('strategy_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
</form>
