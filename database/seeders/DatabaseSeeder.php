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
            ProductSeeder::class, // Pastikan baris ini ada dan tidak dikomentari
            // UserSeeder::class, // Jika Anda punya seeder user
        ]);
    }
}