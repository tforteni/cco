<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'user_id',
        'braider_id',
        'rating',
        'comment',
        'media1',
        'media2',
        'media3',
    ];

    // Relationships
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function user() // reviewer
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function braider() // stylist being reviewed
    {
        return $this->belongsTo(User::class, 'braider_id');
    }
}
