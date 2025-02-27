<x-layout>
    <h2>Manage Your Availability</h2>
    
    <!-- Debugging: Show the CSRF token -->
    <p>CSRF Token: {{ csrf_token() }}</p>

    <!-- Calendar -->
    <div id="calendar"></div>

    <!-- Modal for setting availability -->
    <div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="availabilityModalLabel">Set Availability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="availabilityForm">
                        @csrf
                        <div class="mb-3">
                            <label for="availability_type" class="form-label">Availability Type:</label>
                            <select id="availability_type" name="availability_type" class="form-select">
                                <option value="one_time">One-Time</option>
                                <option value="recurring">Recurring</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location:</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Enter location">
                        </div>
                        <input type="hidden" id="start_time" name="start_time">
                        <input type="hidden" id="end_time" name="end_time">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Availability</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    selectable: true,
                    events: @json($availabilities).map(event => ({
                        id: event.id,
                        title: event.location ? `Available - ${event.location}` : 'Available',
                        start: event.start_time,
                        end: event.end_time,
                        backgroundColor: '#28a745',
                        borderColor: '#28a745',
                    })),
                    select: function (info) {
                        document.getElementById('start_time').value = info.startStr;
                        document.getElementById('end_time').value = info.endStr;
                        var modal = new bootstrap.Modal(document.getElementById('availabilityModal'));
                        modal.show();
                    },
                    eventClick: function (info) {
                        if (confirm('{{ __('Do you want to delete this availability?') }}')) {
                            $.ajax({
                                url: '/availabilities/' + info.event.id,
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    'Content-Type': 'application/json'
                                },
                                data: JSON.stringify({
                                    _method: 'DELETE'
                                }),
                                success: function () {
                                    info.event.remove();
                                    alert('{{ __('Availability deleted successfully.') }}');
                                },
                                error: function (xhr) {
                                    console.log(xhr.responseText);
                                    alert('{{ __('Failed to delete availability.') }}');
                                }
                            });
                        }
                    },
                });

                calendar.render();

                $('#availabilityForm').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: '/availabilities',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function (response) {
                            calendar.addEvent({
                                id: response.id,
                                title: response.location ? `Available - ${response.location}` : 'Available',
                                start: response.start_time,
                                end: response.end_time,
                                backgroundColor: '#28a745',
                                borderColor: '#28a745',
                            });
                            bootstrap.Modal.getInstance(document.getElementById('availabilityModal')).hide();
                        },
                        error: function () {
                            alert('Failed to save availability.');
                        },
                    });
                });
            });
        </script>
    @endpush
</x-layout>