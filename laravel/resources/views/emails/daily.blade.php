<body>
    <h1>Weather Report for {{ $user->favorite_city }}</h1>

    <div>
        <h2>Current weather conditions:</h2>
        <p>Temperature: {{ $weatherData['temp'] }}°C</p>
        <p>Description: {{ ucfirst($weatherData['weather']) }}</p>
        
        <h3>Details:</h3>
        <ul>
            <li>Feels like: {{ $weatherData['feels_like'] }}°C</li>
            <li>Min Temperature: {{ $weatherData['temp_min'] }}°C</li>
            <li>Max Temperature: {{ $weatherData['temp_max'] }}°C</li>
            <li>Pressure: {{ $weatherData['pressure'] }} hPa</li>
            <li>Humidity: {{ $weatherData['humidity'] }}%</li>
            <li>Visibility: {{ $weatherData['visibility'] / 1000 }} km</li>
            <li>Wind Speed: {{ $weatherData['wind_speed'] }} m/s</li>
            <li>Wind Direction: {{ $weatherData['wind_deg'] }}°</li>
        </ul>
    </div>
</body>