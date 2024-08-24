<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Availability;
use App\Enums\DayEnum;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Availability::factory()->create([
            'braider_id' => 1,
            'day' => DayEnum::MONDAY,
            'start_time' => 10,
            'end_time' => 14
        ]);

        Availability::factory()->create([
            'braider_id' => 1,
            'day' => DayEnum::THURSDAY,
            'start_time' => 16,
            'end_time' => 19
        ]);

        Availability::factory()->create([
            'braider_id' => 1,
            'day' => DayEnum::MONDAY,
            'start_time' => 6,
            'end_time' => 9
        ]);

        Availability::factory()->create([
            'braider_id' => 1,
            'day' => DayEnum::SATURDAY,
            'start_time' => 9,
            'end_time' => 17
        ]);
    }
}
