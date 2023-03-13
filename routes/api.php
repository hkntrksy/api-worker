<?php

use Illuminate\Support\Facades\Route;

Route::prefix('device')->group(function () {

    Route::post('register', [\App\Http\Controllers\Api\DeviceController::class, 'register']);

    Route::middleware(\App\Http\Middleware\TokenMiddleware::class)->group(function () {
        Route::post('purchase', [\App\Http\Controllers\Api\DeviceController::class, 'purchase']);
        Route::get('check-subscription', [\App\Http\Controllers\Api\DeviceController::class, 'checkSubscription']);
    });

});
