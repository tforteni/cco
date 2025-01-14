<header class="bg-navy text-tahini shadow-md fixed top-0 w-full z-50" style="font-family: 'Cormorant Garamond', serif;">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

        .hover\:bg-dark-tahini:hover {
            background-color: #c2a372;
        }

        .relative {
            position: relative;
        }

        .absolute {
            position: absolute;
        }
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
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-sm font-semibold leading-6 text-tahini focus:outline-none">
                        {{ Auth::user()->name }}
                        <i class="fas fa-caret-down ml-1"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-navy text-tahini shadow-lg rounded-lg z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-dark-tahini">Profile</a>
                        @if (Auth::user()->role === 'braider')
                            <a href="{{ route('braider.availability') }}" class="block px-4 py-2 text-sm hover:bg-dark-tahini">Manage Availability</a>
                        @endif
                        @if (Auth::user()->role === 'admin')
                            <a href="/admin" class="block px-4 py-2 text-sm hover:bg-dark-tahini">Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-dark-tahini">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
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
                <li x-data="{ open: false }">
                    <button @click="open = !open" class="w-full text-left text-sm font-semibold leading-6 text-tahini focus:outline-none">
                        {{ Auth::user()->name }}
                        <i class="fas fa-caret-down ml-1"></i>
                    </button>
                    <ul x-show="open" @click.away="open = false" class="mt-2 space-y-1">
                        <li><a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-dark-tahini">Profile</a></li>
                        @if (Auth::user()->role === 'braider')
                            <li><a href="{{ route('braider.availability') }}" class="block px-4 py-2 text-sm hover:bg-dark-tahini">Manage Availability</a></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-dark-tahini">
                                    Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
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
