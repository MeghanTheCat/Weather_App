<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{

    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.weather.url');
    }

    public function getWeather($city)
    {
        $response = Http::get("{$this->baseUrl}/weather", [
            'q' => $city,
            'appid' => config("services.weather.key"),
            'units' => 'metric',
            'lang' => 'en',
        ]);

        return $response->json();
    }

    public function getWeeklyForecast($city)
    {
        $response = Http::get("{$this->baseUrl}/forecast", [
            'q' => $city,
            'appid' => config("services.weather.key"),
            'units' => 'metric',
            'lang' => 'en'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            $forecast = $this->processForecastData($data['list']);
            return $forecast;
        } else {
            throw new \Exception('Unable to retrieve forecast weather.');
        }
    }

    private function processForecastData($list)
    {
        $forecast = [];
        foreach ($list as $item) {
            $date = new \DateTime($item['dt_txt']);
            $dayKey = $date->format('Y-m-d');
            if (!isset($forecast[$dayKey])) {
                $forecast[$dayKey] = [
                    'date' => $date,
                    'temp_min' => $item['main']['temp_min'],
                    'temp_max' => $item['main']['temp_max'],
                    'description' => $item['weather'][0]['description'],
                    'icon' => $item['weather'][0]['icon']
                ];
            } else {
                $forecast[$dayKey]['temp_min'] = min($forecast[$dayKey]['temp_min'], $item['main']['temp_min']);
                $forecast[$dayKey]['temp_max'] = max($forecast[$dayKey]['temp_max'], $item['main']['temp_max']);
            }
        }
        return array_values($forecast);
    }
}