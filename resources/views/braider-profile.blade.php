<x-layout>
    <div class="welcome-text mt-10 flex flex-col justify-center items-center">
        <p class="text-tahini text-4xl font-schoolbook">Hi, {{ $braider->user->name }}!</p>
    </div>

    <!-- Look to braider-profile2.blade.php for good initial design -->

    <!-- Simplified Section with Link to the Calendar -->
    <div class="bg-light-navy rounded-md p-10 m-10 border-2 border-navy-highlight text-center">
        <p class="text-light font-semibold text-4xl mb-4">Manage Your Appointments</p>
        <a href="{{ route('braider.availability', $braider->id) }}" 
           class="bg-navy-highlight text-tahini font-semibold py-2 px-4 rounded hover:bg-dark-tahini transition">
            View and Manage Your Calendar
        </a>
    </div>
</x-layout>
