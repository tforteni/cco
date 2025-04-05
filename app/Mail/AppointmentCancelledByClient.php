<?php

namespace App\Mail;

use App\Models\Appointment; // add line to import the Appointment model
use App\Models\Braider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentCancelledByClient extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->subject('An Appointment Was Cancelled by the Client')
                    ->view('emails.appointment_cancelled_by_client');
    }
}
