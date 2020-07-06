<?php
session_start();
if (!isset($_SESSION["admin_id"]) || !isset($_SESSION["admin_name"])) {
    header("location: logout.php");
}
?>


<!DOCTYPE html>
<style>
	.btn-default{
		color: #333;
	    background-color: #fff;
	    border-color: #ccc !important;
	}
</style>
<html lang="en">
	<head>

		<?php include_once "layouts/dashboard.header.php"?>

		<link rel="stylesheet" href="../app/assets/stylesheets/datatables.min.css">
	</head>
	<body class="login-page">
		<?php include_once "layouts/dashboard.navigation.php"?>
		<script src="../app/assets/js/datatables.min.js"></script>
	    <div class="container-fluid">
	      <div class="row">
	      	<?php include_once "layouts/dashboard.sidebar.php"?>
	        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
						<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2">
							<h1 class="h2"><span class="fa fa-fw fa-car"></span> Trips</h1>
								<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
								</div>
						</div>
						<div class="table-responsive" id="trip_preview">
						</div>
						<div class="table-responsive" id="trip_list">
							<table class="table table-striped table-sm" id="trips_table">
								<thead>
									<tr>
										<th>Trip ID</th>
										<th>Source</th>
										<th>Destination</th>
										<th>Date</th>
										<th>Stage</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody id="trips_tbl">
								</tbody>
							</table>
						</div>
	        </main>
	      </div>
	    </div>
	</body>
</html>

<script>
$(document).ready(function(){
	keyword = getQueryParam('keyword');
	load_trips(keyword);
	id = getQueryParam('id');
	if (id !== '') {
		get_trip(id);
	}
});

var getQueryParam = function (param) {
    var result = window.location.search.match(
        new RegExp("(\\?|&)" + param + "(\\[\\])?=([^&]*)")
    );
    return result ? result[3] : '';
}

function load_trips(keyword) {
	$('#trips_tbl').empty();
  $.ajax({
    url: "/api/trip/gethistory.php",
    success: function (response) {
    	$.each(response, function(k, data) {
    		stage = '<span class="btn btn-sm" href="#" role="button">Unknown</span>';
			assignButton = '';
    		if(data.stage == 'Requested') {
				stage = '<span class="btn-danger btn-sm" href="#" role="button">Requested</span>';
				assignButton = '<button class="btn btn-sm btn-default" onclick="get_trip('+data.id+')" title="Assign Driver / Vehicle" data-toggle="tooltip">'+
						'<span class="fa fa-user"></span> '+
					'</button>';
			}
    		if(data.stage == 'Assigned') stage = '<span class="btn-info btn-sm" href="#" role="button">Assigned</span>';
    		if(data.stage == 'Accepted') stage = '<span class="btn-info btn-sm" href="#" role="button">Accepted</span>';
    		if(data.stage == 'Rejected') {
				stage = '<span class="btn-danger btn-sm" href="#" role="button">Rejected</span>';
			}
    		if(data.stage == 'Ongoing') stage = '<span class="btn-info btn-sm" href="#" role="button">Ongoing</span>';
    		if(data.stage == 'Completed') stage = '<span class="btn-success btn-sm" href="#" role="button">Completed</span>';
    		if(data.stage == 'Cancelled') stage = '<span class="btn-warning btn-sm" href="#" role="button">Cancelled</span>';

    		$('#trips_tbl').append('<tr>'+
				'<td>'+data.id+'</td>'+
				'<td>'+data.source+'</td>'+
				'<td>'+data.destination+'</td>'+
				'<td>'+data.datecreated+'</td>'+
				'<td>'+stage+'</td>'+
				'<td>'+
					'<button class="btn btn-sm btn-default" onclick="get_trip('+data.id+')" title="View Details" data-toggle="tooltip">'+
						'<span class="fa fa-eye"></span> '+
					'</button>'+ assignButton +
				'</td>'+
			'</tr>');

		});

		$('#trips_table').DataTable({
          "paging": true,
          "bFilter": true,
		  "aaSorting": [[ 0, "desc" ]],
		  "oSearch": {"sSearch": keyword}
        });
    },
    error: function (response) {
	 alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};

function get_trip_details(id) {
	return JSON.parse($.ajax({
		type: 'GET',
        url: "/api/trip/get.php?id=" + id,
        data: JSON.stringify({
        }),
        contentType: "application/json; charset=UTF-8",
        dataType: 'html',
        global: false,
        async:false,
        success: function(response) {
        return response;}
	}).responseText);
};

function get_vehicle_details(id) {
	return JSON.parse($.ajax({
		type: 'GET',
        url: "/api/vehicle/get.php?id=" + id,
        data: JSON.stringify({
        }),
        contentType: "application/json; charset=UTF-8",
        dataType: 'html',
        global: false,
        async:false,
        success: function(response) {
        return response;}
	}).responseText);
};

function get_driver_details(id) {
	return JSON.parse($.ajax({
		type: 'GET',
        url: "/api/driver/get.php?id=" + id,
        data: JSON.stringify({
        }),
        contentType: "application/json; charset=UTF-8",
        dataType: 'html',
        global: false,
        async:false,
        success: function(response) {
        return response;}
	}).responseText);
};

function get_passenger_details(id) {
	return JSON.parse($.ajax({
		type: 'GET',
        url: "/api/passenger/get.php?id=" + id,
        data: JSON.stringify({
        }),
        contentType: "application/json; charset=UTF-8",
        dataType: 'html',
        global: false,
        async:false,
        success: function(response) {
        return response;}
	}).responseText);
};

function get_vehicles() {
                return JSON.parse($.ajax({
                        type: 'GET',
                        url: "/api/vehicle/getwithdriver.php",
                        data: JSON.stringify({
                            }),
                        contentType: "application/json; charset=UTF-8",
                        dataType: 'html',
                        global: false,
                        async:false,
                        success: function(response) {
                            return response;

                        }
                    }).responseText);
            };

function get_trip(id) {
	trip = get_trip_details(id);
	vehicle = get_vehicle_details(trip.vehicleid);
	passenger = get_passenger_details(trip.passengerid)[0];
	driver = get_driver_details(vehicle.driverid);
	assignsegment = '';

	if (trip.stage == 'Requested' || trip.stage == 'Rejected') {
		vehicles = get_vehicles();
		vehicles_dd = '<select id="vehicles_dd">';
		for(var i = 0; i < vehicles.length; i++) {
			var obj = vehicles[i];
			if (obj.active > 0 && obj.available > 0) {
				vehicles_dd = vehicles_dd +'<option value="' + obj.id + '">' + obj.type + ' | ' + obj.make + ' ' + obj.model + ' - ' + obj.color + ' (' + obj.plateno + ') | Driver: ' + obj.driverfirstname + ' ' + obj.driverlastname +'</option>';
						}
		}
		vehicles_dd = vehicles_dd + '</select>';
		assignsegment =	'<div class="row">'+
					'<div class="col-md-12">'+
						'<div class="row">'+
							'<div class="col-md-4">'+
								'<h6>Assign Trip To Available Vehicle / Driver: </h6>' +
								vehicles_dd + '<br><br>' +
								'<button class="btn btn-sm btn-success" onclick="assign_trip('+trip.id+')" title="Assign Trip" data-toggle="tooltip">Assign Trip</button>'
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>';
	}

	view = '<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">View Trip</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
	            '<div class="col-md-12">'+
	            	'<div class="row">'+
		            	'<div class="col-md-4">'+
			                '<label>Trip ID</label><br>'+
			                '<h6>'+trip.id+'</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Date</label><br>'+
			                '<h6>'+trip.datecreated+'</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Stage</label><br>'+
			                '<h6>'+trip.stage+'</h6>'+
		                '</div>'+
		            '</div><br>'+
	            	'<div class="row">'+
		            	'<div class="col-md-6">'+
			                '<label>Source</label><br>'+
			                '<h6>'+trip.source+' (' + trip.sourcelat + ', ' + trip.sourcelong + ')</h6>'+
		                '</div>'+
		                '<div class="col-md-6">'+
			                '<label>Destination</label><br>'+
			                '<h6>'+trip.destination+' (' + trip.destinationlat + ', ' + trip.destinationlong + ')</h6>'+
		                '</div>'+
		            '</div><br>'+
		            '<div class="row">'+
		                '<div class="col-md-4">'+
			                '<label>Passenger</label><br>'+
			                '<h6>'+passenger.firstname + ' ' +passenger.lastname +'</h6>'+
		                '</div>' +
		                '<div class="col-md-4">'+
			                '<label>Driver</label><br>'+
			                '<h6>'+ (trip.vehicleid > 0 ? (driver.firstname + ' ' + driver.lastname) : '-')+ '</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Amount</label><br>'+
			                '<h6>'+trip.amount +'</h6>'+
		                '</div>'+
		            '</div><br>'+
		            '<div class="row">'+
		                '<div class="col-md-4">'+
			                '<label>Vehicle</label><br>'+
			                '<h6>'+ (trip.vehicleid > 0 ? (vehicle.color + ' ' + vehicle.make + ' ' + vehicle.model) : '-') + '</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Vehicle Type</label><br>'+
			                '<h6>'+ (trip.vehicleid > 0 ? (vehicle.type) : '-')+'</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Plate No.</label><br>'+
			                '<h6>'+ (trip.vehicleid > 0 ? (vehicle.plateno) : '-') +'</h6>'+
		                '</div>'+
		            '</div><br>'+
				'</div>'+
			'</div>'+
			assignsegment +
			'<hr>'+
		'</div>';
        $('#trip_preview').html(view);
};


function assign_trip(id) {
	var e = document.getElementById("vehicles_dd");
	var vehicleid = e.options[e.selectedIndex].value;
	$.ajax({
     type: "POST",
     url: "/api/trip/assign.php",
     data:JSON.stringify({
        id: id,
        vehicleid: vehicleid
    }),
    success: function (response) {
    	location.reload();
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};
</script>
