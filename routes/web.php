<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\HomeController;
use App\Models\Booking;
use Illuminate\Support\Facades\Route;

Route::get('/', [CarController::class, 'index'])->name('cars.index');
Route::get('/bookings/form/{car}', [BookingController::class, 'form'])->name('bookings.form');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/confirm/{booking}', [BookingController::class, 'confirm'])->name('bookings.confirm');
