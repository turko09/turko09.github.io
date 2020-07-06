$( "#fare_compute" ).click(function() {
$("#compute_modal").modal("show")
var vehicle_type = document.getElementById('vehicle_type').value;
var distance_km = document.getElementById('distance_km').value;
var distance_minute = document.getElementById('distance_minute').value;
var source_lat = document.getElementById('source_lat').value;
var source_long = document.getElementById('source_long').value;
var radius = document.getElementById('radius').value;

	$.ajax({
	  type: "POST",
	  url: "/api/fare/compute.php",
	  data: JSON.stringify({
	    'vehicle_type': vehicle_type,
	    'distance_km': distance_km,
	    'distance_minute': distance_minute,
	    'source_lat': source_lat,
	    'source_long': source_long,
	    'radius': radius
	  }),
	  success: function (response) {
	    $(".modal-body").html("Vehicle Type: " + response['Vehicle Type'] + "<br>" 
	    	+ "Base Fare: " + response['Base Fare'] + "<br>" + "Per Km: " + response['Per KM'] + "<br>"
	    	+ "Per Minute: " + response['Per Minute'] + "<br>" + "Distance: " + response['Distance'] + "<br>"
	    	+ "Base Amount: " + response['Base Amount'] + "<br>" + "Rush Hour Surge Amount: " + response['Rush Hour Surge Amount'] + "<br>"
	    	+ "Time Surge Amount: " + response['Time Surge Amount'] + "<br>" + "Total Surge Amount: " + response['Time Surge Amount'] + "<br>"
	    	+ "Total Amount: " + response['Total Amount']);
	  },
	  error: function (response) {
	  	$(".modal-body").html("Error Message: " + response.responseJSON["message"]);

	    
	  },
	  contentType: "application/json; charset=UTF-8",
	  dataType: "json"
	});
});