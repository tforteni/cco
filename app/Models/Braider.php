<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Availability;

class Braider extends Model
{
    use HasFactory;

    // Specify fields that can be mass assigned
    protected $fillable = ['verified', 'user_id', 'bio', 'headshot', 'work_image1', 'work_image2', 'work_image3', 'share_email', 'max_price', 'min_price'];

    /**
     * Define the relationship between a Braider and a User.
     * A braider belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship between a Braider and Availabilities.
     * A braider has many availabilities.
     */
    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'braider_specialty');
    }

}