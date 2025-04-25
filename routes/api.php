<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenAIController;
use App\Jobs\LogABTestEvent;

Route::get('/ping-genai', function () {
    return response()->json(['status' => 'GENAI ROUTES LOADED ✅']);
});

Route::middleware('api')->group(function () {
    Route::post('/log-ab-click', function (Request $request) {
        dispatch(new LogABTestEvent(auth()->id(), $request->variation, 'click'));
        return response()->json(['message' => 'Click logged']);
    });

    Route::get('/genai-style-suggestion', [GenAIController::class, 'suggest']);
    Route::post('/genai-style-feedback', [GenAIController::class, 'feedback']);

});

