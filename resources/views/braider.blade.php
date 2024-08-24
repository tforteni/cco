@php
    $alldays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    $available_days = [];
    foreach($braider->availability as $option)
    {
        $available_days[] = $option->day;
    }
@endphp

<x-layout>
    <div class="welcome-text mt-10 flex flex-col justify-center items-center pb-10">
        <p class="text-tahini text-4xl font-schoolbook">{{ $braider->user->name }}!</p>
    </div>

    <div class="grid grid-cols-2 gap-10 pl-10 pr-10">
        <div class="bg-dark-tahini rounded-md p-2 border-2 border-navy-highlight">
                <p class="text-navy font-semibold text-4xl">{{ $braider->user->name }}'s availability</p>
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
        <div class="space-y-8">
            <div class="flex flex-col items-center">
                <p class="text-3xl text-tahini font-bold pb-4" >About {{ $braider->user->name }}</p>
                <p class="text-xl text-tahini">{{ $braider->bio }}</p>
            </div>
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
                    <p class="border-l-4 border-dark-tahini pl-4">Super fast serivce and the braids look great!</p>
                </div>
                <div>
                    <p class="font-bold">Arike says:</p>
                    <p class="border-l-4 border-dark-tahini pl-4">Kind of expensive but worth it I think.</p>
                </div>
            </div>
            <div class="p-4 space-y-4 text-tahini bg-light-navy rounded-md border-dark-tahini border-2">
                <div class="flex flex-col items-center">
                    <p class="text-xl font-semibold">Schedule an Appointment</p>
                </div>
                <div class="grid grid-cols-2">
                    <div class="space-y-3">
                        @foreach($alldays as $day)
                            @if(in_array($day, $available_days))
                                <x-radio-button>{{$day}}</x-radio-button>
                            @endif
                        @endforeach
                    </div>
                    <div>Times</div>
                </div>
                @if($braider->share_email)
                <div class="flex flex-col items-center">
                    <p>None of the available times work? Reach out to {{$braider->user->name}} to set something up: {{$braider->user->email}}!</p>
                    <p class="text-xs">Remember that braiders have published their preferred times so there is no guarantee a time not listed here will be available.</p>
                </div>
                @endif
        </div>
        </div>
    </div>
</x-layout>