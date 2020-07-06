var mapDiv, infoWindow,directionsDisplay, directionService, marker;

var map = {
    sourcelat: 0,
    sourcelong: 0,
    destinationlat: 0,
    destinationlong: 0,

    distance: 0,
    time: 0,
    vehicleid: 0,
    drivervehicleid: 0,

    initMap: function () {
        mapDiv = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 14.562239, lng: 121.03645 },
            zoom: 15
        });
        directionsDisplay = new google.maps.DirectionsRenderer({draggeble: true});   
        infoWindow = new google.maps.InfoWindow;
     
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                marker = new google.maps.Marker({
                  position: pos,
                  map: mapDiv,
                  title: 'Hello World!'
                });

                mapDiv.setCenter(pos);
                mapDiv.setZoom(15);

                watchPicturePosition();
            }, function () {
                map.handleLocationError(true, infoWindow, mapDiv.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            map.handleLocationError(false, infoWindow, mapDiv.getCenter());
        }

        directionService = new google.maps.DirectionsService();
        google.maps.event.addDomListener(window, 'load', function() {
            new google.maps.places.SearchBox(document.getElementById('pickupId'));
            new google.maps.places.SearchBox(document.getElementById('destinationId'));
            directionsDisplay = new google.maps.DirectionsRenderer({draggeble: true}); 
        });
    },

    getLocation: function () {
        var position = null;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                marker = new google.maps.Marker({
                  position: pos,
                  map: mapDiv,
                  title: 'Hello World!'
                });

                mapDiv.setCenter(pos);
                mapDiv.setZoom(15);
            }, function () {
                map.handleLocationError(true, infoWindow, mapDiv.getCenter());
                return position;
            });
        } else {
            map.handleLocationError(false, infoWindow, mapDiv.getCenter());
            return position;
        }
    },

    searchRoute: function (source, destination) {
        var request;
        var service;
        var distance;
        var duration;
        var dvDistance;

        this.geocodeDestinationAddress(destination);
        this.geocodeOriginAddress(source);

        console.log("source:" + source);
        console.log("destination:" + destination);

        directionsDisplay.setMap(mapDiv);

        request = {
            origin: source,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        };
                
        directionService.route(request, function (response, status) {
            if(status == google.maps.DirectionsStatus.OK){
                directionsDisplay.setDirections(response);                  //Display routes on map
            }
        });

        // CALCULATE DISTANCE AND DURATION (TRAVEL TIME)
        // Calls the DistanceMatrixService method
        service = new google.maps.DistanceMatrixService();
        
        service.getDistanceMatrix(
        { 
            //assumptions in Distance and Duration calculations
            origins: [source],
            destinations: [destination],
            travelMode: google.maps.TravelMode.DRIVING,
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false
        }, function (response, status) {
            console.log(response);
            if(status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS"){
                distance = response.rows[0].elements[0].distance.value;  //****This is the calculated Distance
                duration = response.rows[0].elements[0].duration.value;  //****This is the calculated Duration
                
                map.distance = distance/1000;
                map.time = duration/60;
                
                console.log("DIS");
                console.log(map.distance);
                console.log(map.time);
               

            } else {
                alert("Unable to calculate route");
            }
        });
    },

    handleLocationError: function (browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(mapDiv);
    },

    geocodeOriginAddress: function(searchValue) {
        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({'address': searchValue}, function(results, status) {
          if (status === 'OK') {
            map.sourcelat = results[0].geometry.location.lat();
            map.sourcelong = results[0].geometry.location.lng();

            console.log(map.destinationlat);  
            console.log(map.destinationlong);  
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
    },

    geocodeDestinationAddress: function(searchValue) {
        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({'address': searchValue}, function(results, status) {
          if (status === 'OK') {
            map.destinationlat = results[0].geometry.location.lat();
            map.destinationlong = results[0].geometry.location.lng();

            console.log(map.destinationlat);  
            console.log(map.destinationlong);   
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
    },

    plotOrigin: function(searchValue){
        //PLOT ORIGIN
        //RETURN LAT, LON
        console.log(searchValue);

        return {lat: 30.58899, lon: 31.975238};
    },

    plotDestination: function(searchValue){
        //PLOT DESTINATION        
        //RETURN LAT, LON
        console.log(searchValue);
        return {lat: 3, lon: 4};
    },

    computeDistance: function(origin, dest){
        //GET DISTANCE
        //WHAT IS NEEDED TO GET THIS?
        return {dist: 3, time: 4};
    },

    plotLocation: function(pos) {  
        console.log(pos.lat);
        console.log(pos.lng);
        if(marker)
        {
            marker.setPosition(pos);
            mapDiv.setCenter(pos);
        }
    }
};



// WATCH POSITION CODES
// onSuccess Callback
//   This method accepts a `Position` object, which contains
//   the current GPS coordinates
function onSuccess(position) {
    if(map.drivervehicleid === 0)
    {
        var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };
        marker.setPosition(pos);
    }

    //mapDiv.setCenter(pos);

    if(map.vehicleid !== 0){
        $.ajax({
            type: "POST",
            url: config.apiUrl + "vehicle/setlocation.php",
            data: JSON.stringify({
                id: map.vehicleid,
                locationlat: pos.lat,
                locationlong: pos.lng
            }),
            success: function (result) {
                console.log("success");
            },
            error: function(error){         
                console.log("error");
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        }); 
    }
    else if (map.drivervehicleid !== 0){
        $.ajax({
            type: "GET",
            url: config.apiUrl + "vehicle/get.php",
            data: {
                id: map.drivervehicleid
            },
            success: function (result) {     
                var pos = {
                    lat: result['locationlat'],
                    lng: result['locationlong']
                };
                marker.setPosition(pos);
            },
            error: function(error){
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
            });   
    }
    console.log("Location update");
}

// onError Callback receives a PositionError object
function onError(error) {
    alert('code: ' + error.code + '\n' +
        'message: ' + error.message + '\n');
}

// Options: throw an error if no update is received every 30 seconds.
function watchPicturePosition() {
    return navigator.geolocation.watchPosition
        (onSuccess, onError, {
            enableHighAccuracy: true,
            timeout: 30000
        });
}