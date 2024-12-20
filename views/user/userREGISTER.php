<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="...; font-src 'self' https://cdnjs.cloudflare.com https://kit.fontawesome.com;">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />
    <link href='../../assets/css/userREGISTER.css' rel='stylesheet' />
    
</head>
<body>
    <div class="background">
        <img src="../../assets/images/no-bg-images/laptop1.png" class="laptop-shape first-shape" alt="laptop">
        <img src="../../assets/images/no-bg-images/laptop2.png" class="laptop-shape second-shape" alt="laptop">
    </div>
    
    <div class="registration-container">
        <h3>Create Account</h3>
        <form method="POST" action="../../backend/accountREGISTER.php" class="registration-form">
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="first_name"><i class="fas fa-user"></i> First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name"><i class="fas fa-user"></i> Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="phone_number"><i class="fas fa-phone"></i> Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" required>
            </div>
            <!-- Simplified location input HTML -->
            <div class="form-group">
                <label for="location"><i class="fas fa-map-marker-alt"></i> Location</label>
                <div class="location-group">
                    <input type="text" id="location" name="location" required readonly onclick="openModal()">
                </div>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmpassword"><i class="fas fa-lock"></i> Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword" required>
            </div>

            <button type="submit" name="register">Register</button>
        </form>
    </div>

    <div id="locationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Select Location</h2>
            <p>Please click your exact Location in the Map.</p>
            <div id="map"></div>
        </div>
    </div>

    <script src='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=pk.eyJ1IjoiaGFydm5pZ3oiLCJhIjoiY200N2QyMDE5MDQ5NDJ2cHRibGU2eHlwYyJ9.2GSazj6m341Hskil0d35JQ&libraries=places"></script>
    <script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiaGFydm5pZ3oiLCJhIjoiY200N2QyMDE5MDQ5NDJ2cHRibGU2eHlwYyJ9.2GSazj6m341Hskil0d35JQ';

    document.querySelector('form').addEventListener('submit', function(e) {
        if(document.getElementById('password').value != 
           document.getElementById('confirmpassword').value) {
            alert('Passwords do not match');
            e.preventDefault();
        }
    });

    var map;
    var marker;

    function openModal() {
        document.getElementById('locationModal').style.display = 'flex';
        setTimeout(initMap, 100); // Initialize map after modal is displayed
    }

    function closeModal() {
        document.getElementById('locationModal').style.display = 'none';
    }

    // Update the map initialization code
    function initMap() {
        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            /* center: [0, 0], */
            zoom: 2
        });

        // Create geolocate control but don't trigger automatically
        const geolocate = new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true,
                timeout: 6000
            },
            trackUserLocation: false,
            showUserLocation: true,
            showAccuracyCircle: true
        });

        map.addControl(geolocate);

        // Only trigger geolocation when modal opens
        document.getElementById('locationModal').addEventListener('shown.bs.modal', function() {
            if (window.location.protocol !== 'https:') {
                console.warn('Geolocation requires HTTPS to work on mobile devices');
            }
            // User must click the geolocate button to get location
        });

        // Rest of your existing map click handling code...
        map.on('click', function(e) {
            var lngLat = e.lngLat;
            
            if (marker) {
                marker.remove();
            }
            
            marker = new mapboxgl.Marker()
                .setLngLat(lngLat)
                .addTo(map);

            // Reverse geocode the coordinates to get place name
            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lngLat.lng},${lngLat.lat}.json?access_token=${mapboxgl.accessToken}`)
                .then(response => response.json())
                .then(data => {
                    if (data.features && data.features.length > 0) {
                        // Get the place name and set it as the input value
                        var placeName = data.features[0].place_name;
                        document.getElementById('location').value = placeName;
                    }
                });
        });
    }

    // Update setCurrentLocation function to include reverse geocoding
    function setCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                
                map.setCenter([lng, lat]);
                map.setZoom(13);
                
                if (marker) {
                    marker.remove();
                }
                
                marker = new mapboxgl.Marker()
                    .setLngLat([lng, lat])
                    .addTo(map);

                // Reverse geocode current location
                fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.features && data.features.length > 0) {
                            var placeName = data.features[0].place_name;
                            document.getElementById('location').value = placeName;
                        }
                    });
            });
        }
    }
    </script>
</body>
</html>