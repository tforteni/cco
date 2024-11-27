<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// implement ShouldQueue interface
class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $appointment
     * @return void
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.appointment_confirmation')
                    ->subject('Your Appointment Confirmation')
                    ->with([
                        'appointment' => $this->appointment,
                    ]);
    }
}
