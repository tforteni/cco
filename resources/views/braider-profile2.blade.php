<!-- <x-layout>
    <div class="welcome-text mt-10 flex flex-col justify-center items-center">
        <p class="text-tahini text-4xl font-schoolbook">Hi, {{ $braider->user->name }}!</p>
    </div>

    <div class="bg-light-navy rounded-md p-2 m-10 border-2 border-navy-highlight">
        <p class="text-light font-semibold text-4xl p-1">This Week</p>
        <div class="grid grid-cols-8 gap-1 pb-2">
                <div class="col-span-1"></div>
                <div class="col-span-1 text-center text-tahini font-semibold">Mon</div>
                <div class="col-span-1 text-center text-tahini font-semibold">Tue</div>
                <div class="col-span-1 text-center text-tahini font-semibold">Wed</div>
                <div class="col-span-1 text-center text-tahini font-semibold">Thu</div>
                <div class="col-span-1 text-center text-tahini font-semibold">Fri</div>
                <div class="col-span-1 text-center text-tahini font-semibold">Sat</div>
                <div class="col-span-1 text-center text-tahini font-semibold">Sun</div>
            </div>
        <div class="grid grid-cols-8 gap-1">
            <div class="space-y-1">
                <x-availability-times/>
            </div>
            <x-this-week-bar></x-this-week-bar>
            <x-this-week-bar></x-this-week-bar>
            <x-this-week-bar></x-this-week-bar>
            <x-this-week-bar></x-this-week-bar>
            <x-this-week-bar></x-this-week-bar>
            <x-this-week-bar></x-this-week-bar>
            <x-this-week-bar></x-this-week-bar>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-10 pl-10 pr-10">
        <div class="bg-dark-tahini rounded-md p-2 border-2 border-navy-highlight">
            <div class="flex justify-between">
                <p class="text-navy font-semibold p-1">Your Weekly Availability</p>
            </div>
            <div class="grid grid-cols-8 gap-1">
                <div class="col-span-1"></div>
                <div class="col-span-1 text-center text-light-navy font-semibold">Mon</div>
                <div class="col-span-1 text-center text-light-navy font-semibold">Tue</div>
                <div class="col-span-1 text-center text-light-navy font-semibold">Wed</div>
                <div class="col-span-1 text-center text-light-navy font-semibold">Thu</div>
                <div class="col-span-1 text-center text-light-navy font-semibold">Fri</div>
                <div class="col-span-1 text-center text-light-navy font-semibold">Sat</div>
                <div class="col-span-1 text-center text-light-navy font-semibold">Sun</div>
            </div>
            <div class="grid grid-cols-8 gap-1">
                <div class="space-y-1">
                    <x-availability-times/>
                </div>

                <x-availability-bar :availability="$braider->availability" day="monday"></x-availability-bar>
                <x-availability-bar :availability="$braider->availability" day="tuesday"></x-availability-bar>
                <x-availability-bar :availability="$braider->availability" day="wednesday"></x-availability-bar>
                <x-availability-bar :availability="$braider->availability" day="thursday"></x-availability-bar>
                <x-availability-bar :availability="$braider->availability" day="friday"></x-availability-bar>
                <x-availability-bar :availability="$braider->availability" day="saturday"></x-availability-bar>
                <x-availability-bar :availability="$braider->availability" day="sunday"></x-availability-bar>
            </div>
        </div>
        <div class="bg-light-navy rounded-md p-40 border-2 border-navy-highlight">
        </div>
    </div>
</x-layout> -->

<x-layout>
    <div class="welcome-text mt-10 flex flex-col justify-center items-center">
        <p class="text-tahini text-4xl font-schoolbook">Hi, {{ $braider->user->name }}!</p>
    </div>

    <!-- Simplified Section with Link to the Calendar -->
    <div class="bg-light-navy rounded-md p-10 m-10 border-2 border-navy-highlight text-center">
        <p class="text-light font-semibold text-4xl mb-4">Manage Your Appointments</p>
        <a href="{{ route('braider.calendar', $braider->id) }}" 
           class="bg-navy-highlight text-tahini font-semibold py-2 px-4 rounded hover:bg-dark-tahini transition">
            View and Manage Your Calendar
        </a>
    </div>
</x-layout>
