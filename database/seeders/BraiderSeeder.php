<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Braider;

class BraiderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Braider::factory()->create([
            'verified' => 1,
            'user_id' => 2,
            'headshot' => 'images/braider-headshots/amaya.jpg',
            'work_image1' => 'images/braider-headshots/amaya.jpg',
            'bio' => 'Hi! My name is Amaya and I specialize in box braids and cornrows!',
            'min_price' => 10,
            'max_price' => 100,
            'share_email' => true,
        ]);
        
        Braider::factory()->create([
            'verified' => 1,
            'user_id' => 3,
            'headshot' => 'images/braider-headshots/mirelle.jpeg',
            'work_image1' => 'images/braider-headshots/mirelle.jpeg',
            'bio' => 'I\'m Mirelle and I love doing all styles of hair.',
            'min_price' => 50,
            'max_price' => 200,
            'share_email' => false,
        ]);        
    }
}
