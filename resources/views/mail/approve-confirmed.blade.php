@component('mail::message')

# Approval Confirmed

Your account has been approved. You can log in using the link below:

@component('mail::button', ['url' => $loginLink])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
