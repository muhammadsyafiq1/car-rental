@extends('layouts.app')

@section('content')
<h3>Book Car: {{ $car->brand }} - {{ $car->name }}</h3>

<form method="POST" action="{{ route('bookings.store') }}">
    @csrf
    <input type="hidden" name="car_id" value="{{ $car->id }}">
    <input type="hidden" name="user_id" value="1"> <!--  user coba -->

    <div class="mb-3">
        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>End Date</label>
        <input type="date" name="end_date" class="form-control" required>
    </div>
    <button class="btn btn-primary">Submit Booking</button>
</form>
@endsection
