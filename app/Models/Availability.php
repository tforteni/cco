<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Braider;

class Availability extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function braider()
    {
        return $this->belongsTo(Braider::class);
    }
}
