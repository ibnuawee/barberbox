@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Booking yang Diterima</div>
        <div class="card-body">
            @if ($bookings->isEmpty())
                <p>Tidak ada bookingan yang diterima.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Nama Pelanggan</th>
                            <th>Layanan</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->booking_date }}</td>
                                <td>{{ $booking->booking_time }}</td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->service->name }}</td>
                                <td>Rp {{ number_format($booking->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
