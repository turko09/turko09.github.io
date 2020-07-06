 <!DOCTYPE html>
 
 <html lang="en">
 	<head>
 
 		<?php include_once("layouts/dashboard.header.php") ?>
 
 		<link rel="stylesheet" href="../app/assets/stylesheets/datatables.min.css">
 	</head>
 	<body class="login-page">
 
 		<script src="../app/assets/js/datatables.min.js"></script>
 	    <div class="container-fluid">
 	      <div class="row">
 
 	        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
 						<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2">
 								<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
 
 								</div>
 						</div>
 						<div class="table-responsive" id="driver_preview">
 						</div>
 						<div class="table-responsive" id="driver_list">
 							<table class="table table-striped table-sm" id="drivers_table">
 								<thead>
 									<tr>
 										<th>field_1</th>
 										<th>field_2</th>
 										<th>field_3</th>
 										<th>field_4</th>
 										<th>field_5</th>
 										<th>field_6</th>
 										<th>field_7</th>
 										<th>field_8</th>
-										<th>field_9</th>
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
 });
 function load_drivers() {
 	$('#drivers_tbl').empty();
   $.ajax({
     url: "/api/driver/get.php",
     success: function (response) {
     	ct=0;
     	$.each(response, function(k, data) {
     		ct++;
     		$('#drivers_tbl').append('<tr>'+
 				'<td>'+ct+'</td>'+
 				'<td>'+data.mobile+'</td>'+
 				'<td>'+data.mobile+'</td>'+
 				'<td>'+data.mobile+'</td>'+
				'<td>'+data.mobile+'</td>'+
				'<td>'+data.mobile+'</td>'+
				'<td>'+data.mobile+'</td>'+
				'<td>'+data.mobile+'</td>'+
				'<td></td>'+
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
 
 </script>
