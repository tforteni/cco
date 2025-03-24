<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Braider; 
use App\Models\Specialty;

class BraiderFilterController extends Controller
{
    //
    public function filter(Request $request)
    {
        $specialtyIds = $request->input('specialties', []);
        //check if $specialtyIds is received correctly:
        Log::info('Specialty filter received:', $specialtyIds);
        $braiders = count($specialtyIds) > 0
            ? Braider::whereHas('specialties', function ($query) use ($specialtyIds) {
                $query->whereIn('specialties.id', $specialtyIds);
            })->get()
            : Braider::all();

        return response()->json([
            'html' => view('partials.braider-list', compact('braiders'))->render()
        ]);
    }

}
