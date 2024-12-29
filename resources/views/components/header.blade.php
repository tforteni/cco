<header class="bg-navy text-tahini shadow-md fixed top-0 w-full z-50" style="font-family: 'Cormorant Garamond', serif;">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');
    </style>

    <nav class="mx-auto flex max-w-7xl items-center justify-between h-16 lg:h-20 px-6 lg:px-8" aria-label="Global">
        <!-- Logo -->
        <div class="flex items-center lg:flex-1">
            <a href="/" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img class="h-12 lg:h-16 w-auto" src="{{ asset('images/logo.JPEG') }}" alt="Coily Curly Office">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex lg:gap-x-12">
            <x-top-nav-link href="/about-coco" :active="request()->segment(1) == 'about-coco' ? true : false">Who We Are</x-top-nav-link>
            @auth
                <x-top-nav-link href="/braiders" :active="request()->segment(1) == 'braiders' ? true : false">Braiders</x-top-nav-link>
                <!-- <x-top-nav-link href="/calendar" :active="request()->is('calendar')">Calendar</x-top-nav-link> -->
            @endauth
        </div>

        <!-- Desktop Auth Links -->
        <div class="hidden lg:flex lg:flex-1 lg:justify-end space-x-1">
            @guest
                <a href="/login" class="text-sm font-semibold leading-6 text-tahini">Log in</a>
                <span class="text-sm font-semibold leading-6 text-tahini">|</span>
                <a href="/register" class="text-sm font-semibold leading-6 text-tahini">Register</a>
            @endguest
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <a href="route('logout')" class="text-sm font-semibold leading-6 text-tahini" 
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        Sign out &rarr;
                    </a>
                </form>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <div class="lg:hidden">
            <button id="menu-toggle" class="text-tahini focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Dropdown Menu -->
    <div id="mobile-menu" class="hidden bg-navy text-tahini lg:hidden">
        <ul class="space-y-4 p-4">
            <li><x-top-nav-link href="/about-coco" :active="request()->segment(1) == 'about-coco' ? true : false">Who We Are</x-top-nav-link></li>
            @auth
                <li><x-top-nav-link href="/braiders" :active="request()->segment(1) == 'braiders' ? true : false">Braiders</x-top-nav-link></li>
                <!-- <li><x-top-nav-link href="/calendar" :active="request()->is('calendar')">Calendar</x-top-nav-link></li> -->
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')" class="block text-sm font-semibold leading-6 text-tahini"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                           Sign out
                        </a>
                    </form>
                </li>
            @endauth
            @guest
                <li><a href="/login" class="block text-sm font-semibold leading-6 text-tahini">Log in</a></li>
                <li><a href="/register" class="block text-sm font-semibold leading-6 text-tahini">Register</a></li>
            @endguest
        </ul>
    </div>

    <!-- JavaScript for Mobile Menu -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const menuToggle = document.getElementById("menu-toggle");
            const mobileMenu = document.getElementById("mobile-menu");

            menuToggle.addEventListener("click", () => {
                mobileMenu.classList.toggle("hidden");
            });
        });
    </script>
</header>
