 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            if (!Schema::hasColumn('availabilities', 'date')) {
                $table->date('date')->nullable(); // For one-off availability
            }
            if (!Schema::hasColumn('availabilities', 'phone_number')) {
                $table->string('phone_number')->nullable();
            }
            if (!Schema::hasColumn('availabilities', 'booked')) {
                $table->boolean('booked')->default(false);
            }
        });
    }

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