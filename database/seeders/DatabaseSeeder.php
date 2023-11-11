<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ConfigurationHeroSeeder::class,
            ConfigurationFinalFrameSeeder::class,
            ConfigurationSocialSeeder::class,
            AboutSeeder::class,
            BuildComponentCategoriesSeeder::class,
            RolesSeeder::class,
            UserSeeder::class,
            GamasSeeder::class,
            BuildsSeeder::class,
        ]);
    }
}
