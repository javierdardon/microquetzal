<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GamasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Gama::create([
            'name' => 'De entrada',
            'percentage' => 40,
        ]);
        \App\Models\Gama::create([
            'name' => 'Media',
            'percentage' => 55,
        ]);
        \App\Models\Gama::create([
            'name' => 'Media alta',
            'percentage' => 70,
        ]);
        \App\Models\Gama::create([
            'name' => 'Alta',
            'percentage' => 85,
        ]);
        \App\Models\Gama::create([
            'name' => 'Premium',
            'percentage' => 100,
        ]);
    }
}
