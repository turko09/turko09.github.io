$( "#fare_update" ).click(function() {

var id = document.getElementById('id').value;
var vehicle_type = document.getElementById('vehicle_type').value;
var base_fare = document.getElementById('base_fare').value;
var per_km = document.getElementById('per_km').value;
var per_minute = document.getElementById('per_minute').value;
var surge_rush_threshold = document.getElementById('surge_rush_threshold').value;
var surge_rush_multiplier = document.getElementById('surge_rush_multiplier').value;
var surge_time_multiplier = document.getElementById('surge_time_multiplier').value;

	$.ajax({
	  type: "POST",
	  url: "/api/fare/update.php",
	  data: JSON.stringify({
	  	'id': id,
	    'vehicle_type': vehicle_type,
	    'base_fare': base_fare,
	    'per_km': per_km,
	    'per_minute': per_minute,
	    'surge_rush_threshold': surge_rush_threshold,
	    'surge_rush_multiplier': surge_rush_multiplier,
	    'surge_time_multiplier': surge_time_multiplier
	  }),
	  success: function (response) {
	    alert("Successful Message:" + response["message"] + ". ID: " + response["id"]);
	  },
	  error: function (response) {
	    console.log(response);
	    alert("Error Message: " + response.responseJSON["message"]);
	  },
	  contentType: "application/json; charset=UTF-8",
	  dataType: "json"
	});
});
var id = document.getElementById('id').value;


$.getJSON( "/api/fare/get.php?id=" + id, function( data ) {
 document.getElementById("vehicle_type").value = data['vehicle_type'];
 document.getElementById("per_km").value = data['per_km'];
 document.getElementById("per_minute").value = data['per_minute'];
 document.getElementById("base_fare").value = data['base_fare'];
 document.getElementById("surge_rush_threshold").value = data['surge_rush_threshold'];
 document.getElementById("surge_rush_multiplier").value = data['surge_rush_multiplier'];
 document.getElementById("surge_time_multiplier").value = data['surge_time_multiplier'];
  });