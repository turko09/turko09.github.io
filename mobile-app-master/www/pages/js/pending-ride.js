var pendingride = {    
    tripid: 0,
    vehicleid: 0,

    initialize: function() {
        pendingride.tripid = decodeURIComponent(window.location.search.match(/(\?|&)id\=([^&]*)/)[2]);
        pendingride.bindEvents();
    },
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    onDeviceReady: function() {
        pendingride.getTrip();
    },

    getTrip: function(){
        $.ajax({
            type: "GET",
            url: config.apiUrl + "trip/get.php",
            data: {
                id: pendingride.tripid
            },
            success: function (result) { 
               pendingride.vehicleid = result["vehicleid"];
               map.drivervehicleid = pendingride.vehicleid;
               pendingride.getVehicle();
            },
            error: function(error){
                ons.notification.alert("Encountered error!");
            },
            contentType: "text/plain",
            dataType: "json"
            });   
    },

    getVehicle: function(){
        $.ajax({
            type: "GET",
            url: config.apiUrl + "vehicle/get.php",
            data: {
                id: pendingride.vehicleid
            },
            success: function (result) {  
               pendingride.updateDetails(result);
            },
            error: function(error){
                ons.notification.alert("Encountered error!");
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        });   
    },


    startTrip: function(value){
    	window.location.href = "start-trip.html?id=" + pendingride.tripid;    	
    },

    updateDetails: function(value){
    	var driverElement = document.getElementById('driverId');
        driverElement.innerHTML = value["model"];

        var vehicleElement = document.getElementById('vehicleId');
        vehicleElement.innerHTML = value["color"];

        var plateElement = document.getElementById('plateId');
        plateElement.innerHTML = value["plateno"];
    },

    cancel: function(){
    	ons.notification.confirm({
	    message: 'Are you sure you want to cancel ride?',
	    buttonLabels: ['Yes', 'No'],
	    primaryButtonIndex: 1,
	    cancelable: true,
	    callback: function (index) {
	    	if(index == 0){
	    		//UPDATETHIS
		        $.ajax({
		        type: "GET",
		        url: config.apiUrl + "driver/get.php",
		        data: JSON.stringify({
		            id:1,
		        }),
		        success: function (result) {
		            window.location.href = "ride-request.html";            
		        },
		        error: function(error){
		            ons.notification.alert("Error on request.");
		        },
		        contentType: "application/json; charset=utf-8",
		        dataType: "json"
		        });     
	    	}
	    }
	});
    },

    passengerTripStarted: function(){},

    passengerTripEnded: function(){}
};