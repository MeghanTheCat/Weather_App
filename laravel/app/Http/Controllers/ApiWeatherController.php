<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\WeatherService;
use App\Http\Resources\WeatherRessource;
use App\Http\Resources\ForecastRessource;
use Illuminate\Http\Response;

class ApiWeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService) {
        $this->weatherService = $weatherService;
    }

    public function currentWeather(Request $request) {
        $request->validate(['city' => 'required|string']);
        $weather = $this->weatherService->getWeather($request->city);
        return new WeatherRessource($weather);
    }
    
    public function weeklyWeather(Request $request) {
        $request->validate(['city' => 'required|string']);
        $weather = $this->weatherService->getWeeklyForecast($request->city);
        return new ForecastRessource($weather);
    }
}
