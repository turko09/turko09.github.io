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
							<h1 class="h2"><span class="fa fa-fw fa-car"></span> Vehicles</h1>
								<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
								</div>
						</div>
						<div class="table-responsive" id="vehicle_preview">
						</div>
						<div class="table-responsive" id="vehicle_list">
							<table class="table table-striped table-sm" id="vehicles_table">
								<thead>
									<tr>
										<th>#</th>
										<th>Driver</th>
										<th>Plate No</th>
										<th>Type</th>
										<th>Make</th>
										<th>Model</th>
										<th>Color</th>
										<th>Active</th>
										<th>Available</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody id="vehicles_tbl">
								</tbody>
							</table>
						</div>
			<a href="vehicle_add.php" class="float-left">
                      Add Vehicle
                    </a>
	        </main>
	      </div>
	    </div>
	</body>
</html>

<script>
$(document).ready(function(){
	load_vehicles();
});
function load_vehicles() {
	$('#vehicles_tbl').empty();
  $.ajax({
    url: "/api/vehicle/get.php",
    success: function (response) {
    	ct=0;
    	$.each(response, function(k, data) {
    		ct++;
    		stat = '<span class="btn-success btn-sm" href="#" role="button">Active</span>';
    		available = '<span class="btn-success btn-sm" href="#" role="button">Available</span>';
    		
    		if(data.active == 0) stat = '<span class="btn-danger btn-sm" href="#" role="button">Inactive</span>';
    		if(data.available == 0) available = '<span class="btn-danger btn-sm" href="#" role="button">Not Available</span>';
    		
    		$('#vehicles_tbl').append('<tr>'+
				'<td>'+ct+'</td>'+
				// '<td>'+data.firstname+' ' +data.lastname+'</td>'+
				'<td>'+data.driverid+'</td>'+
				'<td>'+data.plateno+'</td>'+
				'<td>'+data.vtype+'</td>'+
				'<td>'+data.make+'</td>'+
				'<td>'+data.model+'</td>'+
				'<td>'+data.vcolor+'</td>'+
				'<td>'+stat+'</td>'+
				'<td>'+available+'</td>'+
				'<td>'+
					'<button class="btn btn-sm btn-default" onclick="get_vehicle('+data.id+')" title="View" data-toggle="tooltip">'+
						'<span class="fa fa-eye"></span> '+
					'</button>'+
					'<button class="btn btn-sm btn-default" onclick="edit_vehicle('+data.id+')"  title="Update" data-toggle="tooltip">'+
						'<span class="fa fa-edit"></span>'+
					'</button>'+
								
					'<button class="btn btn-sm btn-default" onclick="delete_vehicle('+data.id+')" title="Delete Record" data-toggle="tooltip">'+
						'<span class="fa fa-trash"></span>'+
					'</button>'+

				'</td>'+
				
			'</tr>');
    		
		});

		$('#vehicles_table').DataTable({
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

function get_vehicle(id) {  
  $.ajax({
    url: "/api/vehicle/get.php?id=" + id,
    async:false,
    success: function (response) {
    	tbody = '';
        $.ajax({
		    url: "/api/vehicle/getdocument.php?vehicleid=" + id,
		    async: false,
		    success: function (response) {
		    	if(response != '')
		    	$.each(response, function(k, data) {
		    		detailed = '';
		    		a = '';
				 	$.ajax({
					    url: "/api/vehicle/getdocument.php?id=" + data.id,
					    async: false,
					    success: function (r) {
					    	detailed = '<td>'+r.datecreated +'</td>' +'<td>'+r.datemodified +'</td>';
					    	a = /*'<a class="btn btn-sm btn-default" title="Download Document" data-toggle="tooltip">'+
									'<i class="fa fa-download"></i>'+
								'</a>' +*/
								'<button class="btn btn-sm btn-default" onclick="edit_doc('+r.id+');" title="Edit Document" data-toggle="tooltip">'+
									'<i class="fa fa-edit"></i>'+
								'</button>';
					    },
					    contentType: "application/json; charset=UTF-8",
					    dataType: "json"
					});

		        tbody += '<tr>'+
			            	'<td>'+data.description +'</td>'+
			            	'<td>'+data.type +'</td>'+ detailed +
			            	'<td>'+ a +
								'<button class="btn btn-sm btn-default" onclick="dlt_doc('+data.id+', '+data.vehicleid+');" title="Delete Document" data-toggle="tooltip">'+
									'<i class="fa fa-trash"></i>'+
								'</button>'+
							'</td>'+
			            '</tr>';
			     });
		    	else tbody='<tr><td colspan="5" style="text-align:center"> Nothing to see. </td></tr>';
		    },
		    error: function (response) {
		     alert(response.responseJSON["message"]);
		    },
		    contentType: "application/json; charset=UTF-8",
		    dataType: "json"
		  });
        view = '<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">View vehicle</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
            	'<div class="col-md-3">'+
	            	'<div class="col-md-12">'+
	            		'<img src="'+response.photo+'" id="vehicle_img" alt="" style="width: 200px; height: 200px; border:1px solid;">'+
	            	'</div>'+
	            '</div>'+
	            '<div class="col-md-9">'+
	            	'<div class="row">'+
		            	'<div class="col-md-4">'+
			                '<label>Plate No</label><br>'+
			                '<h6>'+response.plateno +'</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Type</label><br>'+
			                '<h6>'+response.vtype +'</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Make</label><br>'+
			                '<h6>'+response.make +'</h6>'+
		                '</div>'+
		            '</div><br>'+
		            '<div class="row">'+
		                '<div class="col-md-4">'+
			                '<label>Model</label><br>'+
			                '<h6>'+response.model +'</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Date Created</label><br>'+
			                '<h6>'+response.datecreated +'</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Last Modified</label><br>'+
			                '<h6>'+response.datemodified +'</h6>'+
		                '</div>'+
		            '</div><br>'+
		            '<div class="row" style="margin:0">'+

         				'<div class="col-md-12" style="padding:0">'+
         				'<h6 style="text-align:center">vehicle Documents</h6>'+
			            '<table border="1" cellpadding="5" style="width: 100%;">'+
			            	'<thead>'+
				            	'<th>Description</th>'+
				                '<th>Type</th>'+
				                '<th>Date Created</th>'+
				                '<th>Last Modified</th>'+
				                '<th>Action</th>'+
				            '</thead>'+
				            '<thead id="edit_doc_row">'+
				            '</thead>'+
				            '<body>'+ tbody+
				            '</body>'+
			            '</table></div>'+
			            '<div class="col-md-12" style="margin-top:4px">'+
					    	'<button style="float:right;" onclick="$(\'#vehicle_preview\').empty();" class="btn btn-sm btn-default">Close</button>'+
						 '</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
			'<hr>'+
		'</div>';
        $('#vehicle_preview').html(view);
         
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};

	
</script>
