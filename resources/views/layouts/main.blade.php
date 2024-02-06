<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/pages.css')}}">
</head>
<body>
<header>
    <h1>WS Karaganda</h1>
    <nav>
        @auth()
            <a href="{{route('logout')}}">Logout</a>
        @endauth

        @guest()
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        @endguest
    </nav>
</header>

@yield('content')
</body>
</html>
