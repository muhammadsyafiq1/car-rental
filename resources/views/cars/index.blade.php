@extends('layouts.app')

@section('content')
<form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
        <input name="brand" class="form-control" placeholder="Brand (e.g. Toyota)" value="{{ request('brand') }}">
    </div>
    <div class="col-md-3">
        <input name="min_price" class="form-control" type="number" placeholder="Min Price" value="{{ request('min_price') }}">
    </div>
    <div class="col-md-3">
        <input name="max_price" class="form-control" type="number" placeholder="Max Price" value="{{ request('max_price') }}">
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<table class="table table-bordered bg-white">
    <thead>
        <tr>
            <th>Brand</th>
            <th>Name</th>
            <th>Price/Day</th>
            <th>Status</th>
            <th>Booking</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cars as $car)
        <tr>
            <td>{{ $car->brand }}</td>
            <td>{{ $car->name }}</td>
            <td>${{ $car->price_per_day }}</td>
            <td>{{ ucfirst($car->availability_status) }}</td>
            <td>
                @if($car->availability_status === 'available')
                <a href="{{ route('bookings.form', $car->id) }}" class="btn btn-success btn-sm">Book</a>
                @else
                <button class="btn btn-secondary btn-sm" disabled>Unavailable</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
