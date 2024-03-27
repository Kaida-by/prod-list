<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\TypeProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            UserSeeder::class,
            ProductListSeeder::class,
            TypeProductSeeder::class,
            TypeCountSeeder::class,
            ProductSeeder::class,
            BasicTypeProductsSeeder::class,
            BasicProductsSeeder::class,
        ]);

        $generalProducts = Product::all(['id', 'name', 'color', 'user_id'])->toArray();
        $generalTypeProducts = TypeProduct::all(['id', 'name', 'color', 'user_id'])->toArray();

        DB::table('general_products')->insert($generalProducts);
        DB::table('general_type_products')->insert($generalTypeProducts);
    }
}
