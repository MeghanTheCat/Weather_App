<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Console\Commands\SendWeatherEmails;

class WeatherReport extends Notification
{
    use Queueable;

    private $weatherData;

    public function __construct($weatherData)
    {
        $this->weatherData = $weatherData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject("Weather Report for {$this->weatherData['city']}")
        ->greeting("Hello {$notifiable->name}!")
        ->line("Here's your daily weather report for {$this->weatherData['city']}:")
        ->line("Current temperature: {$this->weatherData['temp']}°C")
        ->line("Conditions: " . ucfirst($this->weatherData['weather']))
        ->line("\nDetailed Information:")
        ->line("• Feels like: {$this->weatherData['feels_like']}°C")
        ->line("• Temperature range: {$this->weatherData['temp_min']}°C to {$this->weatherData['temp_max']}°C")
        ->lineIf($this->weatherData['humidity'], "• Humidity: {$this->weatherData['humidity']}%")
        ->lineIf($this->weatherData['pressure'], "• Pressure: {$this->weatherData['pressure']} hPa")
        ->lineIf($this->weatherData['visibility'], "• Visibility: " . ($this->weatherData['visibility'] / 1000) . " km")
        ->lineIf($this->weatherData['wind_speed'], "• Wind: {$this->weatherData['wind_speed']} m/s")
        ->action('View Full Weather Report', url('/weather'))
        ->line('Have a great day!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
