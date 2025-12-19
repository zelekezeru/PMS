<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults()],
        ]);
        
        // check if current password matches
        if (!Hash::check($validated['current_password'], $request->user()->password)) {
            return back()->withErrors([
                'current_password' => __('The provided password does not match your current password.'),
            ]);
        }

        $validated['default_password'] = null;
        $validated['password_changed'] = true;

        $user = $request->user();

        $user->update([
            'password' => Hash::make($validated['password']),
            'default_password' => null,
            'password_changed' => true,
        ]);

        return redirect('/')->with('status', 'password-updated');
    }

    // reset password for user by admin
    public function resetPassword(Request $request, $userId): RedirectResponse
    {
        $request->validateWithBag('resetPassword', [
            'new_password' => ['required', Password::defaults()],
        ]);
        $user = User::findOrFail($userId);

        $defaultPassword = $request->input('new_password');
        
        $user->update([
            'password' => Hash::make($request->input('new_password')),
            'default_password' => $defaultPassword,
            'password_changed' => false,
        ]);

        return redirect()->route('users.show', $userId)->with('status', 'Password reset Successfully');
    }
}
