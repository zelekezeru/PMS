<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="pilar_name" class="form-label"><strong>Organizational Pilar:</strong></label>
            <input type="text" name="pilar_name" class="form-control @error('pilar_name') is-invalid @enderror" id="pilar_name" value="{{ old('pilar_name', $strategy->pilar_name ?? '') }}" placeholder="Type Pillar" required>
            @error('pilar_name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="name" class="form-label"><strong>Strategy:</strong></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $strategy->name ?? '') }}" placeholder="Type Pillar Strategy" required>
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label for="description" class="form-label"><strong>Description:</strong></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3" placeholder="Strategy Description" required>{{ old('description', $strategy->description ?? '') }}</textarea>
            @error('description')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
</form>
