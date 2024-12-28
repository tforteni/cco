<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Braider;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;

class AvailabilityController extends Controller
{
    // Display availability for authenticated braider
    public function index()
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user || $user->role !== 'braider') {
            abort(403, 'Only braiders can access availability.');
        }

        // Fetch the braider profile associated with the authenticated user
        $braider = Braider::where('user_id', $user->id)->first();
        if (!$braider) {
            abort(404, 'Braider profile not found.');
        }

        // Fetch braider-specific availabilities
        $availabilities = Availability::where('braider_id', $braider->id)->get();

        // Convert to FullCalendar format
        $availabilitiesJson = $availabilities->map(function ($availability) {
            return [
                'id' => $availability->id,
                'title' => $availability->booked ? 'Booked' : 'Available',
                'start' => $availability->start_time,
                'end' => $availability->end_time,
                'backgroundColor' => $availability->booked ? '#dc3545' : '#28a745',
                'borderColor' => $availability->booked ? '#dc3545' : '#28a745',
                'location' => $availability->location,
            ];
        });

        return view('braider-availability', ['availabilities' => $availabilitiesJson]);
    }

    // Store availability
    public function store(Request $request)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user || $user->role !== 'braider') {
            abort(403, 'Only braiders can manage availability.');
        }

        // Fetch the braider profile associated with the authenticated user
        $braider = Braider::where('user_id', $user->id)->first();
        if (!$braider) {
            abort(404, 'Braider profile not found.');
        }

        // Validate the request
        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'availability_type' => 'required|string',
            'location' => 'nullable|string|max:255',
        ]);

        // Save the availability
        $availability = Availability::create([
            'braider_id' => $braider->id, // Use the correct braider_id
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'availability_type' => $request->availability_type,
            'location' => $request->location,
        ]);

        return response()->json([
            'id' => $availability->id,
            'start_time' => $availability->start_time,
            'end_time' => $availability->end_time,
            'location' => $availability->location,
        ]);
    }

    // Delete availability
    public function destroy($id)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user || $user->role !== 'braider') {
            abort(403, 'Only braiders can manage availability.');
        }

        // Fetch the braider profile associated with the authenticated user
        $braider = Braider::where('user_id', $user->id)->first();
        if (!$braider) {
            abort(404, 'Braider profile not found.');
        }

        // Fetch the availability to delete
        $availability = Availability::find($id);
        if ($availability && $availability->braider_id === $braider->id) {
            $availability->delete();
            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => false], 403);
    }
}
