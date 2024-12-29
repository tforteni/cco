<x-layout>
    <div class="welcome-text mt-10 flex flex-col justify-center items-center" style="font-family: 'Cormorant Garamond', serif; margin-top: 100px;">
        <p class="text-tahini text-4xl font-bold">{{ $braider->user->name }}!</p>
    </div>

    <!-- Responsive Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 px-4 md:px-10" style="font-family: 'Cormorant Garamond', serif; margin-top: 50px;">
        <!-- Left Column: Calendar Section -->
        <div class="md:col-span-2 p-4 space-y-4 text-tahini bg-light-navy rounded-md border-dark-tahini border-2" style="background-color: #121a26;">
            <div class="flex flex-col items-center">
                <p class="text-2xl font-bold">Booking Calendar</p>
            </div>
            <!-- Scrollable Container for Calendar -->
            <div id="calendarContainer" class="w-full" style="height: 400px; overflow-y: auto; border: 1px solid #c2c2c2; padding: 8px;">
                <div id="fullCalendar" class="w-full" style="font-family: 'Cormorant Garamond', serif; font-size: 0.9rem;"></div>
            </div>
        </div>

        <!-- Right Column: Reviews Section -->
        <div class="p-4 space-y-4 text-tahini bg-light-navy rounded-md border-dark-tahini border-2" style="background-color: #121a26;">
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

    <!-- Inline Script -->
    <script>
        console.log('Script loaded!');

        document.addEventListener('DOMContentLoaded', function () {
            console.log('Initializing FullCalendar...');

            const fullCalendarEl = document.getElementById('fullCalendar');

            // Initialize FullCalendar
            const fullCalendar = new FullCalendar.Calendar(fullCalendarEl, {
                initialView: 'timeGridWeek',
                events: {!! $availabilities !!}, // Ensure valid JSON
                eventClick: function (info) {
                    console.log('Event clicked:', info.event);
                    alert('Event: ' + info.event.title);
                },
                height: 'auto', // Automatically adjusts the calendar height
                contentHeight: 'auto', // Dynamically adjusts content height
                scrollTime: '08:00:00', // Scroll to 8 AM on load
                slotMinTime: '08:00:00', // Start displaying time slots at 8 AM
                slotMaxTime: '24:00:00', // End displaying time slots at 12 AM
            });

            // Render the calendar
            fullCalendar.render();
            console.log('FullCalendar rendered successfully.');
        });
    </script>

    <!-- Custom CSS -->
    <style>
        body, #fullCalendar .fc-header-toolbar, #fullCalendar .fc-daygrid-day, #fullCalendar .fc-timegrid-axis, #fullCalendar .fc-event {
            font-family: 'Cormorant Garamond', serif !important;
        }

        #fullCalendar .fc-header-toolbar {
            font-size: 0.8rem;
        }

        #calendarContainer {
            max-height: 400px; /* Ensures the calendar container has a fixed height */
            overflow-y: auto; /* Enables vertical scrolling for the calendar */
        }

        #fullCalendar .fc-col-header-cell {
            background-color: rgb(214, 190, 146);
            color: rgb(11, 26, 55); /* Navy text for headers */
        }

        #fullCalendar .fc-daygrid-day,
        #fullCalendar .fc-timegrid-axis,
        #fullCalendar .fc-event {
            font-size: 0.8rem;
        }
    </style>
</x-layout>
