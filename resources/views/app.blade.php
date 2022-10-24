<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        @vite('resources/sass/app.scss')
        @inertiaHead
    </head>
    <body class="bg-white d-flex flex-column h-100">
        <main class="mb-3">
            @inertia
        </main>

        <footer class="footer mt-auto py-3 bg-dark">
            <div class="container text-center">
                <span class="text-light">
                    Made with <i class="fa-solid fa-heart text-danger"></i> by
                    <a href="http://drash.co.ke" target="_blank" class="text-decoration-none">Drash Labs</a>
                </span>
            </div>
        </footer>

        @routes
        <script src="https://kit.fontawesome.com/84e6af0da9.js" crossorigin="anonymous"></script>
        @vite('resources/js/app.js')
    </body>
</html>
