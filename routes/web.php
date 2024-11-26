<?php

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Braider;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/braiders', function () {
    $braiders = Braider::all();
    return view('braiders', ['braiders' => $braiders]);
})->middleware(['auth', 'verified'])->name('braiders');

Route::get('/braiders/{braider}', function (Braider $braider) {
    return view('braider', ['braider' => $braider]);
})->middleware(['auth', 'verified'])->name('braider');

// route to show braider profile with reviews, availability calendar, etc.
Route::get('/braider-profile', function () {
    $braider = Auth::user()->braider;
    return view('braider-profile', ['braider' => $braider]);
})->middleware(['auth', 'verified']);


// route to manage braider availability
Route::middleware(['auth', 'role:braider'])->group(function () {
    Route::get('/braider/availability', [AvailabilityController::class, 'index'])->name('braider.availability');
    Route::post('/braider/availability', [AvailabilityController::class, 'store'])->name('braider.availability.store');
    Route::delete('/braider/availability/{id}', [AvailabilityController::class, 'destroy'])->name('braider.availability.destroy');
});


Route::get('/club-calendar', function () { //modified from 'calendar' to 'club-calendar'
    return view('calendar');
})->middleware(['auth', 'verified'])->name('calendar');

Route::get('/studentpicks', function () {
    return view('studentpicks');
})->name('studentpicks');

Route::get('/sponsors', function () {
    return view('sponsors');
})->name('sponsors');

Route::get('/about-coco', function () {
    return view('about-coco');
})->name('about-coco');

Route::get('/ambassadors', function () {
    return view('ambassadors');
})->middleware(['auth', 'verified'])->name('ambassadors');

Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

// Routes for managing braider availability
Route::get('/braider/availability', [\App\Http\Controllers\AvailabilityController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('braider.availability'); // Route for viewing availability

Route::post('/availabilities', [\App\Http\Controllers\AvailabilityController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('braider.availability.store'); // Route for adding availability

Route::delete('/availabilities/{id}', [\App\Http\Controllers\AvailabilityController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('braider.availability.destroy'); // Route for deleting availability

// Routes for braider's calendar and booking appointments
Route::get('/braiders/{braider}/calendar', [\App\Http\Controllers\AppointmentController::class, 'showBraiderCalendar'])
    ->middleware(['auth', 'verified'])
    ->name('braider.calendar'); // Route for viewing braider calendar

Route::post('/appointments', [\App\Http\Controllers\AppointmentController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('appointments.store'); // Route for booking appointments
