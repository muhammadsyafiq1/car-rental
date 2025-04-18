<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Booking;
use App\Models\Car;
use App\Models\User;

class BookingTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_book_available_car()
    {
        $this->seed();

        $user = User::first();
        $car = Car::where('availability_status', 'available')->first();

        $response = $this->post('/bookings', [
            'user_id' => $user->id,
            'car_id' => $car->id,
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'car_id' => $car->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_booking_fails_when_car_unavailable()
    {
        $this->seed();

        $user = User::first();
        $car = Car::where('availability_status', 'available')->first();

        // Booking pertama sukses
        $this->post('/bookings', [
            'user_id' => $user->id,
            'car_id' => $car->id,
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
        ]);

        // Booking kedua gagal (overlap)
        $response = $this->post('/bookings', [
            'user_id' => $user->id,
            'car_id' => $car->id,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(4)->format('Y-m-d'),
        ]);

        $response->assertStatus(422);
    }
}
