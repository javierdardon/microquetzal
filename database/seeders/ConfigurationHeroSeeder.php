<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationHeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ConfigurationHero::create([
            'message1'=> 'MICRO QUETZAL',
            'message2'=> 'NACIONAL',
            'message3'=> 'LAS MEJORES',
            'message4'=> 'PC GAMING',
            'image'=> 'default/hero.svg',
        ]);
    }
}
