<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Regular user making the appointment
            $table->foreignId('braider_id')->constrained('braiders')->cascadeOnDelete(); // Braider who is booked
            $table->foreignId('availability_id')->constrained('availabilities')->cascadeOnDelete(); // Link to availability time slot
            $table->enum('day', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']); // Day of appointment
            $table->time('start_time'); 
            $table->time('end_time');   
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
