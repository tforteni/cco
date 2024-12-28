<!DOCTYPE html>
<html>
<head>
    <title>COCO New Appointment Booked</title>
</head>
<body>
    <h1>New Appointment Alert</h1>
    <p>Dear {{ $appointment->braider->user->name }},</p>
    <p>A new appointment has been booked by {{ $appointment->user->name }}.</p>
    <p><strong>Date:</strong> {{ $appointment->start_time }}</p>
    <p><strong>Duration:</strong> {{ $appointment->finish_time }}</p>
    <p>Thank you for your service!</p>
</body>
</html>
