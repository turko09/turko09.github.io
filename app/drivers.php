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
							<h1 class="h2"><span class="fa fa-fw fa-users"></span> Drivers</h1>
								<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
								</div>
						</div>
						<div class="table-responsive" id="driver_preview">
						</div>
						<div class="table-responsive" id="driver_list">
							<table class="table table-striped table-sm" id="drivers_table">
								<thead>
									<tr>
										<th>#</th>
										<th>Driver</th>
										<th>Email</th>
										<th>Mobile</th>
										<th>Verified</th>
										<th>Blocked</th>
										<th>Active</th>
										<th>Rating</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody id="drivers_tbl">
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
	load_drivers();
	id = getQueryParam('id');
	if (id !== '') {
		get_driver(id);
	}
});

var getQueryParam = function (param) {
    var result = window.location.search.match(
        new RegExp("(\\?|&)" + param + "(\\[\\])?=([^&]*)")
    );
    return result ? result[3] : '';
}

function load_drivers() {
	$('#drivers_tbl').empty();
  $.ajax({
    url: "/api/driver/get.php",
    success: function (response) {
    	ct=0;
    	$.each(response, function(k, data) {
    		ct++;
    		stat = '<span class="btn-success btn-sm" href="#" role="button">Active</span>';
    		blocked = '<span class="btn-danger btn-sm" href="#" role="button">Blocked</span>';
    		verified = '<span class="btn-success btn-sm" href="#" role="button">Verified</span>';
    		if(data.active == 0) stat = '<span class="btn-danger btn-sm" href="#" role="button">Inactive</span>';
    		if(data.blocked == 0) blocked = '<span class="btn-success btn-sm" href="#" role="button">Not Blocked</span>';
    		if(data.verified == 0) verified = '<span class="btn-danger btn-sm" href="#" role="button">Not Verified</span>';

    		$('#drivers_tbl').append('<tr>'+
				'<td>'+ct+'</td>'+
				'<td>'+data.firstname+' ' +data.lastname+'</td>'+
				'<td>'+data.email+'</td>'+
				'<td>'+data.mobile+'</td>'+
				'<td>'+verified+'</td>'+
				'<td>'+blocked+'</td>'+
				'<td>'+stat+'</td>'+
				'<td>'+data.rating+'</td>'+
				'<td>'+
					'<button class="btn btn-sm btn-default" onclick="get_driver('+data.id+')" title="View Record" data-toggle="tooltip">'+
						'<span class="fa fa-eye"></span> '+
					'</button>'+
					'<button class="btn btn-sm btn-default" onclick="edit_driver('+data.id+')"  title="Update Record" data-toggle="tooltip">'+
						'<span class="fa fa-edit"></span>'+
					'</button>'+
					'<button class="btn btn-sm btn-default" onclick="update_stats('+data.id+')" title="Update Status" data-toggle="tooltip">'+
						'<span class="fa fa-user"></span> '+
					'</button>'+
					'<button class="btn btn-sm btn-default" onclick="add_document('+data.id+')" title="Add Document" data-toggle="tooltip">'+
						'<span class="fa fa-upload"></span>'+
					'</button>'+
					'<button class="btn btn-sm btn-default" onclick="delete_driver('+data.id+')" title="Delete Record" data-toggle="tooltip">'+
						'<span class="fa fa-trash"></span>'+
					'</button>'+

				'</td>'+
			'</tr>');
    		
		});

		$('#drivers_table').DataTable({
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

function edit_driver(id) {
  $.ajax({
    url: "/api/driver/get.php?id=" + id,
    success: function (response) {
        $('#driver_preview').html('<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">Edit Driver Details</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
            	'<div class="col-md-3">'+
	            	'<div class="col-md-12">'+
	            		'<img src="'+response.photo+'" id="driver_img" alt="" style="width: 200px; height: 200px; border:1px solid;">'+
	            		'<input type="file" id="edit_photo">'+
	            	'</div>'+
	            '</div>'+
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
			                '<div style="display:flex">'+
			                '<span style="padding:9px">+</span><input type="text" class="form-control" name="mobile" id="mobile" value="'+response.mobile +'" maxlength="19">'+
			                '</div>'+
		                '</div>'+
		                
		            '</div><br>'+
		            '<div class="row">'+
		                '<div class="col-md-8">'+
			                '<label>Address</label><br>'+
			                '<input type="text" class="form-control" name="address" id="address" value="'+response.address +'">'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Email</label><br>'+
			                '<input type="text" class="form-control" name="email" id="email" value="'+response.email +'">'+
		                '</div>'+
			            '<div class="col-md-12" style="margin-top:10px;">'+
			                '<span class="text-danger" id="ewarn"></span>'+
			            	'<div style="float:right">'+
				            	'<button style="margin-right:10px;" onclick="go_update('+response.id+');" class="btn btn-sm btn-primary">Submit</button>'+
				                '<button onclick="$(\'#driver_preview\').empty();" class="btn btn-sm btn-default">Close</button>'+
				            '</div>'+
			            '</div>'+
		            '</div>'+
		            '<hr>'+
	            '</div>'+
            '</div>'+
            '<br>'+
        '</div>');

        document.getElementById("edit_photo").onchange = function () {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            document.getElementById("driver_img").src = e.target.result;
	        };
	        reader.readAsDataURL(this.files[0]);
    	};
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
    url: "/api/driver/get.php?id=" + id,
    success: function (response) {
        $('#driver_preview').html('<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">Update Driver Status</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
            	'<div class="col-md-3">'+
	            	'<div class="col-md-12">'+
	            		'<img src="'+response.photo+'" id="driver_img" alt="" style="width: 200px; height: 200px; border:1px solid;">'+
	            	'</div>'+
	            '</div>'+
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
				            '<button onclick="$(\'#driver_preview\').empty();" class="btn btn-sm btn-default">Close</button>'+
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

function add_document(id) {
  $.ajax({
    url: "/api/driver/get.php?id=" + id,
    success: function (response) {
        $('#driver_preview').html('<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">Add Document</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
            	'<div class="col-md-3">'+
	            	'<div class="col-md-12">'+
	            		'<img src="'+response.photo+'" id="driver_img" alt="" style="width: 200px; height: 200px; border:1px solid;">'+
	            	'</div>'+
	            '</div>'+
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
			                '<label>Description</label><br>'+
			                '<input type="text" class="form-control" id="description">'+
		                '</div>'+
		                '<div class="col-md-4">'+
			                '<label>Type</label><br>'+
			                '<input type="text" class="form-control" id="type">'+
		                '</div>'+
		                '<div class="col-md-4">'+
		              	    '<label>Document</label><br>'+
		              	    '<input type="hidden" id="doc_holder">'+
		              	    '<input type="file" id="doc">'+
		              	  '</div>'+
		              	'</div>'+
		              	'<div class="col-md-12" style="margin-top:10px;">'+
			            	'<div style="float:right">'+
				            '<button style="margin-right:10px;" onclick="go_upload('+response.id+');" class="btn btn-sm btn-primary">Submit</button>'+
				            '<button onclick="$(\'#driver_preview\').empty();" class="btn btn-sm btn-default">Close</button>'+
				            '</div>'+
			            '</div>'+
	            '</div>'+       
            '</div>'+
            '<hr>'+
            '<br>'+
        '</div>');
        $('#active').val(response.active);
		$('#verified').val(response.verified);
		$('#blocked').val(response.blocked);
		document.getElementById("doc").onchange = function () {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            document.getElementById("doc_holder").value = e.target.result;
	        };
	        reader.readAsDataURL(this.files[0]);
    	};
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};



function get_doc(id) {
 	$.ajax({
	    url: "/api/driver/getdocument.php?id=" + id,
	    async: false,
	    success: function (response) {
	    },
	    error: function (response) {
	     alert(response.responseJSON["message"]);
	    },
	    contentType: "application/json; charset=UTF-8",
	    dataType: "json"
	});
};

function dlt_doc(id, driver_id){
	var r = confirm("Are you sure you want to delete this document?");
    if (r == true) {
       $.ajax({
       		type: "POST",
		    url: "/api/driver/deletedocument.php?id=" + id,
		    async:false,		    
 			data:JSON.stringify({
        		id: id
    		}),
		    success: function (response) { get_driver(driver_id);},
		    error: function (response) {
		     alert(response.responseJSON["message"]);
		    }
		});
    }

}

function get_driver(id) {  
  $.ajax({
    url: "/api/driver/get.php?id=" + id,
    async:false,
    success: function (response) {
    	tbody = '';
        $.ajax({
		    url: "/api/driver/getdocument.php?driverid=" + id,
		    async: false,
		    success: function (response) {
		    	if(response != '')
		    	$.each(response, function(k, data) {
		    		detailed = '';
		    		a = '';
				 	$.ajax({
					    url: "/api/driver/getdocument.php?id=" + data.id,
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
								'<button class="btn btn-sm btn-default" onclick="dlt_doc('+data.id+', '+data.driverid+');" title="Delete Document" data-toggle="tooltip">'+
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
                '<h4 style="text-align:center">View Driver</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
            	'<div class="col-md-3">'+
	            	'<div class="col-md-12">'+
	            		'<img src="'+response.photo+'" id="driver_img" alt="" style="width: 200px; height: 200px; border:1px solid;">'+
	            	'</div>'+
	            '</div>'+
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
			                '<label>Address</label><br>'+
			                '<h6>'+response.address +'</h6>'+
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
         				'<h6 style="text-align:center">Driver Documents</h6>'+
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
					    	'<button style="float:right;" onclick="$(\'#driver_preview\').empty();" class="btn btn-sm btn-default">Close</button>'+
						 '</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
			'<hr>'+
		'</div>';
        $('#driver_preview').html(view);
         
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
};
function edit_doc(id){

	$.ajax({
	    url: "/api/driver/getdocument.php?id=" +id,
	    async: false,
	    success: function (r) {
			$('#edit_doc_row').html('<th><input type="text" class="form-control" id="edit_description" value="'+r.description+'"></th>'+
			'<th><input type="text" class="form-control" id="edit_type" value="'+r.type+'"></th>'+
			'<th colspan="2"><input type="hidden" class="form-control" id="edit_document_holder"><input type="file" class="form-control" id="edit_document"></th>'+
			'<th>'+
			'<button style="border-radius:0" onclick="go_update_doc('+r.id+', '+r.driverid+');" class="btn btn-sm btn-success">Save</button>'+
			'<button style="border-radius:0" onclick="$(\'#edit_doc_row\').empty();" class="btn btn-sm btn-default">Cancel</button></th>'
			);
			document.getElementById("edit_document").onchange = function () {
		        var reader = new FileReader();
		        reader.onload = function (e) {
		            document.getElementById("edit_document_holder").value = e.target.result;
		        };
		        reader.readAsDataURL(this.files[0]);
	    	};
	    },
	    contentType: "application/json; charset=UTF-8",
	    dataType: "json"
	});
	
}
function go_update_doc(id, driverid) {
	description = $('#edit_description').val();
	type = $('#edit_type').val();
	docs = $('#edit_document_holder').val();
	$.ajax({
     type: "POST",
     url: "/api/driver/updatedocument.php",
     data:JSON.stringify({
        id: id,
        driverid: driverid,
        document: docs,
        description: description,
        type: type
    }),
    success: function (response) {
    	get_driver(driverid);
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
}


function go_upload(id) {
	description = $('#description').val();
	type = $('#type').val();
	docs = $('#doc_holder').val();
	$.ajax({
     type: "POST",
     url: "/api/driver/adddocument.php",
     data:JSON.stringify({
        driverid: id,
        document: docs,
        description: description,
        type: type
    }),
    success: function (response) {
    	get_driver(id);
    },
    error: function (response) {
     alert(response.responseJSON["message"]);
    },
    contentType: "application/json; charset=UTF-8",
    dataType: "json"
  });
}


function go_update(id) {
	var firstname = $('#firstname').val();
     var lastname = $('#lastname').val();
     var email = $('#email').val();
     var address = $('#address').val();
     var mobile = '+' + $('#mobile').val();
     var photo = document.getElementById("driver_img").src;
     if(!(mailvalidate(email)))
         $('#ewarn').text('Invalid email address.');
     else
	$.ajax({
     type: "POST",
     url: "/api/driver/update.php",
     data:JSON.stringify({
        id: id,
        firstname: firstname,
        lastname: lastname,
        email: email,
        address: address,
        mobile : mobile,
        photo: photo
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
    var verified = $('#verified').val();
    var blocked = $('#blocked').val();
	$.ajax({
     type: "POST",
     url: "/api/driver/updatestatus.php",
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
     url: "/api/driver/delete.php",
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
function delete_driver(id) {
  $.ajax({
    url: "/api/driver/get.php?id=" + id,
    success: function (response) {
        $('#driver_preview').html('<div class="col-md-12">'+
            '<div class="page-header">'+
                '<h4 style="text-align:center">Delete Driver</h4>'+
                '<hr>'+
            '</div>'+
            '<div class="row">'+
            	'<div class="col-md-3">'+
	            	'<div class="col-md-12">'+
	            		'<img src="'+response.photo+'" id="driver_img" alt="" style="width: 200px; height: 200px; border:1px solid;">'+
	            	'</div>'+
	            '</div>'+
	            '<div class="col-md-9">'+
		            '<div class="row">'+
		                '<div class="col-md-12">'+
			                '<h4>Are you sure you want do delete '+response.firstname+' '+ response.lastname +' ?</h4><br>'+
		                '</div>'+
		                '<div class="col-md-4">'+
		                	'<div style="float:right">'+
			                	'<button onclick="godelete('+response.id+');" style="margin-right:10px" class="btn btn-md btn-danger">Yes</button>'+
			                	'<button onclick="$(\'#driver_preview\').empty();" class="btn btn-md btn-default">No</button>'+
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
$('#driver_preview').on('keydown', '#mobile', function(e){
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
function mailvalidate(email) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(email)) {
            return true;
        }
        else {
            return false;
        }
      }
</script>
