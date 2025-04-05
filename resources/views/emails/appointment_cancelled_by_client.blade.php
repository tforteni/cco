<!DOCTYPE html>
<html>
<head>
    <title>An Appointment Cancelled by Client</title>
</head>
<body>
    <h2>Hi {{ $appointment->braider->user->name }},</h2>

    <p>
        The appointment scheduled for <strong>{{ $appointment->start_time->format('F j, Y g:i A') }}</strong> 
        with <strong>{{ $appointment->user->name }}</strong> has been cancelled by the client.
    </p>

    <p>If you have any questions, feel free to reach out to them or your admin dashboard for more info.</p>

    <br>
    <p>— COCO Team</p>
</body>
</html>
