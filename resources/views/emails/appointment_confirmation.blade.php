<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
</head>
<body>
    <h1>Appointment Confirmation</h1>
    <p>Dear {{ $appointment->user->name }},</p>
    <p>Your appointment with {{ $appointment->braider->user->name }} has been confirmed.</p>
    <p><strong>Date:</strong> {{ $appointment->start_time }}</p>
    <p><strong>Duration:</strong> {{ $appointment->finish_time }}</p>
    <p>Thank you for booking with us!</p>
</body>
</html>
