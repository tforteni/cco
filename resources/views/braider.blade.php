<x-layout>
    <div class="welcome-text mt-10 flex flex-col justify-center items-center pb-10">
        <p class="text-tahini text-4xl font-schoolbook">{{ $braider->user->name }}!</p>
    </div>

    <div class="grid grid-cols-2 gap-10 pl-10 pr-10">
        <!-- About and Reviews Section -->
        <div class="space-y-8">
            <!-- About Section -->
            <div class="flex flex-col items-center">
                <p class="text-3xl text-tahini font-bold pb-4">About {{ $braider->user->name }}</p>
                <p class="text-xl text-tahini">{{ $braider->bio }}</p>
            </div>

            <!-- Appointment Scheduling Section -->
            <div class="p-4 space-y-4 text-tahini bg-light-navy rounded-md border-dark-tahini border-2">
                <div class="flex flex-col items-center">
                    <p class="text-xl font-semibold">Schedule an Appointment</p>
                </div>
                @if($braider->share_email)
                <div class="flex flex-col items-center">
                    <p>CALENDLY LINK HERE</p>
                </div>
                @endif

                <!-- Calendar Link -->
                <div class="mt-4 text-center">
                    <a href="{{ route('braider.calendar', $braider->id) }}" 
                       class="bg-navy-highlight text-tahini font-semibold py-2 px-4 rounded hover:bg-dark-tahini transition">
                       View Full Calendar
                    </a>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="p-4 space-y-4 text-tahini bg-light-navy rounded-md border-dark-tahini border-2">
                <div class="flex flex-col items-center">
                    <p class="text-xl font-semibold">Reviews</p>
                </div>
                <div>
                    <p class="font-bold">Kike says:</p>
                    <p class="border-l-4 border-dark-tahini pl-4">Amaya did such a great job with my box braids! Would def recommend!!!</p>
                </div>
                <div>
                    <p class="font-bold">Bukola says:</p>
                    <p class="border-l-4 border-dark-tahini pl-4">Super fast service and the braids look great!</p>
                </div>
                <div>
                    <p class="font-bold">Arike says:</p>
                    <p class="border-l-4 border-dark-tahini pl-4">Kind of expensive but worth it I think.</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
