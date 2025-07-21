<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    <title>@yield('adminTitle')</title>
</head>

<body>
    <main>
        @yield('adminContent')
    </main>
</body>

</html>