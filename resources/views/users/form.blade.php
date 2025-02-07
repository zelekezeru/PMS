<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="col-md-6 mb-3">
        <label for="name" class="form-label"><strong>Name:</strong></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ old('name', $user->name ?? '') }}" placeholder="Name" required>
        @error('name')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="email" class="form-label"><strong>Email:</strong></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
            value="{{ old('email', $user->email ?? '') }}" placeholder="Email" required>
        @error('email')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="phone_number" class="form-label"><strong>Phone Number:</strong></label>
        <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
            value="{{ old('phone_number', $user->phone_number ?? '') }}" placeholder="Phone Number" required>
        @error('phone_number')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="profile_image" class="form-label"><strong>Profile Image:</strong></label>
        <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" accept="image/*">
        @error('profile_image')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
        @if(isset($user) && $user->profile_image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="img-thumbnail" width="150">
            </div>
        @endif
    </div>
    <div>
        <label for="is_active" class="form-label"><strong>Active :</strong></label>
        <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', isset($user) ? $user->is_active : false) ? 'checked' : '' }}>
    </div>
    <div class="col-md-6 mb-3">
        <label for="is_approved" class="form-label"><strong>Approved :</strong></label>
        <input type="checkbox" name="is_approved" value="1" id="is_approved" {{ old('is_approved', isset($user) ? $user->is_approved : false) ? 'checked' : '' }}>
    </div>

    @if(!isset($isCreate) && !$user->hasRole('SUPER_ADMIN'))
    <div class="col-md-6 mb-3">
        <label for="role_id" class="form-label"><strong>Role:</strong></label>
        <select name="role_id" class="form-control @error('role_id') is-invalid @enderror" id="role" required>
            <option value="" {{ old('role_id') == '' ? 'selected' : '' }}>Select Role</option>
            @foreach($roles as $role)
                @if ($role->name !== 'SUPER_ADMIN')
                    <option value="{{ $role->id }}" {{ old('role_id', isset($user) && $user->roles->contains($role->id) ? $role->id : '') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endif
            @endforeach
        </select>
        @error('role_id')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
    @endif


    <!-- Assign Departments -->
    <div class="col-md-6 mb-3">
        <label for="department_id" class="form-label">Department:</label>
        <select name="department_id" class="form-control @error('department_id') is-invalid @enderror" id="department_id" required>
            <option value="" {{ old('department_id') == '' ? 'selected' : '' }}>Select Department</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}"
                    {{ old('department_id', $user->department_id ?? '') == $department->id ? 'selected' : '' }}>
                    {{ $department->department_name }}
                </option>
            @endforeach
        </select>
        @error('department_id')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">
        <i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}
    </button>
</form>
