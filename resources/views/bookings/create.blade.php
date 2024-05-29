@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Booking</h1>
    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="barber" class="form-label">Choose Barber</label>
            <select name="barber_id" id="barber" class="form-select" required>
                @foreach($barbers as $barber)
                    <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="booking_time" class="form-label">Choose Time</label>
            <input type="datetime-local" name="booking_time" id="booking_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Book</button>
    </form>
</div>
@endsection
