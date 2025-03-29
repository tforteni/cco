<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Braider>
 */
class BraiderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),  // Assuming you have a UserFactory
            'bio' => $this->faker->sentence(), // Random bio
            'headshot' => $this->faker->imageUrl(300, 300, 'people', true), // Generate a fake image
            'work_image1' => $this->faker->imageUrl(300, 300, 'fashion', true), // Generate a fake work image
            'work_image2' => $this->faker->imageUrl(300, 300, 'fashion', true), // Generate another fake work image
            'work_image3' => $this->faker->imageUrl(300, 300, 'fashion', true), // Generate another fake work image
            'min_price' => $this->faker->numberBetween(20, 50), // Random min price
            'max_price' => $this->faker->numberBetween(100, 200), // Random max price
        ];
    }
}
