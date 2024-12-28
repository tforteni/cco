@extends('layouts.app2')

@section('content')
    <h2>Book a Slot with {{ $braider->user->name }}</h2>

    <div id="calendar"></div>

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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                events: {!! $availabilities !!},
                eventClick: function(info) {
                    if (info.event.title === "Booked Appointment") {
                        alert("This slot is already booked.");
                        return;
                    }

                    $('#startTime').val(info.event.startStr);
                    $('#endTime').val(info.event.endStr);
                    $('#appointmentModal').modal('show');
                }
            });

            $('#saveAppointmentBtn').click(function() {
                let start = $('#startTime').val();
                let end = $('#endTime').val();
                let braiderId = {{ $braider->id }};

                $.ajax({
                    url: '/appointments',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: {{ Auth::id() }}, // Ensure the correct user_id is sent
                        braider_id: {{ $braider->id }}, // Ensure the braider_id matches
                        start_time: $('#startTime').val(),
                        finish_time: $('#endTime').val(),
                    },
                    success: function(response) {
                        var availableEvent = calendar.getEvents().find(event => event.startStr === start && event.title === 'Available');
                        if (availableEvent) {
                            availableEvent.remove();
                        }

                        calendar.addEvent({
                            id: response.event_id,
                            title: 'Booked Appointment',
                            start: response.start_time,
                            end: response.finish_time,
                            backgroundColor: '#dc3545',
                            borderColor: '#dc3545'
                        });

                        $('#appointmentModal').modal('hide');
                        alert("Appointment booked!");
                    },
                    error: function() {
                        alert("Failed to book appointment!");
                    }
                });
            });

            calendar.render();
        });
    </script>
@endpush
