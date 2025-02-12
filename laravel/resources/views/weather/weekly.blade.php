<x-app-layout>
    <div class="container">
        <h1 class="main-title">Weather forecast at {{ $city }}</h1>
        @if (isset($error))
            <p class="error">{{ $error }}</p>
        @else
            <div class="weekly-forecast">
                <a href="{{ route('weather.save', ['city' => $city]) }}" class="back-button">Save</a>
                <a href="{{ route('favorite.add', ['city' => $city]) }}" class="back-button">Add to favorite</a>
                @foreach ($forecast as $day)
                    <div class="day-forecast" style="padding: 8vh 0 0 0">
                        <h2>{{ $day['date']->format('m/d/Y') }}</h2>
                        @if(isset($day['icon']))
                            <img src="http://openweathermap.org/img/wn/{{ $day['icon'] }}.png" alt="Icône météo" style="background-color:rgb(65, 150, 230); padding: 0 10px 0 10px; border-radius: 30px">
                        @else
                            <p>Icône non disponible</p>
                        @endif
                        <p class="temp">{{ round($day['temp_min']) }}°C | {{ round($day['temp_max']) }}°C</p>
                        <p class="description">{{ ucfirst($day['description']) }}</p>
                    </div>
                @endforeach
            </div>
        @endif
        <a href="{{ route('weather') }}" class="back-button">Back</a>
    </div>
</x-app-layout>