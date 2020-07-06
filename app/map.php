<?php
session_start();
if (!isset($_SESSION["admin_id"]) || !isset($_SESSION["admin_name"]))
{
   header("location: logout.php");
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include_once "layouts/dashboard.header.php"?>    
        <meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
        <style>
        body, html {
            height: 100%;
        }
        #map {
            height: 100%;
        }
        </style>
	</head>
	<body class="login-page" >
		<?php include_once "layouts/dashboard.navigation.php"?>
	    <div class="container-fluid" style="height: 88%">
	      <div class="row" style="height: 88%">
	      	<?php include_once "layouts/dashboard.sidebar.php"?>
	        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

	          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	            <div><h1 class="h2"><span class="fa fa-fw fa-map"></span> Map</h1></div>
                <div><h1 class="h2"><a class="text-danger" href="#" onclick="location.reload()"><span class="fa fa-fw fa-sync"></a></h1></span></div>
						</div>
                        <input id="pac-input" class="form-control" type="text" placeholder="Search Place">
                        <div id="map"></div>
					</main>
				</div>
			</div>    
    <script>
      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: { lat: 14.562239, lng: 121.03645 },
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });

        var infowindow = new google.maps.InfoWindow();

        var vehicles = getVehicles();
        $.each(vehicles, function(k, vehicle) {
            var marker = new google.maps.Marker({
            position: {lat: vehicle.locationlat, lng: vehicle.locationlong},
            icon: getVehicleMarker(vehicle.active, vehicle.available),
            map: map,
            animation: google.maps.Animation.DROP,
            title: 'Vehicle ID: ' + vehicle.id
            });
            var info = 
                '<table>' +
                    '<tr><td colspan="2"><h5><span class="fa fa-fw fa-car"></span> Vehicle</h5></td></tr>' +
                    '<tr><td><strong>Driver ID:</strong></td><td>' + vehicle.driverid + '</td></tr>' +
                    '<tr><td><strong>Driver:</strong></td><td>' + vehicle.driverfirstname + ' ' + vehicle.driverlastname + '</td></tr>' +
                    '<tr><td><strong>Vehicle ID:</strong></td><td>' + vehicle.id + '</td></tr>' +
                    '<tr><td><strong>Plate No.:</strong></td><td>' + vehicle.plateno + '</td></tr>' +
                    '<tr><td><strong>Type:</strong></td><td>' + vehicle.type + '</td></tr>' +
                    '<tr><td><strong>Make:</strong></td><td>' + vehicle.make + '</td></tr>' +
                    '<tr><td><strong>Model:</strong></td><td>' + vehicle.model + '</td></tr>' +
                    '<tr><td><strong>Color:</strong></td><td>' + vehicle.color + '</td></tr>' +
                    '<tr><td><strong>On Duty:</strong></td><td>' + (vehicle.active === 1 ? 'Yes' : 'No') + '</td></tr>' +
                    '<tr><td><strong>Available:</strong></td><td>' + (vehicle.available === 1 ? 'Yes' : 'No') + '</td></tr>' +
                    '<tr><td><strong>Location:</strong></td><td>' + vehicle.locationlat + ', ' + vehicle.locationlong + '</td></tr>' +
                 '</table><br/>' +
                 '<center><button class="btn btn-sm btn-success" onclick="location.href=\'drivers.php?id=' + vehicle.driverid + '\';" title="View Driver" data-toggle="tooltip">View Driver</button></center>'
            makeInfoWindowEvent(map, infowindow, info, marker);
        });

        var tripsRequested = getTrips('Requested');
        setTripsMarkers(map, infowindow, tripsRequested, true);

        var tripsRejected = getTrips('Rejected');
        setTripsMarkers(map, infowindow, tripsRejected, false);
      }

      function setTripsMarkers(map, infowindow, trips, requested) {
        $.each(trips, function(k, trip) {
            var marker = new google.maps.Marker({
            position: {lat: trip.sourcelat, lng: trip.sourcelong},
            icon: 'assets/images/map/passenger-' + (requested ? 'orange' : 'red') + '.png',
            map: map,
            animation: google.maps.Animation.DROP,
            title: 'Trip ID: ' + trip.id
            });
            var info = 
                '<table>' +
                    '<tr><td colspan="2"><h5><span class="fa fa-fw fa-male"></span> Passenger Trip Request</h5></td></tr>' +
                    '<tr><td><strong>Trip ID:</strong></td><td>' + trip.id + '</td></tr>' +
                    '<tr><td><strong>Stage:</strong></td><td>' + (requested ? 'Requested (No driver automatically assigned)' : 'Rejected (Driver refused)') + '</td></tr>' +
                    '<tr><td><strong>From:</strong></td><td>' + trip.source + '</td></tr>' +
                    '<tr><td><strong>To:</strong></td><td>' + trip.destination + '</td></tr>' +
                    '<tr><td><strong>Passenger ID:</strong></td><td>' + trip.passengerid + '</td></tr>' +
                    '<tr><td><strong>Passenger:</strong></td><td>' + trip.passengerfirstname + ' ' + trip.passengerlastname + '</td></tr>' +                
                    '<tr><td><strong>Location:</strong></td><td>' + trip.sourcelat + ', ' + trip.sourcelong + '</td></tr>' +
                '</table><br/>' +
                '<center>' +
                    '<button class="btn btn-sm btn-success" onclick="location.href=\'trips.php?id=' + trip.id + '\';" title="View Trip Details / Assign Driver" data-toggle="tooltip">View Trip</button>&nbsp;&nbsp;&nbsp;' +
                    '<button class="btn btn-sm btn-success" onclick="location.href=\'passengers.php?id=' + trip.passengerid + '\';" title="View Passenger" data-toggle="tooltip">View Passenger</button>' +
                '</center>'
            makeInfoWindowEvent(map, infowindow, info, marker);
        });
      }

      function makeInfoWindowEvent(map, infowindow, contentString, marker) {
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(contentString);
            infowindow.open(map, marker);
        });
        }

      function getVehicleMarker(active, available) {
          if (!active) {
              return 'assets/images/map/car-gray.png';
          }
          if (!available) {
              return 'assets/images/map/car-red.png';
          }
          return 'assets/images/map/car-green.png';
      }

      function getVehicles() {
            return JSON.parse($.ajax({
                type: 'GET',
                url: "/api/vehicle/getwithdriver.php",
                contentType: "application/json; charset=UTF-8",
                dataType: 'html',
                global: false,
                async:false,
                success: function(response) {
                return response;}
            }).responseText);
        };

    function getTrips(stage) {
            return JSON.parse($.ajax({
                type: 'GET',
                url: "/api/trip/getwithpassengerdriver.php?stage=" + stage,
                contentType: "application/json; charset=UTF-8",
                dataType: 'html',
                global: false,
                async:false,
                success: function(response) {
                return response;}
            }).responseText);
        };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOnTzBRmXJM7XzmWAbE8jMWwRzAu9tEC8&libraries=places&callback=initAutocomplete"
    async defer></script>
	</body>
</html>
