<x-layout>
    <style>
        body {
            font-family: 'Cormorant Garamond', serif;
        }
    </style>

    <div class="max-w-6xl mx-auto px-4 py-24 text-gray-900 dark:text-gray-100"> {{-- Increased top padding to prevent overlap --}}
        <h2 class="text-4xl font-bold mb-8">Welcome back, {{ auth()->user()->name }}!</h2>

        <!-- Upcoming Appointment -->
        <div class="mb-10">
            <h3 class="text-2xl font-semibold mb-3">📅 Your Next Appointment</h3>
            @if ($nextAppointment)
                <div class="p-5 bg-white/90 dark:bg-gray-800/80 shadow rounded">
                    <p><strong>Braider:</strong> {{ $nextAppointment->braider->user->name }}</p>
                    <p><strong>Date:</strong> {{ $nextAppointment->start_time->format('M d, Y H:i') }}</p>
                </div>
            @else
                <p class="text-gray-400">You don’t have any upcoming appointments.</p>
            @endif
        </div>

        <!-- Past Appointments -->
        <div class="mb-10">
            <h3 class="text-2xl font-semibold mb-3">🕓 Past Appointments</h3>

            @forelse ($pastAppointments as $appointment)
                @if ($appointment->review)
                    <!-- Accordion with Toggle -->
                    <details class="group mb-4 bg-white/90 dark:bg-gray-800/80 p-5 rounded-lg shadow">
                        <summary class="cursor-pointer text-left font-semibold flex justify-between items-center text-tahini">
                            <span>{{ $appointment->start_time->format('M d, Y H:i') }} — {{ $appointment->braider->user->name }}</span>
                            <span class="text-xs text-gray-400">
                                <span class="group-open:hidden">Click to view your review</span>
                                <span class="hidden group-open:inline">Click to collapse</span>
                            </span>
                        </summary>

                        <div class="mt-4 text-sm text-gray-100">
                            <p class="text-green-500 font-semibold">You reviewed this appointment:</p>
                            <blockquote class="border-l-4 border-dark-tahini pl-4 italic my-2 text-gray-300">
                                "{{ $appointment->review->comment }}"
                            </blockquote>
                            <p class="text-sm text-gray-400">Rating: {{ $appointment->review->rating }}/10</p>

                            @if ($appointment->review->media1 || $appointment->review->media2 || $appointment->review->media3)
                                <div class="flex space-x-2 mt-2">
                                    @foreach (['media1', 'media2', 'media3'] as $media)
                                        @if ($appointment->review->$media)
                                            <img src="{{ asset('storage/' . $appointment->review->$media) }}"
                                                alt="Review Image"
                                                class="h-16 w-16 object-cover rounded border">
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </details>
                @else
                    <!-- No review yet -->
                    <div class="mb-4 bg-white/90 dark:bg-gray-800/80 p-5 rounded-lg shadow flex justify-between items-center">
                        <div>
                            <p><strong>{{ $appointment->start_time->format('M d, Y H:i') }}</strong> — {{ $appointment->braider->user->name }}</p>
                        </div>
                        <a href="{{ route('reviews.create', $appointment) }}"
                        class="text-indigo-500 hover:underline text-sm">
                            Leave a Review
                        </a>
                    </div>
                @endif
            @empty
                <p class="text-gray-400">No past appointments yet.</p>
            @endforelse
        </div>



        <!-- Past Hairstyles (Coming Soon) -->
        <div>
            <h3 class="text-2xl font-semibold mb-3">My Hairstyles (Coming soon)</h3>
            <p class="text-gray-400">This will showcase styles you’ve gotten — stay tuned!</p>
        </div>
    </div>
</x-layout>
