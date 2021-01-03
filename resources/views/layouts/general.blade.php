<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>P2Board</title>
        <link rel="stylesheet" href="{{asset('css/header.css')}}" />
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;1,100&display=swap" rel="stylesheet" />
        @yield('css')
    </head>
    <body>
        @if (Auth::check())
            <header>
                <nav>
                    <a href="/">Menu</a>
                    <a href="{{route('board.create')}}">Créer une Board</a>
                    <a href="{{route('login.logout')}}">Log out</a>
                </nav>
            </header>
        @endif
        @yield('content')
    </body>
</html>