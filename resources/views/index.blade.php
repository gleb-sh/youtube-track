<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Войти в систему</title>
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>

    <form autocomplete="off" class="wrapper">
        <input type="hidden" name="valid" value="">
        <input type="text" name="login" placeholder="Логин">
        <input type="password" name="pass" placeholder="Пароль">
        <button>Войти</button>
    </form>
    <script src="/js/login.js"></script>
</body>
</html>