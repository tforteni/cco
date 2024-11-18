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
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('braider_id')->constrained('braiders')->cascadeOnDelete(); // Link to braiders
            //$table->enum('day', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])->nullable(); // Weekly availability
            $table->dateTime('start_time'); // For one-time or recurring availability
            $table->dateTime('end_time');   // End time
            $table->string('availability_type')->default('one_time'); // 'one_time' or 'recurring'
            $table->boolean('booked')->default(false); // Whether the slot is booked
            $table->string('location')->nullable(); // Optional location
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};
