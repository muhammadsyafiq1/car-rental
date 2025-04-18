@extends('layouts.app')

@section('content')
<h3>✅ Booking Confirmed</h3>

<ul class="list-group">
    <li class="list-group-item"><strong>Car:</strong> {{ $booking->car->brand }} - {{ $booking->car->name }}</li>
    <li class="list-group-item"><strong>Start:</strong> {{ $booking->start_date }}</li>
    <li class="list-group-item"><strong>End:</strong> {{ $booking->end_date }}</li>
    <li class="list-group-item"><strong>Total:</strong> ${{ $booking->total_price }}</li>
    <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($booking->status) }}</li>
</ul>

<a href="{{ route('cars.index') }}" class="btn btn-link mt-3">⬅ Back to Cars</a>
@endsection
