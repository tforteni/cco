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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('braider_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
        
            $table->tinyInteger('rating')->unsigned(); // 1–10
            $table->text('comment')->nullable();
        
            // Optional review images (up to 3 for now)
            $table->string('media1')->nullable();
            $table->string('media2')->nullable();
            $table->string('media3')->nullable();
        
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
