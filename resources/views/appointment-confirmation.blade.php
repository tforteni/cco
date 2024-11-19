<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
</head>
<body>
    <h1>Appointment Confirmation</h1>
    <p>Dear {{ $appointment->user->name }},</p>
    <p>Your appointment with {{ $appointment->braider->user->name }} is confirmed.</p>
    <p><strong>Start Time:</strong> {{ $appointment->start_time }}</p>
    <p><strong>Finish Time:</strong> {{ $appointment->finish_time }}</p>
    <p><strong>Comments:</strong> {{ $appointment->comments ?? 'None' }}</p>
    <p>Thank you for using COCO!</p>
</body>
</html>
