<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

    <div class="header">
        <div class="header-nav container">
            <a href="/settings" class="header-nav_button">
                <span>Настройки</span>
            </a>
            <a href="/settings" class="header-nav_button">
                <span>Выход</span>
            </a>
        </div>
    </div>


    @yield('content')


    <script src="/js/app.js"></script>
</body>
</html>