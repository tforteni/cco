<!-- resources/views/calendar/create.blade.php -->
@extends('layouts.app') <!-- or your main layout file -->

@section('content')

<form action="{{ route('calendar.availability.store') }}" method="POST" class="max-w-xl mx-auto p-6 bg-light-navy border border-dark-tahini rounded-lg shadow-lg">
    @csrf

    <!-- Date -->
    <div class="mb-4">
        <label for="date" class="block text-tahini font-semibold mb-2">Date:</label>
        <input type="date" id="date" name="date" required class="w-full bg-light-navy border-dark-tahini text-tahini focus:border-tahini focus:ring-tahini rounded-lg p-2">
    </div>

    <!-- Day -->
    <div class="mb-4">
        <label for="day" class="block text-tahini font-semibold mb-2">Day:</label>
        <select id="day" name="day" required class="w-full bg-light-navy border-dark-tahini text-tahini focus:border-tahini focus:ring-tahini rounded-lg p-2">
            <option value="monday">Monday</option>
            <option value="tuesday">Tuesday</option>
            <option value="wednesday">Wednesday</option>
            <option value="thursday">Thursday</option>
            <option value="friday">Friday</option>
            <option value="saturday">Saturday</option>
            <option value="sunday">Sunday</option>
        </select>
    </div>

    <!-- Start Time -->
    <div class="mb-4">
        <label for="start_time" class="block text-tahini font-semibold mb-2">Start Time:</label>
        <input type="time" id="start_time" name="start_time" required class="w-full bg-light-navy border-dark-tahini text-tahini focus:border-tahini focus:ring-tahini rounded-lg p-2">
    </div>

    <!-- End Time -->
    <div class="mb-4">
        <label for="end_time" class="block text-tahini font-semibold mb-2">End Time:</label>
        <input type="time" id="end_time" name="end_time" required class="w-full bg-light-navy border-dark-tahini text-tahini focus:border-tahini focus:ring-tahini rounded-lg p-2">
    </div>

    <!-- Phone Number -->
    <div class="mb-4">
        <label for="phone_number" class="block text-tahini font-semibold mb-2">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required class="w-full bg-light-navy border-dark-tahini text-tahini focus:border-tahini focus:ring-tahini rounded-lg p-2">
    </div>

    <!-- Service Details -->
    <div class="mb-4">
        <label for="service_details" class="block text-tahini font-semibold mb-2">Service Details:</label>
        <textarea id="service_details" name="service_details" required class="w-full bg-light-navy border-dark-tahini text-tahini focus:border-tahini focus:ring-tahini rounded-lg p-2"></textarea>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end">
        <button type="submit" class="bg-dark-tahini text-tahini font-semibold hover:bg-light-navy rounded-lg px-4 py-2 transition">
            Add Availability
        </button>
    </div>
</form>
<!-- Your form here -->
@endsection
