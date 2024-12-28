<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Teni',
            'role' => 'admin', // Aligned with the 'role' field as a string enum in your current model
            'email' => 't@t.com',
            'password' => Hash::make('teni'),
            'phone' => '1234567890', // Optional: Add a default phone number
        ]);

        // Braider Users
        User::create([
            'name' => 'Amaya',
            'role' => 'braider', // Role for braiders
            'email' => 'a@a.com',
            'password' => Hash::make('amaya'),
            'phone' => '0987654321', // Optional: Add a phone number
        ]);

        User::create([
            'name' => 'Mirelle',
            'role' => 'braider',
            'email' => 'm@m.com',
            'password' => Hash::make('mirelle'),
            'phone' => '5678901234', // Optional: Add a phone number
        ]);

        // Regular User
        User::create([
            'name' => 'Samuel',
            'role' => 'member', // Role for regular users
            'email' => 's@s.com',
            'password' => Hash::make('samuel'),
            'phone' => '1122334455', // Optional: Add a phone number
        ]);
    }
}
