<section>
    <header>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
            
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
            {{ __("Update your account's profile Image") }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.uploadProfileImage') }}" enctype="multipart/form-data">
        @csrf
        <!-- Profile Image Field -->
    <div class="form-group">
        <label for="profile_image">{{ __('Profile Picture') }}</label>
        <input id="profile_image" name="profile_image" type="file" class="form-control @error('profile_image') is-invalid @enderror" accept="image/*" onchange="previewImage(event)" />
        @error('profile_image') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <!-- Display current profile image -->
        @if($user->profile_image)
            <div class="mt-3">
                <p class="text-sm text-gray-500">{{ __('Current Profile Picture:') }}</p>
                <img id="profilePreview" src="{{ asset('storage/' . $user->profile_image) }}" class="img-thumbnail" style="width: 35%; border-radius: 50%; margin: 0 auto;">
            </div>
            @else
                <div class="mt-3">
                    <p class="text-sm text-gray-500">{{ __('No profile picture uploaded.') }}</p>
                    <img id="profilePreview" src="" class="img-thumbnail d-none" style="width: 35%; border-radius: 50%; margin: 0 auto;">
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Upload Image</button>
    </form>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Check if the 'profile-updated' session is flashed
    @if (session('status') === 'profile-updated')
        // Show SweetAlert success message
        Swal.fire({
            title: '{{ __("Profile Updated!") }}',
            text: '{{ __("Your profile has been successfully updated.") }}',
            icon: 'success',
            confirmButtonText: '{{ __("Okay") }}',
        });
    @endif
</script>



