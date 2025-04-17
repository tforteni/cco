<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Braider;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
use App\Mail\AppointmentCancelled;
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

    public function store(Request $request)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user || $user->role !== 'braider') {
            abort(403, 'Only braiders can manage availability.');
        }

        // Fetch the braider profile
        $braider = Braider::where('user_id', $user->id)->first();
        if (!$braider) {
            abort(404, 'Braider profile not found.');
        }

        // Validate the request
        $request->validate([
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'availability_type' => 'required|string',
            'recurrence' => 'nullable|string', // e.g., daily or weekly
            'location' => 'nullable|string|max:255',
        ]);

        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        $availabilityType = $request->availability_type;
        $recurrence = $request->recurrence ?? 'none'; // default to 'none'
        $location = $request->location;

        // Generate a unique series ID for recurring group
        $seriesId = ($availabilityType === 'recurring') ? \Str::uuid()->toString() : null;

        $availabilities = [];

        // Determine how many times to repeat
        $iterations = match($recurrence) {
            'daily' => 5,
            'weekly' => 4,
            default => 1
        };

        for ($i = 0; $i < $iterations; $i++) {
            $currentStart = $start->copy()->addDays($i * ($recurrence === 'weekly' ? 7 : 1));
            $currentEnd = $end->copy()->addDays($i * ($recurrence === 'weekly' ? 7 : 1));

            // Check for overlaps
            $overlap = Availability::where('braider_id', $braider->id)
                ->where(function ($query) use ($currentStart, $currentEnd) {
                    $query->whereBetween('start_time', [$currentStart, $currentEnd])
                        ->orWhereBetween('end_time', [$currentStart, $currentEnd])
                        ->orWhereRaw('? BETWEEN start_time AND end_time', [$currentStart])
                        ->orWhereRaw('? BETWEEN start_time AND end_time', [$currentEnd]);
                })
                ->exists();

            if ($overlap) {
                // Skip this one, don't break the whole loop
                continue;
            }

            $availabilities[] = Availability::create([
                'braider_id' => $braider->id,
                'start_time' => $currentStart,
                'end_time' => $currentEnd,
                'availability_type' => $availabilityType,
                'recurrence' => $recurrence,
                'series_id' => $seriesId,
                'location' => $location,
            ]);
        }

        // Return the first created availability for success response
        if (count($availabilities) > 0) {
            $first = $availabilities[0];
            return response()->json([
                'id' => $first->id,
                'start_time' => $first->start_time,
                'end_time' => $first->end_time,
                'location' => $first->location,
            ]);
        } else {
            return response()->json([
                'error' => 'No availability was saved due to overlap.',
            ], 422);
        }
    }

    // Delete availability
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'braider') {
            abort(403, 'Only braiders can manage availability.');
        }

        $braider = Braider::where('user_id', $user->id)->first();
        if (!$braider) {
            abort(404, 'Braider profile not found.');
        }

        $availability = Availability::find($id);

        if ($availability && $availability->braider_id === $braider->id) {
            // Check for and delete any linked appointment
            if ($availability->booked) {
                $appointment = Appointment::where('availability_id', $availability->id)->first();

                if ($appointment) {
                    // Send cancellation email to client
                    Mail::to($appointment->braider->user->email)->send(new AppointmentCancelled($appointment));

                    // Delete the appointment
                    $appointment->delete();
                }
            }

            $availability->delete();


            return response()->json(['success' => true, 'message' => 'Availability and any linked appointment deleted.']);
        }

        return response()->json(['success' => false, 'message' => 'Unauthorized or not found.'], 403);
    }
}
