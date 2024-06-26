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
            
            <!-- Step 1: User Location -->
            <div class="step">
                <div class="form-group">
                    <label for="latitude">Latitude:</label>
                    <input type="text" id="latitude" name="latitude" class="form-control" required readonly>
                </div>
                <div class="form-group">
                    <label for="longitude">Longitude:</label>
                    <input type="text" id="longitude" name="longitude" class="form-control" required readonly>
                </div>
                <div id="map" style="width: 100%; height: 500px;"></div>
                <button type="button" class="btn btn-primary" id="next1">Next</button>
            </div>

            <!-- Step 2: Select Barber -->
            <div class="step" style="display:none;">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <p class="d-inline-block bg-secondary text-primary py-1 px-4">Our Barber</p>
                    <h1 class="text-uppercase">Meet Our Barber</h1>
                </div>
                <div class="row g-4" id="barberList">
                    <!-- Barbers will be loaded here by JavaScript -->
                </div>
                <button type="button" class="btn btn-secondary" id="back1">Back</button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhcKiFZUJKJqVrCQKAL_BGk2SKaCm7fxY&libraries=places&callback=initMap" async defer></script>
    <script>
        var barbers = @json($barbers);

        function initMap() {
            var defaultLocation = { lat: -6.200000, lng: 106.816666 }; // Jakarta as default
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: defaultLocation
            });
            var marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    marker.setPosition(pos);
                    document.getElementById('latitude').value = pos.lat;
                    document.getElementById('longitude').value = pos.lng;
                });
            }
        }

        $(document).ready(function() {
            var currentStep = 0;
            var steps = $(".step");

            function showStep(step) {
                steps.hide();
                $(steps[step]).show();
            }

            function calculateDistance(lat1, lng1, lat2, lng2) {
                var p = 0.017453292519943295;    // Math.PI / 180
                var c = Math.cos;
                var a = 0.5 - c((lat2 - lat1) * p)/2 + 
                        c(lat1 * p) * c(lat2 * p) * 
                        (1 - c((lng2 - lng1) * p))/2;

                return 12742 * Math.asin(Math.sqrt(a)); // 2 * R; R = 6371 km
            }

            $("#next1").click(function() {
                var userLat = parseFloat($("#latitude").val());
                var userLng = parseFloat($("#longitude").val());

                if (!isNaN(userLat) && !isNaN(userLng)) {
                    var sortedBarbers = barbers.map(function(barber) {
                        var distance = calculateDistance(userLat, userLng, barber.latitude, barber.longitude);
                        barber.distance = distance;
                        return barber;
                    }).sort(function(a, b) {
                        return a.distance - b.distance;
                    });

                    $('#barberList').empty();
                    $.each(sortedBarbers, function(index, barber) {
                        var barberHtml = `
                            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="team-item">
                                    <div class="team-img position-relative overflow-hidden">
                                        <img class="img-fluid" src="{{ asset('storage/') }}/${barber.user.profile}" alt="Image">
                                        <div class="team-social">
                                            <a class="btn btn-primary" href="{{ route('barber.profile', '') }}/${barber.id}">view profile</a>
                                        </div>
                                    </div>
                                    <div class="bg-secondary text-center p-4">
                                        <h5 class="text-uppercase">${barber.user.name}</h5>
                                        <button type="button" class="btn btn-primary select-barber" data-barber-id="${barber.id}">Pilih</button>
                                    </div>
                                </div>
                            </div>`;
                        $('#barberList').append(barberHtml);
                    });

                    currentStep++;
                    showStep(currentStep);
                } else {
                    alert('Please select a valid location');
                }
            });

            $(document).on('click', '.select-barber', function() {
                var barberId = $(this).data('barber-id');
                $("#selected_barber_id").val(barberId);
                currentStep++;
                showStep(currentStep);

                $.ajax({
                    url: '{{ route('barber.availableSchedule') }}',
                    type: 'GET',
                    data: {
                        barber_id: barberId
                    },
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

                $.ajax({
                    url: '{{ route('barber.availableServices') }}',
                    type: 'GET',
                    data: {
                        barber_id: barberId
                    },
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

            $("#back1").click(function() {
                currentStep--;
                showStep(currentStep);
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
