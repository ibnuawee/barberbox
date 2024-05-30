@extends('layouts.app')

@section('content')
<h1>Detail Booking</h1>
<p>Invoice: {{ $booking->invoice_number }}</p>
<p>Model Hair Cut: {{ $booking->haircut_name }}</p>
<p>Nama Barber: {{ $booking->barber->user->name }}</p>
<p>Tanggal Booking: {{ $booking->booking_date }}</p>
<p>Gender: {{ $booking->gender }}</p>
<p>Service: {{ $booking->service->name }}</p>
<p>Harga: {{ $booking->total_price }}</p>
@endsection