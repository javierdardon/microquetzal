<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::create([
            'name' => 'Tarjetas Graficas',
        ]);
        \App\Models\Category::create([
            'name' => 'Gabinetes / Case',
        ]);
        \App\Models\Category::create([
            'name' => 'Motherboard',
        ]);
        \App\Models\Category::create([
            'name' => 'Procesadores',
        ]);
        \App\Models\Category::create([
            'name' => 'Memoria RAM',
        ]);
        \App\Models\Category::create([
            'name' => 'Enfriamiento / Disipadores',
        ]);
        \App\Models\Category::create([
            'name' => 'Fuentes de Poder',
        ]);
        \App\Models\Category::create(   [
            'name' => 'Almacenamiento',
        ]);
    }
}
