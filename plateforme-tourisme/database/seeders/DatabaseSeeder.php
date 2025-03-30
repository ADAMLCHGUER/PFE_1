<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorieSeeder::class,
            VilleSeeder::class,
            PrestataireSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}