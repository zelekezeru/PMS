<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="col-md-6 mb-3">
        <label for="deliverable_name" class="form-label"><strong>deliverable Name:</strong></label>
        <input type="text" name="deliverable_name" class="form-control @error('deliverable_name') is-invalid @enderror" id="deliverable_name" value="{{ old('deliverable_name', $deliverable->deliverable_name ?? '') }}" placeholder="deliverable name" required>
        @error('deliverable_name')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="description" class="form-label"><strong>Description:</strong></label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5" placeholder="Description">{{ old('description', $deliverable->description ?? '') }}</textarea>
        @error('description')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="deliverable_head" class="form-label"><strong>deliverable Head:</strong></label>
        <select name="deliverable_head" class="form-control @error('deliverable_head') is-invalid @enderror" id="deliverable_head">
            <!-- Assuming you have a list of users -->
            <option value="" {{ old('deliverable_head') == '' ? 'selected' : '' }}>Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('deliverable_head', $deliverable->deliverable_head ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
        @error('deliverable_head')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
</form>
