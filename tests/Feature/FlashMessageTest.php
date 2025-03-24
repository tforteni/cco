<?php

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Database\Seeders\SpecialtySeeder;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// Test: profile update flashes success message
test('profile update flashes status message', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name' => 'Updated User',
        'email' => $user->email, // same email to avoid reset logic
    ]);

    $response->assertSessionHas('status', 'profile-updated');
});

// Test: switching to braider flashes message
test('switching role to braider flashes success message', function () {
    Storage::fake('public');
    $this->seed(SpecialtySeeder::class);
    $specialty = \App\Models\Specialty::first();

    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'braider',
        'bio' => 'Braiding queen',
        'min_price' => 100,
        'max_price' => 300,
        'headshot' => UploadedFile::fake()->image('headshot.jpg'),
        'specialties' => [$specialty->id],
    ]);

    $response->assertSessionHas('message', 'Braider profile updated successfully.');
});

// Test: deleting user redirects and clears session
test('account deletion clears session and redirects', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->actingAs($user)->delete('/profile', [
        'password' => 'password',
    ]);

    $response->assertRedirect('/');
    $this->assertGuest();
});
