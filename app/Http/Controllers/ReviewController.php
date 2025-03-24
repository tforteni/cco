<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Appointment $appointment)
    {
        // Make sure the logged-in user owns the appointment
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if a review already exists
        if ($appointment->review) {
            return redirect()->back()->with('message', 'You already reviewed this appointment.');
        }

        return view('reviews.create', compact('appointment'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }
        if ($appointment->finish_time > now()) {
            abort(403, 'You cannot review a future appointment.');
        }
        if ($appointment->review) {
            return redirect()->back()->with('message', 'You already reviewed this appointment.');
        }        

        $request->validate([
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'nullable|string|max:1000',
            'media1' => 'nullable|image|max:2048',
            'media2' => 'nullable|image|max:2048',
            'media3' => 'nullable|image|max:2048',
        ]);

        $paths = [];

        foreach (['media1', 'media2', 'media3'] as $media) {
            if ($request->hasFile($media)) {
                $paths[$media] = $request->file($media)->store('review_images', 'public');
            } else {
                $paths[$media] = null;
            }
        }

        Review::create([
            'appointment_id' => $appointment->id,
            'user_id' => Auth::id(),
            'braider_id' => $appointment->braider->user_id, // Get user_id from braider model
            'rating' => $request->rating,
            'comment' => $request->comment,
            'media1' => $paths['media1'],
            'media2' => $paths['media2'],
            'media3' => $paths['media3'],
        ]);

        return redirect()->route('dashboard')->with('message', 'Thanks for your review!');
    }
}
