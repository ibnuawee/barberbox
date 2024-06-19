@extends('layouts2.app')

@section('content')
<div class="row g-0">
    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
        <div class="h-100">
            <img class="img-fluid h-100" src="{{asset('assets2/img/open.jpg')}}" alt="">
        </div>
    </div>
    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
        <div class="bg-secondary h-100 d-flex flex-column justify-content-center p-5">
            <p class="d-inline-flex bg-dark text-primary py-1 px-4 me-auto">Detail Booking</p>
            <h1 class="text-uppercase mb-4">Professional Barbers Are Waiting For You</h1>
            <div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <h6 class="text-uppercase mb-0">Invoice</h6>
                    <span class="text-uppercase">{{ $booking->invoice_number }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <h6 class="text-uppercase mb-0">Model Hair Cut</h6>
                    <span class="text-uppercase">{{ $booking->haircut_name }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <h6 class="text-uppercase mb-0">Nama Barber</h6>
                    <span class="text-uppercase">{{ $booking->barber->user->name }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <h6 class="text-uppercase mb-0">Tanggal Booking</h6>
                    <span class="text-uppercase">{{ $booking->booking_date }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <h6 class="text-uppercase mb-0">Gender</h6>
                    <span class="text-uppercase">{{ $booking->gender }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <h6 class="text-uppercase mb-0">Service</h6>
                    <span class="text-uppercase">{{ $booking->service->name }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <h6 class="text-uppercase mb-0">Harga</h6>
                    <span class="text-uppercase">{{ $booking->total_price }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <h6 class="text-uppercase mb-0">Service</h6>
                    <span class="text-uppercase text-primary">{{ $booking->service->name }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <h6 class="text-uppercase mb-0">Status</h6>
                    <span class="text-uppercase text-primary">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))   
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($booking->status === 'pending')
                            <p>Pending</p>
                        @elseif ($booking->status === 'confirmed')
                            <p>Confirmed</p>
                        @elseif ($booking->status === 'completed')
                            <p>Completed</p>
                            @if (is_null($booking->confirmed_at))
                                <form action="{{ route('booking.confirm', $booking->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Confirm Booking</button>
                                </form>
                            @else
                                <p>Booking confirmed by user.</p>
                            @endif
                        @elseif ($booking->status === 'success')
                            <p>Success</p>
                            {{-- <a href="{{route('rating.show')}}">Rating</a> --}}
                        @elseif ($booking->status === 'cancelled')
                            <p>Cancelled</p>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection