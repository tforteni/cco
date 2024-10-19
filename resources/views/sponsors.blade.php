<x-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-4xl font-bold text-center text-tahini mb-8">Featured Sponsors</h1>

        <!-- Sponsor 1 -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center mb-12">
            <a href="https://mielleorganics.com" target="_blank" class="lg:mr-8">
                <img src="{{ asset('images/mielle_logo.jpg') }}" alt="Mielle" class="h-40 w-40 object-contain">
            </a>
            <div class="lg:flex-grow lg:mt-0 lg:text-left">
                <p class="text-sm text-tahini">Built on a mission to serve Black women with a high-performance product and natural ingredients.</p>
            </div>
        </div>

        <!-- Sponsor 2 -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center mb-12">
            <a href="https://www.loreal.com" target="_blank" class="lg:mr-8">
                <img src="{{ asset('images/LOreal-logo.png') }}" alt="L'Oreal" class="h-40 w-40 object-contain">
            </a>
            <div class="lg:flex-grow lg:mt-0 lg:text-left">
                <p class="text-sm text-tahini">Aims to create the beauty that moves the world.</p>
            </div>
        </div>
    </div>
</x-layout>
