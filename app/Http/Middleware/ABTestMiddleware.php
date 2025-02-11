<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ABTestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Load A/B test configuration from tests.json
        $tests = json_decode(file_get_contents(storage_path('app/tests.json')), true);

        // Identify the user: Use user_id if logged in, else use IP
        $userId = $request->user() ? $request->user()->id : $request->ip();
        $hashedVariations = [];

        foreach ($tests as $test_name => $test) {
            // Generate a consistent hash for each user and test
            $hash = crc32($userId . $test_name); 
            $variationIndex = $hash % count($test['variations']); // Get a variation index
            $hashedVariations[$test_name] = $test['variations'][$variationIndex];

            Log::info("A/B Test: User {$userId} assigned to {$test_name}: {$hashedVariations[$test_name]}");

        }

        // Attach the assigned variations to the request
        $request->merge(['abTests' => $hashedVariations]);

        return $next($request);
    }
}
