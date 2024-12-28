<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Braider;

class Appointment extends Model
{
    use HasFactory;

    // Define the fields that can be mass assigned
    protected $fillable = [
        'start_time',
        'finish_time',
        'comments',
        'user_id',       // Refers to the client who booked the appointment
        'braider_id',    // Refers to the braider who will provide the service
    ];

    // Relationship with the User model (client)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with the Braider model
    public function braider()
    {
        return $this->belongsTo(Braider::class, 'braider_id');
    }
}
