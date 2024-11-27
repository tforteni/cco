<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

//implement shouldQueue interface
class BraiderAppointmentConfirmation extends Mailable
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
        return $this->view('emails.braider_appointment_confirmation')
                    ->subject('New Appointment Booked')
                    ->with([
                        'appointment' => $this->appointment,
                    ]);
    }
}
