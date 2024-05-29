@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Bookings</h1>
    <ul>
        @foreach($bookings as $booking)
            <li>
                {{ $booking->barber->name }} - {{ $booking->booking_time }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
