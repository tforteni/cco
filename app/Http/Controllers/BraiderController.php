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

        // Allow the user to access the complete-profile page
        return view('braider.complete-profile');
    }

    public function update(Request $request, $field)
    {
        // Validate the field being updated
        $validationRules = [
            'bio' => 'required|string|max:500',
            'headshot' => 'required|image|max:2048',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gte:min_price',
        ];

        if (!array_key_exists($field, $validationRules)) {
            return redirect()->back()->withErrors(['error' => 'Invalid field.']);
        }

        $request->validate([
            $field => $validationRules[$field],
        ]);

        // Retrieve the authenticated user's braider profile
        $braider = Braider::where('user_id', auth()->id())->firstOrFail();

        if ($field === 'headshot' && $request->hasFile('headshot')) {
            // Handle file upload for the headshot
            $path = $request->file('headshot')->store('headshots', 'public');
            $braider->headshot = $path;
        } else {
            // Update the specified field
            $braider->{$field} = $request->input($field);
        }

        $braider->save();

        return redirect()->route('profile.edit')->with('status', ucfirst($field) . ' updated successfully!');
    }

    /**
     * Store the completed braider profile.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'braider') {
            abort(403, 'Only braiders can complete their profile.');
        }

        // Validate the incoming request
        $request->validate([
            'bio' => 'required|string|max:1000',
            'headshot' => 'required|image|max:2048',
            'work_image1' => 'required|image|max:2048',
            'work_image2' => 'required|image|max:2048',
            'work_image3' => 'required|image|max:2048',
            'min_price' => 'required|numeric|min:1',
            'max_price' => 'required|numeric|gt:min_price',
            'specialties' => 'required|array', // Ensure specialties are an array
            'specialties.*' => 'exists:specialties,id', // Ensure each specialty ID exists
        ], [
            'bio.required' => 'Please provide a bio.',
            'headshot.required' => 'A headshot is required.',
            'headshot.image' => 'The headshot must be an image file.',
            'headshot.max' => 'The headshot must not exceed 2MB.',
            'work_image1.required' => 'Work Photo 1 is required.',
            'work_image1.image' => 'Work Photo 1 must be an image file.',
            'work_image1.max' => 'Work Photo 1 must not exceed 2MB.',
            'min_price.required' => 'Please specify a minimum price.',
            'max_price.gt' => 'The maximum price must be greater than the minimum price.',
        ]);

        try {
            // Create or update the braider profile
            $braider = Braider::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'bio' => $request->bio,
                    'headshot' => $request->file('headshot')->store('headshots', 'public'),
                    'work_image1' => $request->file('work_image1')->store('work_images', 'public'),
                    'work_image2' => $request->file('work_image2')->store('work_images', 'public'),
                    'work_image3' => $request->file('work_image3')->store('work_images', 'public'),
                    'min_price' => $request->min_price,
                    'max_price' => $request->max_price,
                ]
            );

            // Attach selected specialties to the braider
            $braider->specialties()->sync($request->specialties);


            return redirect()->route('profile.edit')->with('message', 'Braider profile completed successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error creating braider profile: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }


}

