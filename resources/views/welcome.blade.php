<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #F3F4F6;
            color: #658edc;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .top-nav {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .top-nav a {
            margin-left: 10px;
            padding: 10px 20px;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .top-nav a:hover {
            background-color: #60a5fa;
        }
        .center-content {
            text-align: center;
            background-color: #e0f2fe;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
@if (Route::has('login'))
    <div class="top-nav">
        @auth
            <a href="{{ url('/dashboard') }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
            @endif
        @endauth
    </div>
@endif

<div class="center-content">
    <h1>Bienvenidos al Sistema de Gestión de Proyectos</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.</p>
</div>
</body>
</html>
