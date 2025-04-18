<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jobs\SendBookingNotification;


class BookingController extends Controller
{
    public function form(Car $car)
    {
        return view('bookings.form', compact('car'));
    }

    public function confirm(Booking $booking)
    {
        return view('bookings.confirm', compact('booking'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = Car::findOrFail($request->car_id);

        // Cek tumpang tindih
        $overlap = Booking::where('car_id', $car->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('start_date', '<=', $request->start_date)
                         ->where('end_date', '>=', $request->end_date);
                  });
            })->exists();

        if ($overlap) {
            return response()->json(['message' => 'Car is already booked on selected dates'], 422);
        }

        $days = Carbon::parse($request->start_date)->diffInDays($request->end_date) ?: 1;
        $total = $car->price_per_day * $days;

        $booking = Booking::create([
            'user_id' => $request->user_id,
            'car_id' => $car->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $total,
            'status' => 'confirmed',
        ]);

        // Update status mobil
        $car->availability_status = 'booked';
        $car->save();

        // Invalidate cache Redis
        Cache::flush();

        // Queue email notification
        dispatch(new SendBookingNotification($booking));

        // Redirect ke halaman konfirmasi
        return redirect()->route('bookings.confirm', $booking->id);
    }
}
