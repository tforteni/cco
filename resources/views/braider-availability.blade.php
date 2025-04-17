<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="font-family: 'Cormorant Garamond', serif; color: #e5e5e5;">
            {{ __('Manage Availability') }}
        </h2>
    </x-slot>

    <!-- Import Additional Styles -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Main Content Container -->
    <div class="pt-20 max-w-7xl mx-auto sm:px-6 lg:px-8" style="background-color: #121a26;">
        <!-- Page Title -->
        <div class="bg-light-navy p-6 rounded-lg shadow-md text-center" style="background-color: #121a26;">
            <h3 class="text-3xl font-semibold text-tahini" style="font-family: 'Cormorant Garamond', serif;">
                {{ __('Manage Your Availability as a Stylist') }}
            </h3>
        </div>

        <!-- Calendar -->
        <div id="calendar" class="mt-8 rounded-lg shadow p-4" style="background-color: #121a26;"></div>

        <!-- Modal for Setting Availability -->
        <div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color: #121a26; color: #f7ebcb;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="availabilityModalLabel">{{ __('Set Availability') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="availabilityForm">
                            @csrf <!-- CSRF Token -->
                            <div class="mb-3">
                                <label for="availability_type" class="form-label">{{ __('Availability Type') }}</label>
                                <select id="availability_type" name="availability_type" class="form-select">
                                    <option value="one_time">{{ __('One-Time') }}</option>
                                    <option value="recurring">{{ __('Recurring') }}</option>
                                </select>
                            </div>
                            <div class="mb-3" id="recurrenceOptions" style="display: none;">
                                <label for="recurrence" class="form-label">{{ __('Repeat every...') }}</label>
                                <select id="recurrence" name="recurrence" class="form-select">
                                    <option value="none">{{ __('Does not repeat') }}</option>
                                    <option value="daily">{{ __('Daily (for 5 days)') }}</option>
                                    <option value="weekly">{{ __('Weekly (for 4 weeks)') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">{{ __('Location') }}</label>
                                <input type="text" class="form-control" id="location" name="location" placeholder="Enter location">
                            </div>
                            <input type="hidden" id="start_time" name="start_time" value="">
                            <input type="hidden" id="end_time" name="end_time" value="">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Save Availability') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                selectable: true,
                slotMinTime: '08:00:00',
                slotMaxTime: '24:00:00',
                validRange: {
                start: new Date().toISOString().split('T')[0] // Today's date
                },
                events: @json($availabilities).length > 0 
                    ? @json($availabilities).map(event => ({
                        id: event.id,
                        title: event.title,
                        start: event.start,
                        end: event.end,
                        backgroundColor: event.backgroundColor,
                        borderColor: event.borderColor,
                    }))
                    : [],
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
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function () {
                                info.event.remove();
                                alert('{{ __('Availability deleted successfully.') }}');
                            },
                            error: function () {
                                alert('{{ __('Failed to delete availability.') }}');
                            },
                        });
                    }
                },
            });

            calendar.render();

            $('#availabilityForm').on('submit', function (e) {
                e.preventDefault();

                // Overlap validation
                let start = $('#start_time').val();
                let end = $('#end_time').val();

                let isOverlapping = calendar.getEvents().some(event => {
                    return event.title === 'Available' && (
                        (start >= event.start && start < event.end) ||
                        (end > event.start && end <= event.end) ||
                        (start <= event.start && end >= event.end)
                    );
                });

                if (isOverlapping) {
                    alert("This slot overlaps with an existing availability.");
                    return;
                }

                $.ajax({
                    url: '/availabilities',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        calendar.addEvent({
                            id: response.id,
                            title: 'Available' + (response.location ? ' - ' + response.location : ''),
                            start: response.start_time,
                            end: response.end_time,
                            backgroundColor: '#28a745',
                            borderColor: '#28a745',
                        });
                        var modal = bootstrap.Modal.getInstance(document.getElementById('availabilityModal'));
                        modal.hide();
                        toastr.success('{{ __('Availability saved successfully.') }}');
                    },
                    error: function () {
                        alert('{{ __('Failed to save availability.') }}');
                    },
                });
            });
            // Show recurrence dropdown only if "Recurring" is selected
            $('#availability_type').on('change', function () {
                if ($(this).val() === 'recurring') {
                    $('#recurrenceOptions').show();
                } else {
                    $('#recurrenceOptions').hide();
                    $('#recurrence').val('none'); // reset selection
                }
            });

        });
    </script>

	<style>
		#calendar .fc-view-harness, #calendar .fc-header-toolbar {
			font-family: 'Cormorant Garamond', serif !important;
            background-color: #121a26 !important;
			color: #f7ebcb;
		}
	</style>
</x-layout>
