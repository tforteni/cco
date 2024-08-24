<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRoleEnum;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Teni',
            'role' => UserRoleEnum::ADMIN,
            'email' => 't@t.com',
            'password' =>  Hash::make('teni'),
        ]);

        User::factory()->create([
            'name' => 'Amaya',
            'role' => UserRoleEnum::BRAIDER,
            'email' => 'a@a.com',
            'password' =>  Hash::make('amaya'),
        ]);

        User::factory()->create([
            'name' => 'Mirelle',
            'role' => UserRoleEnum::BRAIDER,
            'email' => 'm@m.com',
            'password' =>  Hash::make('mirelle'),
        ]);
    }
}
