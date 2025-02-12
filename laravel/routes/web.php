<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/weather', [WeatherController::class, 'showForm'])->name('weather');
Route::post('/weather', [WeatherController::class, "fetchWeather"])->name('weather.fetch');
Route::get('/weather/{city}', [WeatherController::class, 'weekly'])->name('weather.weekly');
Route::get('/weather/save/{city}', [SaveController::class, 'saveCity'])->name('weather.save');
Route::delete('/weather/{city}', [SaveController::class, 'killCity'])->name('weather.kill');
Route::get('/weather/favorite/{city}', [FavoriteController::class, 'favoriteAdd'])->name('favorite.add');
Route::post('/weather/notification/{city}', [SaveController::class, 'addNotification'])->name('notification.add');
Route::post('/weather/removeNotification/{city}', [SaveController::class, 'removeNotification'])->name('notification.remove');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
