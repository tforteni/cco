<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Braider;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;

class AppointmentController extends Controller
{
    /**
     * Display the braider's calendar and availability.
     */
    public function showBraiderCalendar($braiderId)
    {
        // Fetch braider's availability
        $availabilities = Availability::where('braider_id', $braiderId)
            ->where('booked', false)
            ->get();

        $braider = Braider::find($braiderId);

        if (!$braider) {
            abort(404, 'Braider not found');
        }

        // Convert to FullCalendar format
        $availabilitiesJson = $availabilities->map(function ($availability) {
            return [
                'id' => $availability->id,
                'title' => 'Available',
                'start' => $availability->start_time,
                'end' => $availability->end_time,
                'backgroundColor' => '#28a745',
                'borderColor' => '#28a745',
            ];
        });

        // Pass to the view
        return view('calendar', [
            'availabilities' => $availabilitiesJson->toJson(),
            'braider' => $braider
        ]);
    }

    /**
     * Store a new appointment.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'braider_id' => 'required|exists:braiders,id',
            'start_time' => 'required|date',
            'finish_time' => 'nullable|date|after:start_time',
        ]);

        // Create the appointment
        $appointment = Appointment::create([
            'user_id' => $validated['user_id'],
            'braider_id' => $validated['braider_id'],
            'start_time' => $validated['start_time'],
            'finish_time' => $validated['finish_time'],
        ]);

        // Mark availability as booked
        Availability::where('braider_id', $validated['braider_id'])
            ->where('start_time', $validated['start_time'])
            ->update(['booked' => true]);

        // Send email notifications
        $userEmail = $appointment->user->email; // Assuming `user` relationship exists
        $braiderEmail = $appointment->braider->user->email; // Assuming `braider` has a `user` relationship

        Mail::to($userEmail)->send(new AppointmentConfirmation($appointment));
        Mail::to($braiderEmail)->send(new AppointmentConfirmation($appointment));

        // Return response
        return response()->json([
            'event_id' => $appointment->id,
            'user_name' => $appointment->user->name,
            'braider_name' => $appointment->braider->user->name,
            'start_time' => $appointment->start_time,
            'finish_time' => $appointment->finish_time,
        ]);
    }
}
