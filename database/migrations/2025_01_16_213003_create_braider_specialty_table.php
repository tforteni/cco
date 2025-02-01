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
        Schema::create('braider_specialty', function (Blueprint $table) {
            $table->id();
            $table->foreignId('braider_id')->constrained('braiders')->cascadeOnDelete(); // Braider's ID
            $table->foreignId('specialty_id')->constrained('specialties')->cascadeOnDelete(); // Specialty's ID
            $table->timestamps();   
        }); // define relationship between braiders and specialties ( braider can have many specialties)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('braider_specialty');
    }
};
