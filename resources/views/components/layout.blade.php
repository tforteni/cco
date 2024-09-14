<!DOCTYPE html>
<html lang="en" class="h-full bg-navy">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CCO</title>

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Font Awesome for Social Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
        <!-- Inter Font -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <!-- Vite resources -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="flex flex-col min-h-screen">
        <!-- Header section -->
        <x-header></x-header>

        <!-- Main content area -->
        <main class="flex-grow">
            {{$slot}}
        </main>

        <!-- Footer section for Instagram -->
        <footer class="bg-dark-tahini text-light-navy py-6 mt-auto">
            <div class="max-w-4xl mx-auto text-center">
                <a href="https://www.instagram.com/thecoilycurly" target="_blank" class="inline-block mt-2">
                    <i class="fab fa-instagram text-4xl"></i>
                </a>
            </div>
        </footer>
    </body>
</html>
