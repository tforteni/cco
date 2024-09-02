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

Route::get('/braider-profile', function () {
    $braider = Auth::user()->braider;
    return view('braider-profile', ['braider' => $braider]);
})->middleware(['auth', 'verified']);

Route::get('/calendar', function () {
    return view('calendar');
})->middleware(['auth', 'verified'])->name('calendar');

Route::get('/studentpicks', function () {
    return view('studentpicks');
})->name('studentpicks');

Route::get('/ambassadors', function () {
    return view('ambassadors');
})->middleware(['auth', 'verified'])->name('ambassadors');

Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');