<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'city' => $this['name'],
            'weather' => $this['weather'][0]['description'],
            'temp' => $this['main']['temp'],
            'icon' => $this['weather'][0]['icon'],
            'feels_like' => $this['main']['feels_like'],
            'temp_min' => $this['main']['temp_min'],
            'temp_max' => $this['main']['temp_max'],
            'pressure' => $this['main']['pressure'],
            'humidity' => $this['main']['humidity'],
            'sea_level' => $this['main']['sea_level'],
            'grnd_level' => $this['main']['grnd_level'],
            'visibility' => $this['visibility'],
            'wind_speed' => $this['wind']['speed'],
            'wind_deg' => $this['wind']['deg'],
        ];
    }
}
