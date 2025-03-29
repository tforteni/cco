<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Availability;
use App\Models\Braider;
use Carbon\Carbon;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get some braiders from the database (replace this with a factory if needed)
        $braiders = Braider::take(5)->get(); // Adjust to your available braiders

        foreach ($braiders as $braider) { // Create 5 slots per braider
            for ($i = 0; $i < 5; $i++) {
                $start = now()->addDays($i + 1)->setTime(10, 0);
                $end = now()->addDays($i + 1)->setTime(17, 0);
            
                Availability::create([
                    'braider_id' => $braider->id,
                    //'day' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'][rand(0, 4)], // Random day
                    // 'start_time' => Carbon::now()->addDays(rand(1, 7))->setTime(rand(8, 12), 0), // Random start time
                    // 'end_time' => Carbon::now()->addDays(rand(1, 7))->setTime(rand(13, 20), 0), // Random end time
                    'start_time' => $start,
                    'end_time' => $end,
                    'availability_type' => ['one_time', 'recurring'][rand(0, 1)], // Random availability type
                    'location' => rand(0, 1) ? 'Salon XYZ' : 'Braider\'s Home', // Random location
                    'booked' => false, // Default to false
                ]);
            }            
        }
    }
}
