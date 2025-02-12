<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForecastRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'forecast' => collect($this->resource)->map(function ($day) {
                return [
                    'date' => $day['date']->format('Y-m-d H:i:s'),
                    'temp_min' => $day['temp_min'],
                    'temp_max' => $day['temp_max'],
                    'description' => $day['description'],
                    'icon' => $day['icon']
                ];
            })->toArray()
        ];
    }
}
