<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function listCar(Request $request)
    {
        $cars = \App\Models\Car::where('availability_status', 'available')->get();
        return view('list-car', compact('cars'));
    }
}
