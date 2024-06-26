<!DOCTYPE html>
<html>
<head>
    <title>Update Location</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhcKiFZUJKJqVrCQKAL_BGk2SKaCm7fxY&libraries=places&callback=initMap" async defer></script>
</head>
<body>
    <div class="container">
        <form action="{{ route('barber.updateLocation') }}" method="POST">
            @csrf
            <label for="latitude">Latitude:</label>
            <input type="text" id="latitude" name="latitude" required readonly>
            <label for="longitude">Longitude:</label>
            <input type="text" id="longitude" name="longitude" required readonly>
            <button type="submit">Update Location</button>
        </form>

        <div id="map" style="width: 100%; height: 500px;"></div>
    </div>

    <script>
        function initMap() {
            // Default location (center of the map)
            var defaultLocation = { lat: -6.200000, lng: 106.816666 }; // Example: Jakarta

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: defaultLocation
            });

            var marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true
            });

            // Update latitude and longitude values when marker is dragged
            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            // Update marker position when map is clicked
            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            // Optional: Center map to current location
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
    </script>
</body>
</html>
