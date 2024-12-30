<?php

namespace App\Http\Controllers;

use App\Models\Braider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BraiderController extends Controller
{
    /**
     * Show the form for completing a braider profile.
     */
    public function create()
    {
        // Ensure user is authenticated and has the 'braider' role
        $user = Auth::user();
        if (!$user || $user->role !== 'braider') {
            abort(403, 'Only braiders can complete their profile.');
        }

        // Check if the user already has a braider profile
        $braider = Braider::where('user_id', $user->id)->first();
        if ($braider) {
            return redirect()->route('profile.edit')->with('message', 'Profile already completed.');
        }

        return view('braider.complete-profile');
    }

    /**
     * Store the completed braider profile.
     */
    public function store(Request $request)
    {
        // Ensure user is authenticated and has the 'braider' role
        $user = Auth::user();
        if (!$user || $user->role !== 'braider') {
            abort(403, 'Only braiders can complete their profile.');
        }

        // Validate the request
        $request->validate([
            'bio' => 'required|string|max:1000',
            'headshot' => 'required|image|max:2048',
            'work_image1' => 'required|image|max:2048',
            'work_image2' => 'required|image|max:2048',
            'work_image3' => 'required|image|max:2048',
            'min_price' => 'required|numeric|min:1',
            'max_price' => 'required|numeric|gt:min_price',
        ]);

        // Store the braider profile
        $braider = Braider::create([
            'user_id' => $user->id,
            'bio' => $request->bio,
            'headshot' => $request->file('headshot')->store('headshots', 'public'),
            'work_image1' => $request->file('work_image1')->store('work_images', 'public'),
            'work_image2' => $request->file('work_image2')->store('work_images', 'public'),
            'work_image3' => $request->file('work_image3')->store('work_images', 'public'),
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
        ]);

        return redirect()->route('profile.edit')->with('message', 'Braider profile completed successfully.');
    }
}
