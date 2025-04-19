<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Braider;

class Availability extends Model
{
    use HasFactory;

    // Define the fields that can be mass assigned
    protected $fillable = [
        'braider_id',
        'start_time',
        'end_time',
        'availability_type',
        'booked',
        'location',
        'date',
        'phone_number',
        'recurrence',
        'series_id',
        'cancelled_by',
        'cancel_reason',
        'notes',
        'reminder_sent_at',
        'is_active',
    ];
    

    // Define the relationship with the Braider model
    public function braider()
    {
        return $this->belongsTo(Braider::class);
    }
}
