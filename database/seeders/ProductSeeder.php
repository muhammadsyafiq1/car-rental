<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat 10 kategori
        Category::factory()->count(10)->create();

        // Buat 1000 produk
        Product::factory()->count(1000)->create();
    }
}
