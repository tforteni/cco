<?php

namespace App\Jobs;

use App\Models\ABTestLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LogABTestEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $variation;
    protected $action;

    public function __construct($userId, $variation, $action)
    {
        $this->userId = $userId;
        $this->variation = $variation;
        $this->action = $action;
    }

    public function handle()
    {
        Log::info("Processing LogABTestEvent", [
            'userId' => $this->userId,
            'testName' => 'fullcalendar_view_test',
            'variation' => $this->variation,
            'action' => $this->action
        ]);

        // Check if the user exists before inserting
        $userExists = DB::table('users')->where('id', $this->userId)->exists();

        if (!$userExists) {
            Log::error("LogABTestEvent FAILED: User ID {$this->userId} does not exist.");
            return;
        }

        try {
            DB::table('ab_test_logs')->insert([
                'user_id' => $this->userId,
                'test_name' => 'fullcalendar_view_test',
                'variation' => $this->variation,
                'action' => $this->action,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            Log::info("LogABTestEvent SUCCESS: Data inserted into ab_test_logs.");
        } catch (\Exception $e) {
            Log::error("LogABTestEvent FAILED: " . $e->getMessage());
        }
    }

}
