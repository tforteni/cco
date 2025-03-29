<?php

use App\Models\User;
use App\Models\Braider;
use App\Models\Specialty;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Database\Seeders\SpecialtySeeder;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// Test: braider cannot switch back to member
test('braider cannot switch back to member', function () {
    $user = User::factory()->create(['role' => 'braider']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'member',
    ]);

    $response->assertSessionHasErrors('role');
});

// Test: non-admin cannot switch to admin
test('non-admin cannot switch to admin role', function () {
    $user = User::factory()->create(['role' => 'braider']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'admin',
    ]);

    $response->assertSessionHasErrors('role');
});

// Test: braider can be created with full details using seeded specialties
test('braider can be created with full details using seeded specialties', function () {
    Storage::fake('public');

    $this->seed(SpecialtySeeder::class);

    $specialty = Specialty::where('name', 'Box Braids')->first();

    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.switchRole'), [
        'role' => 'braider',
        'bio' => 'Braiding queen',
        'min_price' => 100,
        'max_price' => 300,
        'headshot' => UploadedFile::fake()->image('headshot.jpg'),
        'specialties' => [$specialty->id],
    ]);

    $response->assertRedirect(route('profile.edit'));

    $user = $user->fresh();

    expect($user->role)->toBe('braider');
    expect($user->braider)->not()->toBeNull();
    expect($user->braider->bio)->toBe('Braiding queen');
    expect($user->braider->specialties)->toHaveCount(1);
    expect($user->braider->specialties->pluck('name'))->toContain('Box Braids');
    Storage::disk('public')->assertExists($user->braider->headshot);
});

// Test: braider can update only their bio
test('braider can update only bio', function () {
    $user = User::factory()->create(['role' => 'braider']);
    Braider::factory()->create(['user_id' => $user->id, 'bio' => 'Original bio']);

    $response = $this->actingAs($user)->patch(route('profile.updateBraiderField'), [
        'bio' => 'Updated bio content here.',
    ]);

    $response->assertRedirect(route('profile.edit'));
    expect($user->braider->fresh()->bio)->toBe('Updated bio content here.');
});

// Test: non-braider cannot update braider fields
test('non-braider cannot update braider fields', function () {
    $user = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($user)->patch(route('profile.updateBraiderField'), [
        'bio' => 'Trying to sneak in',
    ]);

    $response->assertSessionHasErrors('role');
});
