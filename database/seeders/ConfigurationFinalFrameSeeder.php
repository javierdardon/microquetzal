<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationFinalFrameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ConfigurationFinalFrame::create([
            'message1'=> 'UNETE AL MUNDO DEL  PC GAMING',
            'message2'=> 'MICRO QUETZAL NACIONAL',
            'image'=> 'default/finalFrame.svg',
        ]);
    }
}
