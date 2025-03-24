<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BraiderController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Braider;
use App\Models\Specialty;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BraiderFilterController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // route for switching roles
    Route::patch('/profile/switch-role', [ProfileController::class, 'switchRole'])->name('profile.switchRole');
    Route::patch('/profile/update-braider-field', [ProfileController::class, 'updateBraiderField'])->name('profile.updateBraiderField');

});

require __DIR__.'/auth.php';

// Route::get('/braiders', function () {
//     $braiders = Braider::all();
//     return view('braiders', ['braiders' => $braiders]);
// })->middleware(['auth', 'verified'])->name('braiders');

Route::get('/braiders', function () {
    $braiders = Braider::all();
    $specialties = Specialty::all();
    return view('braiders', compact('braiders', 'specialties'));
})->middleware(['auth', 'verified'])->name('braiders');

Route::post('/braiders/filter', [BraiderFilterController::class, 'filter'])->name('braiders.filter');

# Route for fetching specialty suggestions for the autocomplete input
Route::get('/specialty-suggestions', function (Illuminate\Http\Request $request) {
    $query = $request->query('q');
    $results = Specialty::where('name', 'like', "%$query%")->limit(10)->get();
    return response()->json($results);
})->middleware(['auth', 'verified'])->name('specialties.suggestions');



Route::get('/braiders/{braider}', function (Braider $braider) {
    return view('braider', ['braider' => $braider]);
})->middleware(['auth', 'verified'])->name('braider');

// Braider profile
Route::get('/braider-profile', function () {
    $braider = Auth::user()->braider;
    return view('braider-profile', ['braider' => $braider]);
})->middleware(['auth', 'verified']);

// Manage braider availability
Route::middleware(['auth', 'verified', 'role:braider'])->group(function () {
    Route::get('/braider/availability', [AvailabilityController::class, 'index'])->name('braider.availability');
    Route::post('/availabilities', [AvailabilityController::class, 'store'])->name('availabilities.store');
    Route::delete('/availabilities/{id}', [AvailabilityController::class, 'destroy'])->name('availabilities.destroy');
});

// Group routes for braider role
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/braider/complete-profile', [BraiderController::class, 'create'])->name('braider.complete-profile');
    Route::post('/braider/complete-profile', [BraiderController::class, 'store'])->name('braider.store-profile');
});


Route::patch('/braider/update/{field}', [BraiderController::class, 'update'])->name('braider.update');


// Calendar and appointments
Route::get('/club-calendar', function () {
    return view('calendar');
})->middleware(['auth', 'verified'])->name('calendar');

// Other routes
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

// Braider availability
Route::get('/braider/availability', [\App\Http\Controllers\AvailabilityController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('braider.availability');

Route::post('/availabilities', [\App\Http\Controllers\AvailabilityController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('braider.availability.store');

Route::delete('/availabilities/{id}', [\App\Http\Controllers\AvailabilityController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('braider.availability.destroy');


    
// Braider profile with calendar
Route::get('/braiders/{braider}', [\App\Http\Controllers\AppointmentController::class, 'showBraiderProfile'])
    ->middleware(['auth', 'verified'])
    ->name('braider.profile');

Route::post('/appointments', [\App\Http\Controllers\AppointmentController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('appointments.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
