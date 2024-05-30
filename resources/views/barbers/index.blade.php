@extends('layouts.app')

@section('content')
<h1>Dashboard Barber</h1>

<h2>Bookingan Saya</h2>
<table>
    <thead>
        <tr>
            <th>Invoice</th>
            <th>Tanggal Booking</th>
            <th>Service</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->invoice_number }}</td>
                <td>{{ $booking->booking_date }}</td>
                <td>{{ $booking->service->name }}</td>
                <td>{{ $booking->total_price }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h2>Set Schedule</h2>
<form action="{{ route('barber.setSchedule') }}" method="POST">
    @csrf
    <label for="available_date">Tanggal dan Jam Tersedia:</label>
    <input type="datetime-local" name="available_date" id="available_date" required>
    <button type="submit">Set</button>
</form>

<h2>Set Price</h2>
<form action="{{ route('barber.setPrice') }}" method="POST">
    @csrf
    <label for="price">Harga:</label>
    <input type="number" name="price" id="price" required>
    <button type="submit">Set</button>
</form>
@endsection
