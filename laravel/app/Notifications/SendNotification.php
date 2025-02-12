<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendNotification extends Notification
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data, $user)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)

            ->subject("Weather Report for {$this->data['weatherData']['name']}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Here's your daily weather report for {$this->data['weatherData']['name']}:")
            ->line("Current temperature: {$this->data['weatherData']['main']['temp']}°C")
            ->line("Conditions: " . ucfirst($this->data['weatherData']['weather'][0]['description']))
            ->line("\nDetailed Information:")
            ->line("• Feels like: {$this->data['weatherData']['main']['feels_like']}°C")
            ->line("• Temperature range: {$this->data['weatherData']['main']['temp_min']}°C to {$this->data['weatherData']['main']['temp_max']}°C")
            ->lineIf($this->data['weatherData']['main']['humidity'], "• Humidity: {$this->data['weatherData']['main']['humidity']}%")
            ->lineIf($this->data['weatherData']['main']['pressure'], "• Pressure: {$this->data['weatherData']['main']['pressure']} hPa")
            ->lineIf($this->data['weatherData']['visibility'], "• Visibility: " . ($this->data['weatherData']['visibility'] / 1000) . " km")
            ->lineIf($this->data['weatherData']['wind']['speed'], "• Wind: {$this->data['weatherData']['wind']['speed']} m/s")
            ->action('View Full Weather Report', url('/weather/' . $this->data['weatherData']['name']))
            ->line('Have a great day!');

            $csvData = "CSV DATA";
            if ($this->userCity !== null) {

            }
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
