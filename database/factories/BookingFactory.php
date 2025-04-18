<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = $this->faker->dateTimeBetween('-1 month', '+1 week');
        $end = (clone $start)->modify('+'.rand(1,7).' days');
        $car = Car::inRandomOrder()->first();
        $days = $start->diff($end)->days ?: 1;
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'car_id' => $car->id,
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'total_price' => $car->price_per_day * $days,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'completed', 'canceled']),
        ];
    }
}
