<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Services\TwilioService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAppointmentReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function handle(): void
    {
        $user = $this->appointment->user;

        // Safety check
        if (!$user->phone || !$this->appointment->start_time) {
            return;
        }

        app(TwilioService::class)->sendSms(
            $user->phone,
            "Reminder: Your appointment with {$this->appointment->braider->user->name} is tomorrow at {$this->appointment->start_time->format('g:i A')}."
        );
    }
}
