<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildComponentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\BuildComponentCategories::create([
            'cpu'=> 4,
            'cooler'=> 6,
            'ram'=> 5,
            'gpu'=> 1,
            'psu'=> 7,
            'mobo'=> 3,
            'case'=> 2,
            'rom'=> 8,
        ]);
    }
}
