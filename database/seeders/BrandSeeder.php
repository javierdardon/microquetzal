<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Brand::create([
            'name' => 'Nvidia',
        ]);
        \App\Models\Brand::create([
            'name' => 'AMD',
        ]);
        \App\Models\Brand::create([
            'name' => 'Intel',
        ]);
        \App\Models\Brand::create([
            'name' => 'ROG',
        ]);
        \App\Models\Brand::create([
            'name' => 'MSI',
        ]);
        \App\Models\Brand::create([
            'name' => 'Corsair',
        ]);
        \App\Models\Brand::create([
            'name' => 'ASUS',
        ]);
        \App\Models\Brand::create([
            'name' => 'Eagle',
        ]);
        \App\Models\Brand::create([
            'name' => 'Gigabyte',
        ]);
        \App\Models\Brand::create([
            'name' => 'Cooler Master',
        ]);
        \App\Models\Brand::create([
            'name' => 'Azza',
        ]);
        \App\Models\Brand::create([
            'name' => 'Kingston',
        ]);
    }
}
