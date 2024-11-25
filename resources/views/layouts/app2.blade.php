<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My Laravel App')</title>

    <!-- FullCalendar and Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <!-- Header content like navbars, etc. -->
    </header>
    
    <main>
        <!-- Here the content of individual pages will be displayed -->
        @yield('content')
    </main>
    
    <footer>
        <!-- Footer content -->
    </footer>

    <!-- Stack for including additional scripts on specific pages -->
    @stack('scripts') <!--Place where scripts will be injected-->
</body>
</html>
