<?php

namespace App\Http\Controllers;

use App\Models\Braider;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BraiderController extends Controller
{
    /**
     * Helper to store uploaded file and copy it to the live public_html folder (Hostinger).
     */
    private function storeAndCopyToPublic($file, $folder, $oldPath = null)
    {
        // Delete old image from Laravel storage
        if ($oldPath) {
            $fullStoragePath = storage_path('app/public/' . $oldPath);
    
            if (file_exists($fullStoragePath)) {
                unlink($fullStoragePath);
            }
    
            // Delete from public HTML only in production
            if (app()->environment('production')) {
                $fullPublicPath = '/home/u598065493/domains/coilycurlyoffice.com/public_html/storage/' . $oldPath;
                if (file_exists($fullPublicPath)) {
                    unlink($fullPublicPath);
                }
            }
        }
    
        // Store new file in Laravel's storage
        $path = $file->store($folder, 'public');
        \Log::info('STORED PATH: ' . $path);
    
        // If production, copy it to public_html for live access
        if (app()->environment('production')) {
            $targetPath = '/home/u598065493/domains/coilycurlyoffice.com/public_html/storage/' . $path;
            $targetDir = dirname($targetPath);
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
    
            copy(
                storage_path('app/public/' . $path),
                $targetPath
            );
        }
    
        return $path;
    }
    

    
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
            $braider->headshot = $this->storeAndCopyToPublic($request->file('headshot'), 'headshots', $braider->headshot);
        } else {
            // Update the specified field
            $braider->{$field} = $request->input($field);
        }

        $braider->save();

        return redirect()->route('profile.role')->with('status', ucfirst($field) . ' updated successfully!');
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
            $headshot = $this->storeAndCopyToPublic($request->file('headshot'), 'headshots');
            $work1 = $this->storeAndCopyToPublic($request->file('work_image1'), 'work_images');
            $work2 = $this->storeAndCopyToPublic($request->file('work_image2'), 'work_images');
            $work3 = $this->storeAndCopyToPublic($request->file('work_image3'), 'work_images');

            $braider = Braider::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'bio' => $request->bio,
                    'headshot' => $headshot,
                    'work_image1' => $work1,
                    'work_image2' => $work2,
                    'work_image3' => $work3,
                    'min_price' => $request->min_price,
                    'max_price' => $request->max_price,
                ]
            );

            // Attach selected specialties to the braider
            $braider->specialties()->sync($request->specialties);

            return redirect()->route('profile.role')->with('message', 'Braider profile completed successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error creating braider profile: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'braider') {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'bio' => 'nullable|string|max:500',
            'headshot' => 'nullable|image|max:2048',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|gte:min_price',
            'specialties' => 'nullable|array',
            'specialties.*' => 'exists:specialties,id',
        ]);

        $braider = Braider::firstOrNew(['user_id' => $user->id]);

        if ($request->filled('bio')) {
            $braider->bio = $request->bio;
        }

        if ($request->filled('min_price')) {
            $braider->min_price = $request->min_price;
        }

        if ($request->filled('max_price')) {
            $braider->max_price = $request->max_price;
        }

        if ($request->hasFile('headshot')) {
            $braider->headshot = $this->storeAndCopyToPublic($request->file('headshot'), 'headshots', $braider->headshot);
        }

        $braider->save();

        if ($request->has('specialties')) {
            $braider->specialties()->sync($request->specialties);
        }

        return redirect()->route('profile.index')->with('message', 'Braider profile updated successfully!');
    }

    /**
     * Show a specific braider's profile and reviews.
     */
    public function show($id)
    {
        $braider = Braider::with(['user.reviewsReceived.user'])->findOrFail($id);

        // You can also load availability here if needed
        $availabilities = []; // Placeholder for availability data

        $calendarVariation = session('abTests.fullcalendar_view_test', 'timeGridWeek');

        return view('braider', compact('braider', 'availabilities', 'calendarVariation'));
    }
}
