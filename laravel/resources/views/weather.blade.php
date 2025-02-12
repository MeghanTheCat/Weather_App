<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <head>
        <link rel="stylesheet" href="{{ asset('css/weather.css') }}">
    </head>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Weather') }}
        </h2>
    </x-slot>
    
    <div class="container">
        <h1 class="main-title">Enter a city to know the weather</h1>
        <form method="POST" action="{{ route('weather.fetch') }}">
            @csrf
            <div>
                <label for="city">City</label>
                <input id="city" type="text" name="city" required>
            </div>
            <button type="submit">See the weather</button>
        </form>
        
        @if (isset($response) && $response)
            <div class="weather-container">
                <h1 class="main-title">Weather at {{ $city }}</h1>
                @if (isset($error))
                    <p class="error">Error : {{ $error }}</p>
                @else
                    <div class="weather-main">
                        <p class="temp">{{ $temp }}°C</p>
                        <img src="http://openweathermap.org/img/wn/{{ $icon }}.png" alt="">
                        <p class="description">{{ ucfirst($weather) }}</p>
                    </div>
                    <div class="weather-details">
                        <p class="feels-like">Feels like {{ $feels_like }}°C</p>
                        <p class="temp-min">Minimum : {{ $temp_min }}°C</p>
                        <p class="temp-max">Maximum : {{ $temp_max }}°C</p>
                        <p class="pressure">Pressure : {{ $pressure }} hPa</p>
                        <p class="humidity">Humidity : {{ $humidity }}%</p>
                        <!-- <p class="sea-level">Sea level : {{ $sea_level }} m</p> -->
                        <!-- <p class="ground-level">Ground level : {{ $grnd_level }} m</p> -->
                        <p class="visibility">Visibility : {{ $visibility / 1000 }} km</p>
                        <!-- <p class="wind-speed">Wind speed : {{ $wind_speed * 3.6 }} km/h</p> -->
                        <!-- <p class="wind-direction">Wind direction : {{ $wind_deg }}°</p> -->
                    </div>

                @endif
                <a href="{{ route('weather') }}" class="back-button">Back</a>
                <a href="{{ route('weather.weekly', ['city' => $city]) }}" class="weekly-forecast-button">See forecast</a>
            </div>
        @endif
    </div>
</x-app-layout>