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
        Schema::table('availabilities', function (Blueprint $table) {
            if (!Schema::hasColumn('availabilities', 'date')) {
                $table->date('date')->nullable();
            }
            if (!Schema::hasColumn('availabilities', 'phone_number')) {
                $table->string('phone_number')->nullable();
            }
            if (!Schema::hasColumn('availabilities', 'booked')) {
                $table->boolean('booked')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            if (Schema::hasColumn('availabilities', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('availabilities', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
            if (Schema::hasColumn('availabilities', 'booked')) {
                $table->dropColumn('booked');
            }
        });
    }
};
