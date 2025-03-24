<?php

use App\Models\User;
use App\Models\Braider;
use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// A user can submit a valid review
test('user can submit a review for completed appointment', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $braiderUser = User::factory()->create(['role' => 'braider']);
    $braider = Braider::factory()->create([
        'user_id' => $braiderUser->id,
        'bio' => 'Test bio',
    ]);

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
        'braider_id' => $braider->id,
        'start_time' => now()->subDays(3),
        'finish_time' => now()->subDays(2),
    ]);

    $response = $this->actingAs($user)->post(route('reviews.store', $appointment), [
        'rating' => 8,
        'comment' => 'Loved the experience!',
        'media1' => UploadedFile::fake()->image('style1.jpg'),
    ]);

    $response->assertRedirect(); // or assertRedirect(route('dashboard'))
    $this->assertDatabaseHas('reviews', [
        'appointment_id' => $appointment->id,
        'user_id' => $user->id,
        'rating' => 8,
    ]);
});

// Cannot submit review twice for same appointment
test('user cannot submit multiple reviews for same appointment', function () {
    $user = User::factory()->create();
    $braider = Braider::factory()->create();

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
        'braider_id' => $braider->id,
        'start_time' => now()->subDays(3),
        'finish_time' => now()->subDays(2),
    ]);

    $user->reviewsGiven()->create([
        'appointment_id' => $appointment->id,
        'braider_id' => $braider->user_id,
        'rating' => 7,
        'comment' => 'Good service.',
    ]);

    $response = $this->actingAs($user)->post(route('reviews.store', $appointment), [
        'rating' => 9,
        'comment' => 'Trying to review again.',
    ]);

    $response->assertSessionHas('message', 'You already reviewed this appointment.');
});

// Guests cannot access review form
test('guests cannot access review creation page', function () {
    $appointment = Appointment::factory()->create();

    $response = $this->get(route('reviews.create', $appointment));
    $response->assertRedirect(route('login'));
});

// Rating is required
test('review requires a rating', function () {
    $user = User::factory()->create();
    $appointment = Appointment::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->post(route('reviews.store', $appointment), [
        'comment' => 'Missing rating',
    ]);

    $response->assertSessionHasErrors('rating');
});

test('user can submit a valid review for a past appointment', function () {
    $user = User::factory()->create();
    $braiderUser = User::factory()->create(['role' => 'braider']);
    $braider = Braider::factory()->create(['user_id' => $braiderUser->id]);

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
        'braider_id' => $braider->id,
        'start_time' => now()->subDays(3),
        'finish_time' => now()->subDays(2),
    ]);

    $response = $this->actingAs($user)->post(route('reviews.store', $appointment), [
        'rating' => 8,
        'comment' => 'Awesome experience!',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseHas('reviews', [
        'appointment_id' => $appointment->id,
        'rating' => 8,
        'comment' => 'Awesome experience!',
    ]);
});


test('user cannot review a future appointment', function () {
    $user = User::factory()->create();
    $braiderUser = User::factory()->create(['role' => 'braider']);
    $braider = Braider::factory()->create(['user_id' => $braiderUser->id]);

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
        'braider_id' => $braider->id,
        'start_time' => now()->addDay(),
        'finish_time' => now()->addDays(2),
    ]);

    $response = $this->actingAs($user)->post(route('reviews.store', $appointment), [
        'rating' => 10,
        'comment' => 'Can’t wait!',
    ]);

    $response->assertStatus(403); // Forbidden
});


test('user cannot review the same appointment twice', function () {
    $user = User::factory()->create();
    $braiderUser = User::factory()->create(['role' => 'braider']);
    $braider = Braider::factory()->create(['user_id' => $braiderUser->id]);

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
        'braider_id' => $braider->id,
        'start_time' => now()->subDays(3),
        'finish_time' => now()->subDays(2),
    ]);

    Review::create([
        'user_id' => $user->id,
        'braider_id' => $braiderUser->id,
        'appointment_id' => $appointment->id,
        'rating' => 9,
        'comment' => 'Already reviewed!',
    ]);

    $response = $this->actingAs($user)->post(route('reviews.store', $appointment), [
        'rating' => 10,
        'comment' => 'Trying again...',
    ]);

    $response->assertSessionHas('message', 'You already reviewed this appointment.');
});


test('user can upload images with a review', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $braiderUser = User::factory()->create(['role' => 'braider']);
    $braider = Braider::factory()->create(['user_id' => $braiderUser->id]);

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
        'braider_id' => $braider->id,
        'start_time' => now()->subDays(3),
        'finish_time' => now()->subDays(2),
    ]);

    $response = $this->actingAs($user)->post(route('reviews.store', $appointment), [
        'rating' => 7,
        'comment' => 'Pics attached!',
        'media1' => UploadedFile::fake()->image('style1.jpg'),
        'media2' => UploadedFile::fake()->image('style2.jpg'),
        'media3' => UploadedFile::fake()->image('style3.jpg'),
    ]);

    $response->assertRedirect(route('dashboard'));
    Storage::disk('public')->assertExists(
        Review::latest()->first()->media1
    );  
    Storage::disk('public')->assertExists(
        Review::latest()->first()->media2
    );  
    Storage::disk('public')->assertExists(
        Review::latest()->first()->media3
    );  
      
});

test('review rating must be between 1 and 10', function () {
    $user = User::factory()->create();
    $braider = Braider::factory()->create();

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
        'braider_id' => $braider->id,
        'start_time' => now()->subDays(3),
        'finish_time' => now()->subDays(2),
    ]);

    $response = $this->actingAs($user)->post(route('reviews.store', $appointment), [
        'rating' => 11,
        'comment' => 'Invalid rating',
    ]);

    $response->assertSessionHasErrors('rating');
});

test('review comment cannot exceed 1000 characters', function () {
    $user = User::factory()->create();
    $braider = Braider::factory()->create();

    $appointment = Appointment::factory()->create([
        'user_id' => $user->id,
        'braider_id' => $braider->id,
        'start_time' => now()->subDays(3),
        'finish_time' => now()->subDays(2),
    ]);

    $longComment = str_repeat('A', 1001); // 1001 characters

    $response = $this->actingAs($user)->post(route('reviews.store', $appointment), [
        'rating' => 7,
        'comment' => $longComment,
    ]);

    $response->assertSessionHasErrors('comment');
});



