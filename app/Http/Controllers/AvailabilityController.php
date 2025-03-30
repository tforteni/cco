<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Braider;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
use Carbon\Carbon;

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

        // Fetch braider-specific availabilities (may be empty)
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

        // Pass availabilities to the view (may be an empty array)
        return view('braider-availability', ['availabilities' => $availabilitiesJson]);
    }

    // Store new availability
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
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'availability_type' => 'required|string',
            'location' => 'nullable|string|max:255',
        ]);

        // Convert datetime strings to MySQL format
        $start = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        $end = Carbon::parse($request->end_time)->format('Y-m-d H:i:s');

        // Check for overlapping availability
        $overlap = Availability::where('braider_id', $braider->id)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhereRaw('? BETWEEN start_time AND end_time', [$start])
                    ->orWhereRaw('? BETWEEN start_time AND end_time', [$end]);
            })
            ->exists();

        if ($overlap) {
            return response()->json([
                'error' => 'You cannot schedule overlapping availability blocks.',
            ], 422);
        }

        // Save the availability
        $availability = Availability::create([
            'braider_id' => $braider->id,
            'start_time' => $start,
            'end_time' => $end,
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
