<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Braider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = now()->subDays(2);
        $end = now()->subDay();
    
        return [
            'user_id' => User::factory(),
            'braider_id' => Braider::factory(),
            'start_time' => $start,
            'finish_time' => $end,
        ];
    }
}
