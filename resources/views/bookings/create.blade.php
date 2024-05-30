@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('booking.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="pria">Pria</option>
                <option value="wanita">Wanita</option>
            </select>
        </div>

        <div class="form-group">
            <label for="service_id">Service:</label>
            <select name="service_id" id="service_id" class="form-control" required>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="haircut_name">Nama Potongan Rambut:</label>
            <input type="text" name="haircut_name" id="haircut_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="barber_id">Barber:</label>
            <select name="barber_id" id="barber_id" class="form-control" required>
                <option value="">-- Pilih Barber --</option>
                @foreach($barbers as $barber)
                    <option value="{{ $barber->id }}">{{ $barber->user->name }} - Rp{{ $barber->price }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="booking_date">Tanggal dan Jam Booking:</label>
            <select id="booking_date" name="booking_date" class="form-control" required>
                <option value="">-- Pilih Tanggal --</option>
                <!-- Options akan diisi oleh JavaScript -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Book</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#barber_id').change(function() {
        var barberId = $(this).val();
        if (barberId) {
            $.ajax({
                url: '{{ route('barber.availableSchedule') }}',
                type: 'GET',
                data: { barber_id: barberId },
                success: function(data) {
                    $('#booking_date').empty();
                    $('#booking_date').append('<option value="">-- Pilih Tanggal --</option>');
                    $.each(data, function(index, schedule) {
                        $('#booking_date').append('<option value="' + schedule.available_date + '">' + schedule.available_date + '</option>');
                    });
                }
            });
        } else {
            $('#booking_date').empty();
            $('#booking_date').append('<option value="">-- Pilih Tanggal --</option>');
        }
    });
});
</script>
@endsection
