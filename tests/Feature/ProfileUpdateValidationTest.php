<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// Name is required
test('name is required when updating profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name' => '',
        'email' => 'test@example.com',
    ]);

    $response->assertSessionHasErrors('name');
});

// Email is required
test('email is required when updating profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name' => 'Test User',
        'email' => '',
    ]);

    $response->assertSessionHasErrors('email');
});

// Email must be valid format
test('email must be valid', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name' => 'Test User',
        'email' => 'not-an-email',
    ]);

    $response->assertSessionHasErrors('email');
});

// Email must be unique (except for self)
test('email must be unique', function () {
    $existing = User::factory()->create(['email' => 'existing@example.com']);
    $user = User::factory()->create(['email' => 'user@example.com']);

    $response = $this->actingAs($user)->patch('/profile', [
        'name' => 'Updated',
        'email' => 'existing@example.com',
    ]);

    $response->assertSessionHasErrors('email');
});

// Same email should not reset email_verified_at
test('email_verified_at is not reset when email is unchanged', function () {
    $user = User::factory()->create([
        'email' => 'same@example.com',
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->patch('/profile', [
        'name' => 'Same User',
        'email' => 'same@example.com',
    ]);

    $response->assertSessionHasNoErrors();
    expect($user->refresh()->email_verified_at)->not()->toBeNull();
});

// Changing email resets email_verified_at
test('email_verified_at is reset when email is changed', function () {
    $user = User::factory()->create([
        'email' => 'old@example.com',
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->patch('/profile', [
        'name' => 'Changed User',
        'email' => 'new@example.com',
    ]);

    $response->assertSessionHasNoErrors();
    expect($user->refresh()->email_verified_at)->toBeNull();
});

// Guest cannot update profile
test('guest cannot update profile', function () {
    $response = $this->patch('/profile', [
        'name' => 'Guest User',
        'email' => 'guest@example.com',
    ]);

    $response->assertRedirect(route('login'));
});
