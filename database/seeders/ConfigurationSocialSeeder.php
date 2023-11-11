<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ConfigurationSocial::create([
            'facebook'=> 'https://www.facebook.com/MicroQuetzal',
            'whatsapp'=> 'https://api.whatsapp.com/send?phone=50237331777&text=%C2%BFQuiero%20realizar%20una%20cotizaci%C3%B3n%3F%20%F0%9F%98%8E',
            'gmail'=> null,
            'twitter'=> null,
            'instagram'=> null,
            'tikTok'=> null,
        ]);
    }
}
