<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Product::class;

    public function definition()
    {
        return [
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id ?? 1,
            'nama' => $this->faker->words(2, true),
            'harga' => $this->faker->randomFloat(2, 10, 1000),
            'stok' => $this->faker->numberBetween(0, 100),
        ];
    }
}
