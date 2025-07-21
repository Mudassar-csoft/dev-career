<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Tailwind CSS & Alpine via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', 'My Site')</title>
</head>

<body class="max-w-[1440px] mx-auto">

    {{-- Navbar --}}
    @include('components.web.navbar')

    {{-- Main Content --}}
    <main>
        @yield('webContent')
        @include('components.web.keep-in-touch-floating')
    </main>

    {{-- Footer --}}
    @include('components.web.footer')

</body>

</html>