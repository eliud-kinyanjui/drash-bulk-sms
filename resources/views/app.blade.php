<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="./assets/favicon/favicon.ico" type="image/x-icon" />
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{ asset('assets/css/theme.bundle.css') }}" />
        @vite('resources/sass/app.scss')
        @inertiaHead
    </head>
    <body class="bg-white">
        @inertia

        @routes
        <script src="https://kit.fontawesome.com/84e6af0da9.js" crossorigin="anonymous"></script>
        @vite('resources/js/app.js')
    </body>
</html>
