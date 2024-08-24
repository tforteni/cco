<!DOCTYPE html>
<html lang="en" class="h-full bg-navy">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" contents="width=device-width, initial-scale=1"> 
        <title>CCO</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <x-header></x-header>
    {{$slot}}
</html>