<?php

namespace App\Console\Commands;

use App\Notifications\WeatherReport;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Services\WeatherService;
use App\Notifications\SendNotification;
use App\Models\UserCity;

class SendWeatherEmails extends Command
{
    protected $signature = 'weather:send-reports';

    protected $description = 'Sending email to user for daily update on favorite city';

    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $city = $user->favorite;
            if ($city != null) {
                $weatherService = new WeatherService();
                $weatherData = $weatherService->getWeather($city);

                $favorite_data = [
                    'weatherData' => $weatherData
                ];
            }
            $cities = UserCity::all();
            foreach ($cities as $city) {
                if ($city->user_id == $user->id && $city->notification_enable) {
                    $this->info("ville {$city->city} pour {$user->id}");
                }
            }
            die();
            $user->notify(new SendNotification($favorite_data ?? ''));
            $this->info("Successfully sent to {$user->email}");
        }
    }

    private function getWeather($city)
    {
        $service = new WeatherService;
        $weatherData = $service->getWeeklyForecast($city);
        return $weatherData;
    }
}
