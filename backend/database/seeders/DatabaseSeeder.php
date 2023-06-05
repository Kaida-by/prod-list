<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PhoneSeeder::class,
            SettingsSeeder::class,
            UserSeeder::class,
            CommentSeeder::class,
            ProductListSeeder::class,
            TypeProductSeeder::class,
            TypeCountSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
