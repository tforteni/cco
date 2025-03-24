<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BraiderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use App\Models\Braider;
use App\Http\Middleware\ABTestMiddleware;
use App\Models\ABTestLog;
use Illuminate\Http\Request;
use App\Jobs\LogABTestEvent;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');


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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
require __DIR__.'/auth.php';

Route::get('/braiders', function () {
    $braiders = Braider::all();
    return view('braiders', ['braiders' => $braiders]);
})->middleware(['auth', 'verified'])->name('braiders');

Route::get('/braiders/{braider}', function (Braider $braider) {
    return view('braider', ['braider' => $braider]);
})->middleware(['auth', 'verified'])->name('braider');

Route::get('/braiders/{id}', [BraiderController::class, 'show'])->name('braiders.show');

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
    ->middleware(['auth', 'verified', ABTestMiddleware::class ])
    ->name('braider.profile');

Route::post('/appointments', [\App\Http\Controllers\AppointmentController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('appointments.store');

Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/appointments/{appointment}/review', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/appointments/{appointment}/review', [ReviewController::class, 'store'])->name('reviews.store');
    });

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::post('/log-ab-click', function (Request $request) {
//     ABTestLog::create([
//         'user_id' => auth()->id(),
//         'test_name' => 'fullcalendar_view_test',
//         'variation' => $request->variation,
//         'action' => 'click'
//     ]);
//     return response()->json(['message' => 'Click logged']);
// });

// A/B Test logs are processed in a background queue instead of being logged immediately.
// This is done by dispatching a job to log the A/B test event.
Route::post('/log-ab-click', function (Request $request) {
    dispatch(new LogABTestEvent(auth()->id(), $request->variation, 'click'));
    return response()->json(['message' => 'Click logged']);
});


Route::get('/ab-test-results', function () {
    $results = ABTestLog::select('variation', 'action', DB::raw('COUNT(*) as count'))
        ->groupBy('variation', 'action')
        ->get();

    return view('ab-test-results', ['results' => $results]);
});
