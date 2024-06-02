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
                <label for="barber_id">Barber:</label>
                <select name="barber_id" id="barber_id" class="form-control" required>
                    <option value="">-- Pilih Barber --</option>
                    @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}">{{ $barber->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="pria">Pria</option>
                    <option value="wanita">Wanita</option>
                </select>
            </div>

            <div class="form-group">
                <label for="service_id">Service:</label>
                <select name="service_id" id="service_id" class="form-control">
                    <option value="">-- Pilih Service --</option>
                    <!-- Options akan diisi oleh JavaScript -->
                </select>
            </div>

            <div class="form-group">
                <label for="service_price">Harga Service:</label>
                <input type="text" id="service_price" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label for="haircut_name">Nama Potongan Rambut:</label>
                <input type="text" name="haircut_name" id="haircut_name" class="form-control" required>
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
        console.log('Selected barber ID:', barberId);  // Debugging line
        if (barberId) {
            // Get available schedules
            $.ajax({
                url: '{{ route('barber.availableSchedule') }}',
                type: 'GET',
                data: { barber_id: barberId },
                success: function(data) {
                    console.log('Schedules data:', data);  // Debugging line
                    $('#booking_date').empty();
                    $('#booking_date').append('<option value="">-- Pilih Tanggal --</option>');
                    $.each(data, function(index, schedule) {
                        $('#booking_date').append('<option value="' + schedule.available_date + '">' + schedule.available_date + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching schedules:', error);
                }
            });

            // Get available services
            $.ajax({
                url: '{{ route('barber.availableServices') }}',
                type: 'GET',
                data: { barber_id: barberId },
                success: function(data) {
                    console.log('Services data:', data);  // Debugging line
                    $('#service_id').empty();
                    $('#service_id').append('<option value="">-- Pilih Service --</option>');
                    $.each(data, function(index, service) {
                        $('#service_id').append('<option value="' + service.id + '" data-price="' + service.price + '">' + service.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching services:', error);
                }
            });
        } else {
            $('#booking_date').empty();
            $('#booking_date').append('<option value="">-- Pilih Tanggal --</option>');

            $('#service_id').empty();
            $('#service_id').append('<option value="">-- Pilih Service --</option>');
        }
    });

    $('#service_id').change(function() {
        var price = $(this).find(':selected').data('price');
        $('#service_price').val(price ? price : '');
        console.log('Selected service price:', price);  // Debugging line
    });
});
</script>

    @endsection
