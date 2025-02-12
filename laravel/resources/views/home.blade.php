<div>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="vidth=device-width, initial-scale=1.0">
        <title>Home page</title>
    </head>
    <body>
        <h1>Welcome home!</h1>

        @guest
            <!-- If the user isn't connected -->
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @else
            <!-- If the user is connected -->
            <p>Hey, {{ Auth::user()->name }}!</p>
            <form action="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @endguest
    </body>
</div>