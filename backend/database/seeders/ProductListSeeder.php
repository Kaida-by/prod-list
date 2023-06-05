<?php

namespace Database\Seeders;

use App\Models\ProductList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductList::factory()
            ->count(3)
            ->create();
    }
}
