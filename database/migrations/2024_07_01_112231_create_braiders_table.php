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
        Schema::create('braiders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('bio');
            $table->string('headshot');
            $table->string('work_image1')->nullable();
            $table->string('work_image2')->nullable();
            $table->string('work_image3')->nullable();
            $table->integer('min_price')->default(1);
            $table->integer('max_price')->default(1);;
            $table->boolean('share_email')->default(false);
            $table->boolean('verified')->default('0');
            //I want to have hair speciality be an enum but i'll need to make a pivot table
            //I still want to have a usual availability field
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('braiders');
    }
};
