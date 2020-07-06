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
							<h1 class="h2"><span class="fa fa-fw fa-user"></span> Administrators</h1>
								<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
								</div>
						</div>
						<div class="table-responsive" id="admin_preview">
						</div>
						<div class="table-responsive" id="admin_list">
							<table class="table table-striped table-sm" id="admin_table">
								<thead>
									<tr>
										<th>#</th>
										<th>Administrator</th>
										<th>Email</th>
										<th>Mobile</th>
										<th>Active</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody id="admin_tbl">
								</tbody>
							</table>
						</div>
			<a href="register.php" class="float-left">
                      Add New Administrator
                    </a>
	        </main>
	      </div>
	    </div>
	</body>
</html>

<script>
$(document).ready(function(){
	load_admin();
});
function load_admin() {
	$('#admin_tbl').empty();
  $.ajax({
    url: "/api/admin/get.php",
    success: function (response) {
    	ct=0;
    	$.each(response, function(k, data) {
    		ct++;
    		stat = '<span class="btn-success btn-sm" href="#" role="button">Active</span>';
    		if(data.active == 0) stat = '<span class="btn-danger btn-sm" href="#" role="button">Inactive</span>';
    		$('#admin_tbl').append('<tr>'+
				'<td>'+ct+'</td>'+
				'<td>'+data.firstname+' ' +data.lastname+'</td>'+
				'<td>'+data.email+'</td>'+
				'<td>'+data.mobile+'</td>'+
				'<td>'+stat+'</td>'+
				'<td>'+
					'<button class="btn btn-sm btn-default" onclick="get_admin('+data.id+')" title="View Record" data-toggle="tooltip">'+
						'<span class="fa fa-eye"></span> '+
					'</button>'+
					'<button class="btn btn-sm btn-default" onclick="update_stats('+data.id+')" title="Update Status" data-toggle="tooltip">'+
						'<span class="fa fa-user"></span> '+
					'</button>'+
					'<button class="btn btn-sm btn-default" onclick="delete_admin('+data.id+')" title="Delete Record" data-toggle="tooltip">'+
						'<span class="fa fa-trash"></span>'+
					'</button>'+
				'</td>'+
			'</tr>');
    		
		});
		$('#admin_table').DataTable({
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
function edit_admin(id) {
  $.ajax({
    url: "/api/admin/get.php?id=" + id,
    success: function (response) {
        $('#driver_preview').html('<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">Edit Administrator Details</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
	            '<div class="col-md-9">'+
	            	'<div class="row">'+
		            	'<div class="col-md-4">'+
			                '<label>Name</label><br>'+
			                '<input type="text" class="form-control" name="firstname" id="firstname" value="'+response.firstname+'">'+ 
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Last Name</label><br>'+
			                '<input type="text" class="form-control" name="lastname" id="lastname" value="'+response.lastname+'">'+ 
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Mobile</label><br>'+
			                '<input type="text" class="form-control" name="mobile" id="mobile" value="'+response.mobile +'" maxlength="11">'+
		                '</div>'+
		                
		            '</div><br>'+
		            '<div class="row">'+
		                '<div class="col-md-4">'+
			                '<label>Email</label><br>'+
			                '<input type="text" class="form-control" name="email" id="email" value="'+response.email +'">'+
		                '</div>'+
			            '<div class="col-md-12" style="margin-top:10px;">'+
			            	'<div style="float:right">'+
				            	'<button style="margin-right:10px;" onclick="go_update('+response.id+');" class="btn btn-sm btn-primary">Submit</button>'+
				                '<button onclick="$(\'#admin_preview\').empty();" class="btn btn-sm btn-default">Close</button>'+
				            '</div>'+
			            '</div>'+
		            '</div>'+
		            '<hr>'+
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
function update_stats(id) {
  $.ajax({
    url: "/api/admin/get.php?id=" + id,
    success: function (response) {
        $('#admin_preview').html('<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">Update Administrator Status</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
	            '<div class="col-md-9">'+
	            	'<div class="row">'+
		            	'<div class="col-md-4">'+
			                '<label>Name</label><br>'+
			                '<h6>'+response.firstname+' ' +response.lastname+'</h6>'+ 
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Mobile</label><br>'+
			                '<h6>'+response.mobile +'</h6>'+
		                '</div>'+
		            '</div><br>'+
		            '<div class="row">'+
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
				            '<button onclick="$(\'#admin_preview\').empty();" class="btn btn-sm btn-default">Close</button>'+
				            '</div>'+
			            '</div>'+
		            '</div>'+
		            '<hr>'+
	            '</div>'+
		'</div>'+
            '<br>'+
        '</div>');

        $('#active').val(response.active);
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};

function get_admin(id) {  
  $.ajax({
    url: "/api/admin/get.php?id=" + id,
    async:false,
    success: function (response) {
    	tbody = '';
        $.ajax({
		    url: "/api/admin/getdocument.php?adminid=" + id,
		    async: false,
		    success: function (response) {
		    	if(response != '')
		    	$.each(response, function(k, data) {
		    		detailed = '';
		    		a = '';
				 	$.ajax({
					    url: "/api/admin/getdocument.php?id=" + data.id,
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
								'<button class="btn btn-sm btn-default" onclick="dlt_doc('+data.id+', '+data.adminid+');" title="Delete Document" data-toggle="tooltip">'+
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
                '<h4 style="text-align:center">View Administrator</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
	            '<div class="col-md-9">'+
	            	'<div class="row">'+
		            	'<div class="col-md-4">'+
			                '<label>Name</label><br>'+
			                '<h6>'+response.firstname+' '+ response.lastname +'</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Mobile</label><br>'+
			                '<h6>'+response.mobile +'</h6>'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Email</label><br>'+
			                '<h6>'+response.email +'</h6>'+
		                '</div>'+
		            '</div><br>'+
		            '<div class="row">'+
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
			            '<div class="col-md-12" style="margin-top:4px">'+
					    	'<button style="float:right;" onclick="$(\'#admin_preview\').empty();" class="btn btn-sm btn-default">Close</button>'+
						 '</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
			'<hr>'+
		'</div>';
        $('#admin_preview').html(view);
         
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};
function go_update(id) {
	var firstname = $('#firstname').val();
     var lastname = $('#lastname').val();
     var email = $('#email').val();
     var mobile = $('#mobile').val();
	$.ajax({
     type: "POST",
     url: "/api/admin/update.php",
     data:JSON.stringify({
        id: id,
        firstname: firstname,
        lastname: lastname,
        email: email,
        mobile : mobile
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
function go_update_stats(id){
	var active = $('#active').val();
	$.ajax({
     type: "POST",
     url: "/api/admin/updatestatus.php",
     data:JSON.stringify({
        id: id,
        active: active
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
     url: "/api/admin/delete.php",
     data:JSON.stringify({
        id: id
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
function delete_admin(id) {
  $.ajax({
    url: "/api/admin/get.php?id=" + id,
    success: function (response) {
        $('#admin_preview').html('<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">Delete Administrator</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
	            '<div class="col-md-9">'+
		            '<div class="row">'+
		                '<div class="col-md-12">'+
			                '<h4>Are you sure you want do delete '+response.firstname+' '+ response.lastname +' ?</h4><br>'+
		                '</div>'+
		                '<div class="col-md-4">'+
		                	'<div style="float:right">'+
			                	'<button onclick="godelete('+response.id+');" style="margin-right:10px" class="btn btn-md btn-danger">Yes</button>'+
			                	'<button onclick="$(\'#admin_preview\').empty();" class="btn btn-md btn-default">No</button>'+
			                '</div>'+
			            '</div>'+
		            '</div>'+
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
