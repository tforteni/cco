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
            $table->string('recurrence')->nullable()->after('availability_type'); // e.g., daily, weekly
            $table->uuid('series_id')->nullable()->after('recurrence'); // for recurring group
            $table->enum('cancelled_by', ['client', 'stylist'])->nullable()->after('booked');
            $table->text('cancel_reason')->nullable()->after('cancelled_by');
            $table->text('notes')->nullable()->after('cancel_reason'); // for extra stylist/client info
            $table->timestamp('reminder_sent_at')->nullable()->after('notes'); // for SMS/email reminder logic
            $table->boolean('is_active')->default(true)->after('reminder_sent_at'); // for soft-disable logic
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            $table->dropColumn([
                'recurrence',
                'series_id',
                'cancelled_by',
                'cancel_reason',
                'notes',
                'reminder_sent_at',
                'is_active',
            ]);
        });
    }
};
