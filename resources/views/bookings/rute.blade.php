@extends('layouts2.app')

@section('content')
    <div class="container">
        <h1>Rute ke Barber</h1>
        <div id="map" style="height: 500px; width: 100%;"></div>
    </div>

    <script>
        function initMap() {
            var userLocation = { lat: {{ $user->latitude }}, lng: {{ $user->longitude }} };
            var barberLocation = { lat: {{ $barber->latitude }}, lng: {{ $barber->longitude }} };

            var map = new google.maps.Map(document.getElementById('map'), {
                center: userLocation,
                zoom: 14
            });

            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            var request = {
                origin: userLocation,
                destination: barberLocation,
                travelMode: 'DRIVING'
            };

            directionsService.route(request, function(result, status) {
                if (status == 'OK') {
                    directionsRenderer.setDirections(result);
                } else {
                    alert('Directions request failed due to ' + status);
                }
            });
        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"></script>
@endsection
