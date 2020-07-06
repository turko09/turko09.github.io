<?php
session_start();
if (!isset($_SESSION["admin_id"]) || !isset($_SESSION["admin_name"]))
{
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

		<?php include_once("layouts/dashboard.header.php") ?>

		<link rel="stylesheet" href="../app/assets/stylesheets/datatables.min.css">
	</head>
	<body class="login-page">
		<?php include_once("layouts/dashboard.navigation.php") ?>
		<script src="../app/assets/js/datatables.min.js"></script>
	    <div class="container-fluid">
	      <div class="row">
	      	<?php include_once("layouts/dashboard.sidebar.php") ?>
	        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
						<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2">
							<h1 class="h2"><span class="fa fa-fw fa-users"></span> Passengers</h1>
								<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
								</div>
						</div>
						<div class="table-responsive" id="passenger_preview">
						</div>
						<div class="table-responsive" id="passenger_list">
							<table class="table table-striped table-sm" id="passengers_table">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Email</th>
										<th>Mobile</th>
										<th>Verified</th>
										<th>Blocked</th>
										<th>Active</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody id="passengers_tbl">
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
	load_passengers();
	id = getQueryParam('id');
	if (id !== '') {
		get_passenger(id);
	}
});

var getQueryParam = function (param) {
    var result = window.location.search.match(
        new RegExp("(\\?|&)" + param + "(\\[\\])?=([^&]*)")
    );
    return result ? result[3] : '';
}

function load_passengers() {
	$('#passengers_tbl').empty();
  $.ajax({
    url: "/api/passenger/get.php",
    success: function (response) {
    	ct=0;
    	$.each(response, function(k, data) {
    		stat = '<span class="btn-success btn-sm" href="#" role="button">Active</span>';
    		blocked = '<span class="btn-danger btn-sm" href="#" role="button">Blocked</span>';
    		verified = '<span class="btn-success btn-sm" href="#" role="button">Verified</span>';
    		if(data.active == 0) stat = '<span class="btn-danger btn-sm" href="#" role="button">Inactive</span>';
    		if(data.blocked == 0) blocked = '<span class="btn-success btn-sm" href="#" role="button">Not Blocked</span>';
    		if(data.verified == 0) verified = '<span class="btn-danger btn-sm" href="#" role="button">Not Verified</span>';

    		$('#passengers_tbl').append('<tr>'+
				'<td>'+data.id+'</td>'+
				'<td>'+data.firstname+' ' +data.lastname+'</td>'+
				'<td>'+data.email+'</td>'+
				'<td>'+data.mobile+'</td>'+
				'<td>'+verified+'</td>'+
				'<td>'+blocked+'</td>'+
				'<td>'+stat+'</td>'+
				'<td>'+
					'<button class="btn btn-sm btn-default" onclick="get_passenger('+data.id+')" title="View Record" data-toggle="tooltip">'+
						'<span class="fa fa-eye"></span> '+
					'</button>'+
					'<button class="btn btn-sm btn-default" onclick="update_stats('+data.id+')" title="Update Status" data-toggle="tooltip">'+
						'<span class="fa fa-user"></span> '+
					'</button>'+
					'<button class="btn btn-sm btn-default" onclick="delete_passenger('+data.id+')" title="Delete Record" data-toggle="tooltip">'+
						'<span class="fa fa-trash"></span>'+
					'</button>'+

				'</td>'+
			'</tr>');
    		
		});

		$('#passengers_table').DataTable({
          "paging": true,
          "bFilter": true
        });
    },
    error: function (response) {
	 alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};
function update_stats(id) {
  $.ajax({
    url: "/api/passenger/get.php?id=" + id,
    success: function (response) {
		response = response[0];
        $('#passenger_preview').html('<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">Update passenger Status</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
	            '<div class="col-md-12">'+
	            	'<div class="row">'+
		            	'<div class="col-md-4">'+
			                '<label>Name</label><br>'+
			                '<h6>'+response.firstname+' ' +response.lastname+'</h6>'+ 
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Mobile</label><br>'+
			                '<h6>'+response.mobile +'</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Panic Mobile</label><br>'+
			                '<h6>'+response.panicmobile +'</h6>'+
		                '</div>'+
		            '</div><br>'+
		            '<div class="row">'+
		                '<div class="col-md-4">'+
			                '<label>Verified</label><br>'+
			                '<select class="form-control" id="verified">'+
			                 	'<option value="0">Not Verified</option>'+
			                 	'<option value="1">Verified</option>'+
			                '</select>'+
		                '</div>'+
		                 '<div class="col-md-4">'+
			                '<label>Is Blocked</label><br>'+
			                '<select class="form-control" id="blocked">'+
			                 	'<option value="0">Not Blocked</option>'+
			                 	'<option value="1">Blocked</option>'+
			                '</select>'+
		                '</div>'+

		                '<div class="col-md-4">'+
			                '<label>Active</label><br>'+
			                '<select class="form-control" id="active">'+
			                 	'<option value="0">Inactive</option>'+
			                 	'<option value="1">Active</option>'+
			                '</select>'+
		                '</div>'+
			            '<div class="col-md-12" style="margin-top:10px;">'+
			            	'<div style="float:right">'+
				            '<button style="margin-right:10px;" onclick="go_update_stats('+response.id+');" class="btn btn-sm btn-primary">Submit</button>'+
				            '<button onclick="$(\'#passenger_preview\').empty();" class="btn btn-sm btn-default">Close</button>'+
				            '</div>'+
			            '</div>'+
		            '</div>'+
		            '<hr>'+
	            '</div>'+
            '</div>'+
            '<br>'+
        '</div>');
        $('#active').val(response.active);
		$('#verified').val(response.verified);
		$('#blocked').val(response.blocked);
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};

function get_passenger(id) {  
  $.ajax({
    url: "/api/passenger/get.php?id=" + id,
    async:false,
    success: function (response) {
		response = response[0];
        view = '<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">View Passenger</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
	            '<div class="col-md-12">'+
	            	'<div class="row">'+
		            	'<div class="col-md-3">'+
			                '<label>Name</label><br>'+
			                '<h6>'+response.firstname+' '+ response.lastname +'</h6>'+
		                '</div>'+
		                '<div class="col-md-3">'+
			                '<label>Mobile</label><br>'+
			                '<h6>'+response.mobile +'</h6>'+
		                '</div>'+
		                '<div class="col-md-3">'+
			                '<label>Panic Mobile</label><br>'+
			                '<h6>'+response.panicmobile +'</h6>'+
		                '</div>'+
		                '<div class="col-md-3">'+
			                '<label>Email</label><br>'+
			                '<h6>'+response.email +'</h6>'+
		                '</div>'+
		            '</div><br>'+
		            '<div class="row">'+
		                '<div class="col-md-3">'+
			                '<label>Address</label><br>'+
			                '<h6>'+response.address +'</h6>'+
		                '</div>'+
		                '<div class="col-md-3">'+
			                '<label>Creditcard Number</label><br>'+
			                '<h6>'+response.creditcardnumber +'</h6>'+
		                '</div>'+
		                '<div class="col-md-3">'+
			                '<label>Date Created</label><br>'+
			                '<h6>'+response.datecreated +'</h6>'+
		                '</div>'+
		                '<div class="col-md-3">'+
			                '<label>Last Modified</label><br>'+
			                '<h6>'+response.datemodified +'</h6>'+
		                '</div>'+
		            '</div><br>'+		            
				'</div>'+
			'</div>'+
			'<hr>'+
		'</div>';
        $('#passenger_preview').html(view);
         
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};

function go_update_stats(id){
	var active = $('#active').val();
    var verified = $('#verified').val();
    var blocked = $('#blocked').val();
	$.ajax({
     type: "POST",
     url: "/api/passenger/updatestatus.php",
     data:JSON.stringify({
        id: id,
        active: active,
		verified: verified,
		blocked: blocked
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
}

function godelete(id) {
	$.ajax({
     type: "POST",
     url: "/api/passenger/delete.php",
     data:JSON.stringify({
        id: id,
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
}
function delete_passenger(id) {
  $.ajax({
    url: "/api/passenger/get.php?id=" + id,
    success: function (response) {
		response = response[0];
        $('#passenger_preview').html('<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">Delete Passenger</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
	            '<div class="col-md-12">'+
		                '<center>'+
			                '<h4>Are you sure you want do delete '+response.firstname+' '+ response.lastname +' ?</h4><br>'+
			                	'<button onclick="godelete('+response.id+');" style="margin-right:10px" class="btn btn-md btn-danger">Yes</button>'+
			                	'<button onclick="$(\'#passenger_preview\').empty();" class="btn btn-md btn-default">No</button>'+
			            '</center>'+
	            '</div>'+
            '</div>'+
            '<br>'+
        '</div>');
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};
</script>
