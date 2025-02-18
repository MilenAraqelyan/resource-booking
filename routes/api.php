<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('api')->group(function () {
    Route::apiResource('resources', ResourceController::class);
    Route::get('resources/{id}/bookings', [ResourceController::class, 'getBookings']);
    Route::apiResource('bookings', BookingController::class);
});
