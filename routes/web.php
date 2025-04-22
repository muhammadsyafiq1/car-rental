<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\Booking;
use Illuminate\Support\Facades\Route;

Route::get('/', [CarController::class, 'index'])->name('cars.index');
Route::get('/bookings/form/{car}', [BookingController::class, 'form'])->name('bookings.form');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/confirm/{booking}', [BookingController::class, 'confirm'])->name('bookings.confirm');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/data', [ProductController::class, 'data']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
