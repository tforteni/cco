<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GenAIController extends Controller
{
    public function suggest(Request $request)
    {
        $compare = $request->boolean('compare', false);
        $a1 = $request->input('approach1', 'A');
        $a2 = $request->input('approach2', 'B');
        $approach = $request->input('approach', 'A');

        if ($compare) {
            return response()->json([
                'response1' => $this->generate($a1),
                'response2' => $this->generate($a2),
                'id1' => $a1,
                'id2' => $a2
            ]);
        }

        return response()->json([
            'response' => $this->generate($approach),
            'approach' => $approach
        ]);
    }

    private function generate($approach)
    {
        $prompt = match ($approach) {
            'A' => "Suggest a professional protective hairstyle for someone with 4C hair working in a corporate office.",
            'B' => "You are a haircare stylist. Recommend a neat, low-maintenance protective style for a Black college student with thick hair.",
            'C' => "Suggest a creative protective style for natural hair suitable for casual outings.",
            default => "Suggest a general protective hairstyle for natural hair."
        };

        $temperature = ($approach === 'C') ? 0.9 : 0.7;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GEMINI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent', [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => $temperature
            ]
        ]);

        if ($response->failed()) {
            return 'Something went wrong with the Gemini API.';
        }

        return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'No response.';
    }

    public function feedback(Request $request)
    {
        $winner = $request->input('winner');
        $loser = $request->input('loser');

        $scores = json_decode(Storage::get('elo_scores.json'), true) ?? [];
        $scoreA = $scores[$winner] ?? 1000;
        $scoreB = $scores[$loser] ?? 1000;

        $expectedA = 1 / (1 + pow(10, ($scoreB - $scoreA) / 400));
        $expectedB = 1 - $expectedA;
        $k = 32;

        $scores[$winner] = round($scoreA + $k * (1 - $expectedA));
        $scores[$loser] = round($scoreB + $k * (0 - $expectedB));

        Storage::put('elo_scores.json', json_encode($scores));
        return response()->json(['success' => true, 'scores' => $scores]);
    }
}
