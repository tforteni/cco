<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialty;

class SpecialtySeeder extends Seeder
{
    public function run()
    {
        $specialties = [
            'Box Braids', 'Cornrows', 'Twists', 'Faux Locs', 
            'Ghana Braids', 'Flat Twists', 'Knotless Braids', 'Passion Twists',
            'Senegalese Twists', 'Fulani Braids', 'Butterfly Locs' , 'French Curls', 'Spring Twists'
        ];

        foreach ($specialties as $specialty) {
            Specialty::firstOrCreate(['name' => $specialty]);
        }
    }
}
