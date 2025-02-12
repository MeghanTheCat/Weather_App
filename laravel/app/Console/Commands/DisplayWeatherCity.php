<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\WeatherService;

class DisplayWeatherCity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:display-city {city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $city = $this->argument('city');

        $weatherService = new WeatherService();
        $weatherData = $weatherService->getWeather($city);

        $info = $this->formatWeatherData($weatherData);

        return $this->info($info);
    }

    public function formatWeatherData($weatherData) {
        $temp = $weatherData['main']['temp'];
        $feelsLike = $weatherData['main']['feels_like'];
        $humidity = $weatherData['main']['humidity'];
        $windSpeed = $weatherData['wind']['speed'];
        $description = $weatherData['weather'][0]['description'];
        $pressure = $weatherData['main']['pressure'];
        $visibility = $weatherData['visibility'] / 1000; // Conversion en km
        
        $output = "\n";
        $output .= "════════════════════════════════════\n";
        $output .= "           MÉTÉO À " . str_pad(mb_strtoupper($weatherData['name']), 20) . "         \n";
        $output .= "════════════════════════════════════\n";
        $output .= str_pad("🌡️  Temperature: " . number_format($temp, 1) . "°C", 38) . " \n";
        $output .= str_pad("🌡️  Feels like: " . number_format($feelsLike, 1) . "°C", 38) . " \n";
        $output .= str_pad("💧 Humidity: " . $humidity . "%", 38) . " \n";
        $output .= str_pad("💨 Wind: " . number_format($windSpeed * 3.6, 1) . " km/h", 38) . " \n";
        $output .= str_pad("🌫️  Condition: " . ucfirst($description), 38) . " \n";
        $output .= str_pad("🔍 Visibility: " . number_format($visibility, 1) . " km", 38) . " \n";
        $output .= str_pad("⏲️  Pressure: " . $pressure . " hPa", 38) . " \n";
        $output .= "════════════════════════════════════\n";
        
        return $output;
    }
}
