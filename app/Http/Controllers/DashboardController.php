<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function show()
    {
        $userId = auth()->id();

        $nextAppointment = Appointment::where('user_id', $userId)
            ->where('start_time', '>', now())
            ->orderBy('start_time')
            ->with('braider.user')
            ->first();

        $pastAppointments = Appointment::where('user_id', $userId)
            ->where('start_time', '<', now())
            ->with('review', 'braider.user')
            ->orderByDesc('start_time')
            ->get();

        return view('dashboard', compact('nextAppointment', 'pastAppointments'));
    }
}
