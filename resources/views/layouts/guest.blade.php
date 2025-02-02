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
    <body class="font-sans text-gray-900 antialiased">
        <!-- Background of the entire page -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-navy"> <!-- Updated background color to navy -->
            
            <!-- Logo -->
            <div>
                <a href="/">
                    <img class="mx-auto" src="{{ asset('images/logo.JPEG') }}" alt="Coily Curly Office" style="height: 4.5rem; max-width: 100px; width: auto;">
                </a>
            </div>



            <!-- Form Container (Card) -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-light-navy shadow-md overflow-hidden sm:rounded-lg border-2 border-dark-tahini"> <!-- Updated background color to light navy -->
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
