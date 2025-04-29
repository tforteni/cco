<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;



class GenAIController extends Controller
{
    public function showGenAIPage(Request $request)
    {
        $output = null;
        $comparison = null;

        if ($request->has('approach')) {
            $output = $this->generate($request->input('approach'));
        }

        if ($request->has('compare') && $request->boolean('compare')) {
            $a1 = $request->input('approach1', 'A');
            $a2 = $request->input('approach2', 'B');

            $comparison = [
                'id1' => $a1,
                'response1' => $this->generate($a1),
                'id2' => $a2,
                'response2' => $this->generate($a2),
            ];
        }

        return view('genai', [
            'output' => $output,
            'comparison' => $comparison,
        ]);
    }

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

        $response = Http::post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . env('GEMINI_API_KEY'), [
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
            return response()->json([
                'error' => 'Gemini API call failed',
                'details' => $response->json(), //  this shows us exactly what went wrong
                'status' => $response->status(),
                'request_payload' => [
                    'prompt' => $prompt,
                    'temperature' => $temperature,
                ]
            ]);
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
