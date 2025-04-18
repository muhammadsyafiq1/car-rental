<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    // database/factories/CarFactory.php
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'brand' => $this->faker->randomElement(['Toyota', 'Honda', 'Ford', 'BMW']),
            'price_per_day' => $this->faker->randomFloat(2, 100, 1000),
            'availability_status' => 'available',
        ];
    }
}
