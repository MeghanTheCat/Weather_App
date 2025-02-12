<?php

namespace App\Http\Controllers;

use App\Http\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class WeatherController extends Controller
{

    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
        $this->shareCities();
    }

    public function showForm()
    {
        return view('weather');
    }

    public function fetchWeather(Request $request)
    {
        $city = $request->input('city');

        $weatherService = new WeatherService();

        $weatherData = $weatherService->getWeather($city);

        if ($weatherData) {
            return view('weather', [
                'response' => 'true',
                'city' => $weatherData['name'],
                'weather' => $weatherData['weather'][0]['description'],
                'temp' => $weatherData['main']['temp'],
                'icon' => $weatherData['weather'][0]['icon'],
                'feels_like' => $weatherData['main']['feels_like'],
                'temp_min' => $weatherData['main']['temp_min'],
                'temp_max' => $weatherData['main']['temp_max'],
                'pressure' => $weatherData['main']['pressure'],
                'humidity' => $weatherData['main']['humidity'],
                'sea_level' => $weatherData['main']['sea_level'],
                'grnd_level' => $weatherData['main']['grnd_level'],
                'visibility' => $weatherData['visibility'],
                'wind_speed' => $weatherData['wind']['speed'],
                'wind_deg' => $weatherData['wind']['deg'],
            ]);
        }

        return view('weather', ['error' => 'Unable to fetch data for this city.']);
    }

    public function weekly($city)
    {
        try {
            $weeklyForecast = $this->weatherService->getWeeklyForecast($city);
            \Log::info('Weekly Forecast Data:', $weeklyForecast);
            return view('weather.weekly', ['city' => $city, 'forecast' => $weeklyForecast]);
        } catch (\Exception $e) {
            return view('weather.weekly', ['city' => $city, 'error' => $e->getMessage()]);
        }
    }

    public function shareCities()
    {
        if (auth()->check()) {
            $favorite = auth()->user()->favorite;
            View::share("favorite", $favorite);
            $savedCities = auth()->user()->cities()
            ->when($favorite, function ($query) use ($favorite) {
                return $query->where('city', '!=', $favorite);
            })
            ->get();
            View::share("savedCities", $savedCities);
        }
    }
}
