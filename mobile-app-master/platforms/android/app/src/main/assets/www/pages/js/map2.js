<script>
		var source, destination;
		var directionsDisplay;
		var directionsService;
		var initialLocation;
		var mapOptions;
		var lat;
		var lng;
		var myLocation;
		var marker;
		var map;
		var myCircle;
		var infowindow;
		var pos;
		var icon;

		//------------------------------------------------------------------------------------------------
		//autoload map, center on initial coordinates
	
		initialLocation = new google.maps.LatLng(14, 121);			
		mapOptions = {
			zoom: 7,
			center: initialLocation
		};			
		map = new google.maps.Map(document.getElementById('dvMap'), mapOptions);	//Display the map here			
	
		//------------------------------------------------------------------------------------------------
		// Get my current location, this is using HTML5 geolocation features
		if (navigator.geolocation){
			navigator.geolocation.getCurrentPosition(
				function(position) {
					lat = position.coords.latitude; 	//****Current location latitude
					lng = position.coords.longitude; 	//****Current location longitude
					myLocation = new google.maps.LatLng(lat, lng);

					//------------------------------------------------------------------------------------------------
					// This convert the coordinates of the current location to address (string)
					var google_maps_geocoder = new google.maps.Geocoder();
				
					google_maps_geocoder.geocode(
						{ 'latLng': myLocation },
						function( results, status ) {
							if ( status == google.maps.GeocoderStatus.OK && results[0] ) {
								document.getElementById('addressHere').innerHTML = 'My Address: ' + results[0].formatted_address;
								
								document.getElementById('orig').value = results[0].formatted_address;	// Use address of current locaiton as default value for origin
								document.getElementById('dest').value = results[0].formatted_address;	// Use address of current locaiton as default value for destination
							}
						}
					);					
					//------------------------------------------------------------------------------------------------
					
					map.setCenter(myLocation);			//Put location in center of map
					map.setZoom(16);
					document.getElementById('locationHere').innerHTML = 'My Latitude: ' + lat + '<br>' + 'My Longitude: ' + lng + '<br>';

					//insert marker at location of user
					marker = new google.maps.Marker({
					position: myLocation,
					map: map,
					title: 'My Current Location'
					});

				}			
			);		
		}		

		//------------------------------------------------------------------------------------------------
		//create an instance of the DirectionServices Services
		directionService = new google.maps.DirectionsService();
		
		google.maps.event.addDomListener(window, 'load', function() {
			new google.maps.places.SearchBox(document.getElementById('orig'));
			new google.maps.places.SearchBox(document.getElementById('dest'));
			directionsDisplay = new google.maps.DirectionsRenderer({draggeble: true});	//Create an instance of object to display routes
		});

		//------------------------------------------------------------------------------------------------
		function GetRoute(){
			var request;
			var service;
			var distance;
			var duration;
			var dvDistance;
			
			//------------------------------------------------------------------------------------------------
			// CALCULATE BEST ROUTE
			// calls the DistanceMatrixService method			
			directionsDisplay.setMap(map);
			directionsDisplay.setPanel(document.getElementById('dvPanel'));		//Display the directions here
					
			source = document.getElementById('orig').value; 				//takes Origin input from Passenger
			destination = document.getElementById('dest').value;		//takes Destination input from Passenger
			
			request = {
				origin: source,
				destination: destination,
				travelMode: google.maps.TravelMode.DRIVING
			};
					
			directionService.route(request, function (response, status) {
				if(status == google.maps.DirectionsStatus.OK){
					directionsDisplay.setDirections(response);					//Display routes on map
				}
			});
			
			// Display the encoded / selected addresses
			// TESTING
			document.getElementById("fromAddress").innerHTML = source;
			document.getElementById("toAddress").innerHTML = destination;
			
			//------------------------------------------------------------------------------------------------
			// CALCULATE DISTANCE AND DURATION (TRAVEL TIME)
			// Calls the DistanceMatrixService method
			service = new google.maps.DistanceMatrixService();
			
			service.getDistanceMatrix({ //assumptions in Distance and Duration calculations
				origins: [source],
				destinations: [destination],
				travelMode: google.maps.TravelMode.DRIVING,
				unitSystem: google.maps.UnitSystem.METRIC,
				avoidHighways: false,
				avoidTolls: false
			}, function (response, status) {
				if(status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS"){
					distance = response.rows[0].elements[0].distance.text;	//****This is the calculated Distance
					duration = response.rows[0].elements[0].duration.text;	//****This is the calculated Duration
					
					// Display the calculated distance and time
					// TESTING
					document.getElementById("tripDistance").innerHTML = distance;
					document.getElementById("tripTime").innerHTML = duration;					
												
					dvDistance = document.getElementById('dvDistance');		//Display Distance and Duration here
					
					dvDistance.innerHTML = "";
					dvDistance.innerHTML += "Distance: " + distance + "<br>";
					dvDistance.innerHTML += "Duration: " + duration;

				} else {
					alert("Unable to calculate route");
				}
			});
		}
	</script>