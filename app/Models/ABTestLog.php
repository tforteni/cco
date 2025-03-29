<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABTestLog extends Model
{
    use HasFactory;
    
    protected $table = 'ab_test_logs'; // Explicitly define the table name
    protected $fillable = [
        'user_id',
        'test_name',
        'variation',
        'action',
    ];
}
