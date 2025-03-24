<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-tahini bg-navy antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10 sm:px-6 lg:px-8">

            <!-- Logo -->
            <div class="mb-6">
                <a href="/">
                    <img src="{{ asset('images/logo.JPEG') }}" alt="Coily Curly Office" class="h-16 sm:h-20 w-auto">
                </a>
            </div>

            <!-- Main Content Card -->
            <div class="w-full max-w-xl bg-light-navy border border-dark-tahini rounded-xl shadow-md p-6 sm:p-8">
                {{ $slot }}
            </div>
        </div>
</body>
</html>
