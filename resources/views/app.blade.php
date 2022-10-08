<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        @vite('resources/sass/app.scss')
        @inertiaHead
    </head>
    <body>
        @inertia

        <script src="https://kit.fontawesome.com/84e6af0da9.js" crossorigin="anonymous"></script>
        @routes
        @vite('resources/js/app.js')
    </body>
</html>
