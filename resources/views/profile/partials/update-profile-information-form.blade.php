<section>
    <header>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus />
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required />
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning mt-4">
                    <p class="mb-0">{{ __('Your email address is unverified.') }}</p>
                    <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </div>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary w-100">{{ __('Save') }}</button>
        </div>
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
