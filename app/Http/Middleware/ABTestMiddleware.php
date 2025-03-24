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
        $path = storage_path('app/tests.json');

        if (!file_exists($path)) {
            Log::warning("A/B Test file missing: {$path}. No tests will be applied.");
            $tests = [];
        } else {
            $tests = json_decode(file_get_contents($path), true) ?? [];
        }

        // add  Identify the user
        $userId = $request->user() ? $request->user()->id : $request->ip();
        $hashedVariations = [];

        foreach ($tests as $test_name => $test) {
            if (!isset($test['variations']) || empty($test['variations'])) {
                Log::error("A/B Test Error: Test '{$test_name}' has no variations defined.");
                continue;
            }

            // Generate a hash-based variation
            $hash = crc32($userId . $test_name);
            $variationIndex = $hash % count($test['variations']);
            $hashedVariations[$test_name] = $test['variations'][$variationIndex] ?? 'timeGridWeek';

            Log::info("A/B Test: User {$userId} assigned to {$test_name}: {$hashedVariations[$test_name]}");
        }

        // Merge variations with the request and session
        $request->merge(['abTests' => $hashedVariations]);
        session(['abTests' => $hashedVariations]); // Store in session

        return $next($request);
    }
}

