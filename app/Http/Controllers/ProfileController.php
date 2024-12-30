<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Update user details
        $user = $request->user();
        $user->update($request->validated());

        // Check if the email was updated and reset verification if needed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Switch the user's role.
     */
    public function switchRole(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => 'required|string|in:member,braider,admin', // Validate the role
        ]);

        $user = $request->user();

        // Allow switching to 'admin' only if the current user is already an admin
        if ($request->input('role') === 'admin' && $user->role !== 'admin') {
            return redirect()->route('profile.edit')->withErrors(['role' => 'Unauthorized to switch to admin role.']);
        }

        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'role-switched');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
