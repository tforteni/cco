use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

<?php


Route::middleware('api')->group(function () {
    Route::post('/log-ab-click', function (Request $request) {
        dispatch(new LogABTestEvent(auth()->id(), $request->variation, 'click'));
        return response()->json(['message' => 'Click logged']);
    });
});

Route::get('/api/genai-style-suggestion', [GenAIController::class, 'suggest']);
Route::post('/api/genai-style-feedback', [GenAIController::class, 'feedback']);

