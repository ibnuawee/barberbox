@extends('layouts2.app')

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

    <form id="multiStepForm" action="{{ route('booking.store') }}" method="POST">
        @csrf
        <input type="hidden" name="barber_id" id="selected_barber_id">
        <div class="step">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block bg-secondary text-primary py-1 px-4">Our Barber</p>
                <h1 class="text-uppercase">Meet Our Barber</h1>
            </div>
            <div class="row g-4">
                @foreach ($barbers as $barber)
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item">
                            <div class="team-img position-relative overflow-hidden">
                                <img class="img-fluid" src="{{asset('storage/' . $barber->user->profile)}}" alt="Image">
                                <div class="team-social">
                                    <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="bg-secondary text-center p-4">
                                <h5 class="text-uppercase">{{$barber->user->name}}</h5>
                                {{-- <span class="text-primary">Designation</span><br> --}}
                                <button type="button" class="btn btn-primary select-barber" data-barber-id="{{ $barber->id }}">Pilih</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="step" style="display:none;">
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="pria">Pria</option>
                    <option value="wanita">Wanita</option>
                </select>
            </div>
            <button type="button" class="btn btn-secondary" id="back2">Back</button>
            <button type="button" class="btn btn-primary" id="next2">Next</button>
        </div>

        <div class="step" style="display:none;">
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
            <button type="button" class="btn btn-secondary" id="back3">Back</button>
            <button type="button" class="btn btn-primary" id="next3">Next</button>
        </div>

        <div class="step" style="display:none;">
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
            <button type="button" class="btn btn-secondary" id="back4">Back</button>
            <button type="submit" class="btn btn-primary">Book</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var currentStep = 0;
    var steps = $(".step");

    function showStep(step) {
        steps.hide();
        $(steps[step]).show();
    }

    $(".select-barber").click(function() {
        var barberId = $(this).data('barber-id');
        $("#selected_barber_id").val(barberId);
        currentStep++;
        showStep(currentStep);

        // Get available schedules
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
    });

    $("#next2").click(function() {
        if ($("#gender").val()) {
            currentStep++;
            showStep(currentStep);
        } else {
            alert('Please select a gender');
        }
    });

    $("#next3").click(function() {
        if ($("#service_id").val()) {
            currentStep++;
            showStep(currentStep);
        } else {
            alert('Please select a service');
        }
    });

    $("#back2").click(function() {
        currentStep--;
        showStep(currentStep);
    });

    $("#back3").click(function() {
        currentStep--;
        showStep(currentStep);
    });

    $("#back4").click(function() {
        currentStep--;
        showStep(currentStep);
    });

    $("#service_id").change(function() {
        var price = $(this).find(':selected').data('price');
        $('#service_price').val(price ? price : '');
    });

    showStep(currentStep);
});
</script>
@endsection
