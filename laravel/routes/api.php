<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiWeatherController;
use App\Http\Controllers\ApiCityController;
use App\Http\Controllers\Api\AuthController;

Route::post('/auth/token', [AuthController::class, 'token']);

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::get('/weather', [ApiWeatherController::class, 'currentWeather']);
    Route::get('/forecast', [ApiWeatherController::class, 'weeklyWeather']);

    Route::prefix('users/places')->group(function () {
        Route::get('/', [ApiCityController::class, 'list']);
        Route::post('/', [ApiCityController::class, 'add']);
        Route::patch('/{city}/favorite', [ApiCityController::class, 'toggleFavorite']);
        Route::patch('/{city}', [ApiCityController::class, 'remove']);
        Route::patch('/{city}/send-forecast', [ApiCityController::class, 'notification']);
    });
});