<?php 
namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __invoke()
    {
        $events = [];

        // Fetch appointments with associated user and braider data
        $appointments = Appointment::with(['user', 'braider'])->get();

        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => $appointment->user->name . ' (' . $appointment->braider->user->name . ')',
                'start' => $appointment->start_time,
                'end' => $appointment->finish_time,
            ];
        }

        // Pass the events to the view : will need to modify this to pass the events to the calendar view
        return view('braider-calendar', compact('events')); 
    }
}
