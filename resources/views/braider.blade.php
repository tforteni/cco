<x-layout>
    <!-- Header Section -->
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
        <div class="flex flex-col items-center text-tahini bg-light-navy rounded-md border-dark-tahini border-2 p-4" style="background-color: #121a26;"
            <p class="text-xl font-semibold">Reviews</p> 
     

        @if ($braider->user->reviewsReceived->count())
            @foreach ($braider->user->reviewsReceived as $review)
                <div class="mb-4">
                    <p class="font-bold">{{ $review->user->name }} says:</p>
                    <p class="border-l-4 border-dark-tahini pl-4 italic">"{{ $review->comment }}"</p>
                    <p class="text-sm text-gray-400 mt-1">Rating: {{ $review->rating }}/10</p>

                    @if ($review->media1 || $review->media2 || $review->media3)
                        <div class="flex space-x-2 mt-2">
                            @foreach (['media1', 'media2', 'media3'] as $media)
                                @if ($review->$media)
                                    <img src="{{ asset('storage/' . $review->$media) }}" alt="Review Image"
                                        class="h-16 w-16 object-cover rounded border">
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <p class="text-gray-400">No reviews yet — book an appointment to be among the first to share your experience!</p>
        @endif
        </div>
    </div>

    <!-- Modal for Booking Appointment -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Book Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm">
                        <p>Do you want to book this slot?</p>
                        <input type="hidden" id="eventId" name="event_id">
                        <input type="hidden" id="startTime" name="start_time">
                        <input type="hidden" id="endTime" name="finish_time">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="saveAppointmentBtn" class="btn btn-primary">Book Appointment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar and jQuery Integration -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fullCalendarEl = document.getElementById('fullCalendar');
            const calendar = new FullCalendar.Calendar(fullCalendarEl, {
                initialView: '{{ $calendarVariation }}', // Set the initial view
                events: {!! $availabilities !!}, // Render the events
                eventClick: function (info) {
                    if (info.event.title === "Booked Appointment") {
                        alert("This slot is already booked.");
                        return;
                    }
                    
                    console.log("A/B Test Click: User clicked a slot on", '{{ $calendarVariation }}');

                    // Populate modal with event details
                    document.getElementById('eventId').value = info.event.id; // Set the unique ID
                    document.getElementById('startTime').value = info.event.startStr;
                    document.getElementById('endTime').value = info.event.endStr;
                    $('#appointmentModal').modal('show');
                },
                height: 'auto',
                contentHeight: 'auto',
                scrollTime: '08:00:00',
                slotMinTime: '08:00:00',
                slotMaxTime: '24:00:00', 
                validRange: {
                    start: new Date().toISOString().split('T')[0] // Today's date
                }
            });

            // Handle booking functionality
            document.getElementById('saveAppointmentBtn').addEventListener('click', function () {
                const eventId = document.getElementById('eventId').value;
                const startTime = document.getElementById('startTime').value;
                const endTime = document.getElementById('endTime').value;

                // AJAX request to book appointment
                $.ajax({
                    url: '/appointments',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: {{ Auth::id() }},
                        braider_id: {{ $braider->id }},
                        start_time: startTime,
                        finish_time: endTime,
                        event_id: eventId, // Send the unique event ID
                        variation: '{{ $calendarVariation }}'
                    },
                    success: function (response) {
                        // Remove only the clicked "Available" event
                        const availableEvent = calendar.getEventById(eventId);
                        if (availableEvent) availableEvent.remove();

                        // Add the "Booked Appointment" event
                        calendar.addEvent({
                            id: response.event_id,
                            title: 'Booked Appointment',
                            start: response.start_time,
                            end: response.finish_time,
                            backgroundColor: '#dc3545',
                            borderColor: '#dc3545'
                        });

                        $('#appointmentModal').modal('hide');
                        alert("Appointment booked successfully!");
                    },
                    error: function () {
                        alert("Failed to book appointment!");
                    }
                });
            });

            calendar.render();
        });
    </script>

    <!-- Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <style>
        body, #fullCalendar .fc-header-toolbar, #fullCalendar .fc-daygrid-day, #fullCalendar .fc-timegrid-axis, #fullCalendar .fc-event {
            font-family: 'Cormorant Garamond', serif !important;
            background-color:rgb(5, 15, 29);
            /* color: #f7ebcb; Set default text color for contrast */
        }

        #fullCalendar .fc-header-toolbar {
            font-size: 0.8rem;
        }

        #calendarContainer {
            max-height: 400px;
            overflow-y: auto;
        }

        #fullCalendar .fc-col-header-cell {
            background-color: rgb(214, 190, 146);
            color: rgb(2, 8, 21);
        }

        #fullCalendar .fc-daygrid-day,
        #fullCalendar .fc-timegrid-axis,
        #fullCalendar .fc-event {
            font-size: 0.8rem;
        }
    </style>
</x-layout>
