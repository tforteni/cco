<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Braider;

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

        // Check if the email will change before updating
        $emailChanged = $request->input('email') !== $user->email;

        $user->update($request->validated());

        // Reset email verification if email changed
        if ($emailChanged) {
            $user->email_verified_at = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    public function switchRole(Request $request): RedirectResponse
    {
        $rules = [
            'role' => 'required|string|in:member,braider,admin', // Validate the role
        ];

        $newRole = $request->input('role');
        $user = $request->user();

        // Prevent switching back to "member" if the current role is "braider"
        if ($user->role === 'braider' && $newRole === 'member') {
            return redirect()->route('profile.edit')->withErrors(['role' => 'Once you become a Braider, you cannot switch back to Member.']);
        }

        // Additional validation rules for braider-specific fields
        if ($newRole === 'braider') {
            $rules = array_merge($rules, [
                'bio' => 'required|string|max:500',
                'headshot' => 'required|image|max:2048', // Headshot file validation
                'min_price' => 'required|numeric|min:0',
                'max_price' => 'required|numeric|gte:min_price',
                'specialties' => 'required|array',
                'specialties.*' => 'exists:specialties,id',
            ]);
        }

        $request->validate($rules);

        // Allow switching to 'admin' only if the current user is already an admin
        if ($newRole === 'admin' && $user->role !== 'admin') {
            return redirect()->route('profile.edit')->withErrors(['role' => 'Unauthorized to switch to admin role.']);
        }

        // Update the user's role
        $user->role = $newRole;
        $user->save();

        // Handle braider-specific data
        if ($newRole === 'braider') {
            // Check if the user already has a braider profile
            $braider = Braider::firstOrNew(['user_id' => $user->id]);

            // Update braider fields
            $braider->bio = $request->input('bio');
            $braider->min_price = $request->input('min_price');
            $braider->max_price = $request->input('max_price');

            // Handle headshot file upload
            if ($request->hasFile('headshot')) {
                $headshotPath = $request->file('headshot')->store('headshots', 'public'); // Store in the `storage/app/public/headshots` directory
                $braider->headshot = $headshotPath;
            }

            $braider->verified = $braider->verified ?? false; // Default verified to false if not already set
            $braider->save();
            $braider->specialties()->sync($request->input('specialties', [])); // Sync the braider's specialties
            
        }

        return redirect()->route('profile.edit')->with('message', 'Braider profile updated successfully.');
      

    }


    /**
     * Update specific fields of the braider profile.
     */
    public function updateBraiderField(Request $request): RedirectResponse
    {
        // Ensure the user is a braider
        $user = $request->user();
        if ($user->role !== 'braider') {
            return redirect()->route('profile.edit')->withErrors(['role' => 'Unauthorized to update braider fields.']);
        }

        // Fetch the user's braider profile
        $braider = Braider::where('user_id', $user->id)->firstOrFail();

        // Define validation rules for partial updates
        $rules = [
            'bio' => 'sometimes|string|max:500',
            'headshot' => 'sometimes|image|max:2048', // Optional headshot file
            'min_price' => 'sometimes|numeric|min:0',
            'max_price' => 'sometimes|numeric|gte:min_price',
        ];

        $validated = $request->validate($rules);

        // Update only the provided fields
        if ($request->has('bio')) {
            $braider->bio = $validated['bio'];
        }

        if ($request->has('min_price')) {
            $braider->min_price = $validated['min_price'];
        }

        if ($request->has('max_price')) {
            $braider->max_price = $validated['max_price'];
        }

        if ($request->hasFile('headshot')) {
            $headshotPath = $request->file('headshot')->store('headshots', 'public');
            $braider->headshot = $headshotPath;
        }

        $braider->save();

        return redirect()->route('profile.edit')->with('status', 'braider-updated');
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
