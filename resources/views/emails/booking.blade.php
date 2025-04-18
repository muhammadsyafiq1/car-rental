<body>
    <h2>Hi {{ $booking->user->name }},</h2>
    <p>Your booking has been confirmed!</p>

    <ul>
        <li><strong>Car:</strong> {{ $booking->car->brand }} - {{ $booking->car->name }}</li>
        <li><strong>Start Date:</strong> {{ $booking->start_date }}</li>
        <li><strong>End Date:</strong> {{ $booking->end_date }}</li>
        <li><strong>Total Price:</strong> ${{ $booking->total_price }}</li>
        <li><strong>Status:</strong> {{ ucfirst($booking->status) }}</li>
    </ul>

    <p>Thank you for using our service!</p>
</body>
