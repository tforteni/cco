<header>
  <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
    <div class="flex lg:flex-1">
      <a href="/" class="-m-1.5 p-1.5">
        <span class="sr-only">Your Company</span>
        <img class="h-20 w-auto" src="{{ asset('images/logo.JPEG') }}" alt="">
      </a>
    </div>
  
    <div class="hidden lg:flex lg:gap-x-12">
    <x-top-nav-link href="/about-coco" :active="request()->segment(1) == 'about-coco' ? true : false">Who We Are</x-top-nav-link>
    <x-top-nav-link href="/sponsors" :active="request()->segment(1) == 'sponsors' ? true : false">Our Sponsors</x-top-nav-link>
      <!-- Show these links only if the user is logged in -->
      @auth
      <x-top-nav-link href="/braiders" :active="request()->segment(1) == 'braiders' ? true : false">Braiders</x-top-nav-link>
      <x-top-nav-link href="/calendar" :active="request()->is('calendar')">Calendar</x-top-nav-link>
      <x-top-nav-link href="/ambassadors" :active="request()->is('ambassadors')">Ambassadors</x-top-nav-link>
      <x-top-nav-link href="/studentpicks" :active="request()->is('studentpicks')">Student Picks</x-top-nav-link>
      @endauth
      @admin
        <a href="/admin" class="text-sm font-semibold leading-6 text-light">Admin</a>
      @endadmin
      @braider
        <a href="/braider-profile" class="text-sm font-semibold leading-6 text-light">Braider Profile</a>
      @endbraider
    </div>
    <div class="hidden lg:flex lg:flex-1 lg:justify-end space-x-1">
        @guest
            <a href="/login" class="text-sm font-semibold leading-6 text-tahini">Log in </a>
            <p class="text-sm font-semibold leading-6 text-tahini" > | </p>
            <a href="/register" class="text-sm font-semibold leading-6 text-tahini">Register </a>
        @endguest
        @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="route('logout')" class="text-sm font-semibold leading-6 text-tahini" onclick="event.preventDefault(); this.closest('form').submit();">
                Sign out <span aria-hidden="true">&rarr;</span>
            </a>
        @endauth
    </div> 
  </nav>
</header>
