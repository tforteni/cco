<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Braider;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
use App\Mail\BraiderAppointmentConfirmation;
use Illuminate\Support\Facades\Log;
use App\Models\ABTestLog;


class AppointmentController extends Controller
{
    /**
     * Show the braider's profile page with calendar embedded.
     */
    public function showBraiderProfile($braiderId)
    {
        // Fetch the braider's details
        $braider = Braider::findOrFail($braiderId);

        // Fetch the braider's availability
        $availabilities = Availability::where('braider_id', $braiderId)
            ->where('booked', false)
            ->get();

        // Convert availability to FullCalendar format
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

        // Log Page Visit for A/B Testing
        ABTestLog::create([
            'user_id' => auth()->id(),
            'test_name' => 'fullcalendar_view_test',
            'variation' => session('abTests.fullcalendar_view_test', 'timeGridWeek'),
            'action' => 'page_visit'
        ]);


        // Pass data to the view
        return view('braider', [
            'braider' => $braider,
            'availabilities' => $availabilitiesJson->toJson(), // Pass JSON to the view
            'calendarVariation' => session('abTests.fullcalendar_view_test', 'timeGridWeek'), // Use the assigned variation
        ]);
    }


    /**
     * Store a new appointment.
     */
    public function store(Request $request)
    {
        // Log the request for debugging
        \Log::info($request->all());

        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'braider_id' => 'required|exists:braiders,id',
            'start_time' => 'required|date',
            'finish_time' => 'nullable|date|after:start_time',
        ]);

        // Check if the requested time slot is available
        $availability = Availability::where('braider_id', $validated['braider_id'])
            ->where('start_time', $validated['start_time'])
            ->where('booked', false)
            ->first();

        if (!$availability) {
            return response()->json(['message' => 'The selected time slot is no longer available.'], 400);
        }

        // Create the appointment
        $appointment = Appointment::create([
            'user_id' => $validated['user_id'],
            'braider_id' => $validated['braider_id'],
            'start_time' => $validated['start_time'],
            'finish_time' => $validated['finish_time'],
        ]);

        // Mark the specific availability slot as booked
        $availability->update(['booked' => true]);

        // Send email notifications
        $userEmail = $appointment->user->email; // Assuming `user` relationship exists
        $braiderEmail = $appointment->braider->user->email; // Assuming `braider` has a `user` relationship

        Mail::to($userEmail)->send(new AppointmentConfirmation($appointment));
        Mail::to($braiderEmail)->send(new BraiderAppointmentConfirmation($appointment));


        $userId = auth()->id(); 
        $variation = $request->input('variation', session('abTests.fullcalendar_view_test', 'timeGridWeek')); 

        Log::info("A/B Test: User {$userId} assigned to: " . $variation);
        
        ABTestLog::create([
            'user_id' => auth()->id(),
            'test_name' => 'fullcalendar_view_test',
            'variation' => $variation,
            'action' => 'booking'
        ]);

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
