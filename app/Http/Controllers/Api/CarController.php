<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $brand = $request->brand;
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;
        $availability = $request->availability_status ?? 'available';

        $cacheKey = "cars:$brand:$minPrice:$maxPrice:$availability";

        $cars = Cache::remember($cacheKey, 60, function () use ($brand, $minPrice, $maxPrice, $availability) {
            $query = Car::query();

            if ($brand) {
                $query->where('brand', $brand);
            }

            if ($minPrice) {
                $query->where('price_per_day', '>=', $minPrice);
            }

            if ($maxPrice) {
                $query->where('price_per_day', '<=', $maxPrice);
            }

            if ($availability) {
                $query->where('availability_status', $availability);
            }

            return $query->get();
        });

        return view('cars.index', compact('cars'));
    }
}
