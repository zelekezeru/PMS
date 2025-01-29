<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="col-md-6 mb-3">
        <label for="department_name" class="form-label"><strong>Department Name:</strong></label>
        <input type="text" name="department_name" class="form-control @error('department_name') is-invalid @enderror" id="department_name" value="{{ old('department_name', $department->department_name ?? '') }}" placeholder="Department name" required>
        @error('department_name')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="description" class="form-label"><strong>Description:</strong></label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5" placeholder="Description">{{ old('description', $department->description ?? '') }}</textarea>
        @error('description')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="department_head" class="form-label"><strong>Department Head:</strong></label>
        <select name="department_head" class="form-control @error('department_head') is-invalid @enderror" id="department_head" required>
            <!-- Assuming you have a list of users -->
            <option value="" {{ old('department_head') == '' ? 'selected' : '' }}>Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('department_head', $department->department_head ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
        @error('department_head')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
</form>
