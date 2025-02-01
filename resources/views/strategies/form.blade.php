<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="pillar_name" class="form-label"><strong>Organizational Pilar:</strong></label>
            <input type="text" name="pillar_name" class="form-control @error('pillar_name') is-invalid @enderror" id="pillar_name" value="{{ old('pillar_name', $strategy->pillar_name ?? '') }}" placeholder="Type Pillar" required>
            @error('pillar_name')
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
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5" placeholder="Strategy Description" required>{{ old('description', $strategy->description ?? '') }}</textarea>
            @error('description')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
</form>
