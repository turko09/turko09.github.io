var worker = new Worker("pages/js/worker.js");
worker.onmessage = function(event) {
	$.ajax({
	    type: "POST",
	    url: config.apiUrl + "vehicle/setlocation.php",
	    data: JSON.stringify({
	        id: driverride.vehicleid,
		    locationlat: 12.58899 + event.data,
		    locationlong: 16.975238 + event.data
	    }),
	    success: function (result) {
	        console.log("success:" + event.data);
	    },
	    error: function(error){	        
	        console.log("error:" + event.data);
	    },
	    contentType: "application/json; charset=utf-8",
	    dataType: "json"
    });   

    //alert(map.getLocation());
};