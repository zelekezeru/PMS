<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
            <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="min-h-screen flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-xl font-semibold">Welcome to Laravel</h1>
                <p class="text-sm mt-4">Welcome to your Laravel application!</p>
            </div>
        </div>
        <p>Hello</p>
    </body>
</html>
