<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Database\Seeders\SpecialtySeeder;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// Missing required fields when switching to braider
test('switching to braider fails when required fields are missing', function () {
    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'braider',
        // bio, headshot, min_price, max_price, specialties missing
    ]);

    $response->assertSessionHasErrors(['bio', 'headshot', 'min_price', 'max_price', 'specialties']);
});

// min_price > max_price should fail validation
test('switching to braider fails when min_price is greater than max_price', function () {
    Storage::fake('public');
    $this->seed(SpecialtySeeder::class);
    $specialty = \App\Models\Specialty::first();

    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'braider',
        'bio' => 'Test Bio',
        'headshot' => UploadedFile::fake()->image('test.jpg'),
        'min_price' => 300,
        'max_price' => 100,
        'specialties' => [$specialty->id],
    ]);

    $response->assertSessionHasErrors('max_price');
});

// Invalid specialty ID should fail
test('switching to braider fails with invalid specialty ID', function () {
    Storage::fake('public');

    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'braider',
        'bio' => 'Valid Bio',
        'headshot' => UploadedFile::fake()->image('valid.jpg'),
        'min_price' => 100,
        'max_price' => 300,
        'specialties' => [999], // ID that doesn’t exist
    ]);

    $response->assertSessionHasErrors('specialties.0');
});

// Uploading non-image file should fail
test('switching to braider fails with invalid headshot file', function () {
    Storage::fake('public');
    $this->seed(SpecialtySeeder::class);
    $specialty = \App\Models\Specialty::first();

    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'braider',
        'bio' => 'Bio here',
        'headshot' => UploadedFile::fake()->create('not-an-image.pdf', 100, 'application/pdf'),
        'min_price' => 100,
        'max_price' => 300,
        'specialties' => [$specialty->id],
    ]);

    $response->assertSessionHasErrors('headshot');
});

// Oversized headshot should fail
test('switching to braider fails with oversized headshot', function () {
    Storage::fake('public');
    $this->seed(SpecialtySeeder::class);
    $specialty = \App\Models\Specialty::first();

    $user = User::factory()->create(['role' => 'member']);

    $oversized = UploadedFile::fake()->image('large.jpg')->size(3000); // 3MB

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'braider',
        'bio' => 'Bio text',
        'headshot' => $oversized,
        'min_price' => 100,
        'max_price' => 300,
        'specialties' => [$specialty->id],
    ]);

    $response->assertSessionHasErrors('headshot');
});

// Missing 'role' field should fail
test('role field is required when switching roles', function () {
    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        // 'role' => missing
    ]);

    $response->assertSessionHasErrors('role');
});

// Invalid role value should fail
test('invalid role value should not be accepted', function () {
    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'hacker-mode',
    ]);

    $response->assertSessionHasErrors('role');
});

// Non-array specialties should fail
test('specialties must be an array when switching to braider', function () {
    Storage::fake('public');

    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'braider',
        'bio' => 'Test bio',
        'headshot' => UploadedFile::fake()->image('test.jpg'),
        'min_price' => 100,
        'max_price' => 200,
        'specialties' => 'not-an-array',
    ]);

    $response->assertSessionHasErrors('specialties');
});

// Empty specialties array should fail
test('empty specialties array is not allowed', function () {
    Storage::fake('public');

    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'braider',
        'bio' => 'Test bio',
        'headshot' => UploadedFile::fake()->image('test.jpg'),
        'min_price' => 100,
        'max_price' => 200,
        'specialties' => [],
    ]);

    $response->assertSessionHasErrors('specialties');
});

// Unauthenticated users cannot switch roles
test('guest cannot switch roles', function () {
    $response = $this->patch(route('profile.switchRole'), [
        'role' => 'braider',
    ]);

    $response->assertRedirect(route('login'));
});

