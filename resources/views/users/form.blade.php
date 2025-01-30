<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="col-md-6 mb-3">
        <label for="name" class="form-label"><strong>Name:</strong></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $user->name ?? '') }}" placeholder="Name" required>
        @error('name')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="email" class="form-label"><strong>Email:</strong></label>
        <input type="text" email="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $user->email ?? '') }}" placeholder="Email" required>
        @error('email')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="is_active" class="form-label"><strong>Approved(if checked):</strong></label>
        <input type="checkbox" @if($user->is_active) checked @endif name="is_active" id="is_active">
        @error('email')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="is_approved" class="form-label"><strong>Approved(if checked):</strong></label>
        <input type="checkbox" @if($user->is_approved) checked @endif name="is_approved" id="is_approved">
        @error('email')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-6 mb-3">
        <label for="role_id" class="form-label"><strong>Role:</strong></label>
        <select name="role_id" class="form-control @error('role_id') is-invalid @enderror" id="role" required>
            <!-- Assuming you have a list of roles -->
            <option value="" {{ old('role') == '' ? 'selected' : '' }}>Select Role</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role', $role->name ?? '') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
            @endforeach
        </select>
        @error('role')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="department_id" class="form-label"><strong>Department Head:</strong></label>
        <select name="head" class="form-control @error('head') is-invalid @enderror" id="department_id" required>
            <!-- Assuming you have a list of department_ids -->
            <option value="" {{ old('department_id') == '' ? 'selected' : '' }}>Select Department_id</option>
            @foreach($departments as $department)
                <option value="{{ $department_id->id }}" {{ old('department_id', $department_id->name ?? '') == $department_id->name ? 'selected' : '' }}>{{ $department_id->name }}</option>
            @endforeach
        </select>
        @error('department_id')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
</form>
