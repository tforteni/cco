<p>Hello {{ $appointment->user->name }},</p>

<p>We're reaching out to let you know that your appointment with {{ $appointment->braider->user->name }} on <strong>{{ \Carbon\Carbon::parse($appointment->start_time)->format('M d, Y \a\t h:i A') }}</strong> has been cancelled by the stylist.</p>

<p>We're sorry for the inconvenience. Please feel free to rebook with another available time.</p>

<p>— COCO Team</p>
