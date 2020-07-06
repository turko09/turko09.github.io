<?php
session_start();
if (!isset($_SESSION["admin_id"]) || !isset($_SESSION["admin_name"]))
{
   header("location: logout.php");
}
?>


<?php
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
//echo $page;
//exit;
// set number of records per page
$records_per_page = 5;
 
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
//echo $from_record_num;
//exit;
// include database and object files
include_once 'vehicle/config/database.php';
include_once 'vehicle/objects/vehicle.php';
//include_once '../../api/vehicle/get.php';

//echo 'test';
//exit;
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
 
$vehicle = new Vehicle($db);
//$category = new Category($db);
 
// query vehicles
$stmt = $vehicle->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();
//echo $num;
//exit;
// set page header
?>
	<head>
		<?php include_once("layouts/dashboard.header.php"); ?>
		<script src="assets/js/fare.js"></script>
	</head>

	<body class="login-page">
		<?php include_once("layouts/dashboard.navigation.php"); ?>
	    <div class="container-fluid">
	      <div class="row">
	      	<?php include_once("layouts/dashboard.sidebar.php"); ?>
	        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
	          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	            <h1 class="h2"> Vehicle List</h1>
							<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
							 <a href='vehicle/vehicle_add.php' class='btn btn-default pull-right'>ADD VEHICLE</a>
							</div>
	          </div>

 <?php

// display the vehicles if there are any
if($num>0){
 
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            //echo "<th>Photo</th>";
			echo "<th>ID</th>";
            echo "<th>Driver ID</th>";
			echo "<th>Plate No</th>";
            echo "<th>Type</th>";
            echo "<th>Make</th>";
            echo "<th>Model</th>";
			echo "<th>Color</th>";
			echo "<th>Active</th>";
			//echo "<th>Free</th>";
			echo "<th>Latitude</th>";
			echo "<th>Longitude</th>";
			echo "<th>Actions</th>";
        echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
 
            echo "<tr>";
				//echo "<td>{photo}</td>";
                echo "<td>{$id}</td>";
                echo "<td>{$driverid}</td>";
				echo "<td>{$plateno}</td>";
                echo "<td>{$type}</td>";
				echo "<td>{$make}</td>";
				echo "<td>{$model}</td>";
                echo "<td>{$color}</td>";
				echo "<td>{$active}</td>";
				//echo "<td>{$free}</td>";			
				echo "<td>{$locationlat}</td>";
				echo "<td>{$locationlong}</td>";
 
                echo "<td>";
                    // read one, edit and delete button will be here
					// read vehicle button
					echo "<a href='vehicle/vehicle_view_one.php?id={$id}' class='btn btn-primary left-margin'>";
						echo "<span class='glyphicon glyphicon-list'></span> Read";
					echo "</a>";
					 
					// edit vehicle button
					echo "<a href='vehicle/vehicle_update.php?id={$id}' class='btn btn-info left-margin'>";
						echo "<span class='glyphicon glyphicon-edit'></span> Edit";
					echo "</a>";
					 
					// delete vehicle button
					echo "<a delete-id='{$id}' class='btn btn-danger delete-object'>";
						echo "<span class='glyphicon glyphicon-remove'></span> Delete";
					echo "</a>";
                echo "</td>";
 
            echo "</tr>";
 
        }
 
    echo "</table>";
 
    // paging buttons will be here
	// the page where this paging is used
	$page_url = "vehicle.php?";
	 
	// count all vehicles in the database to calculate total pages
	$total_rows = $vehicle->countAll();
	 
	// paging buttons here
	include_once 'vehicle/paging.php';
}
 
// tell the user there are no vehicles
else{
    echo "<div class='alert alert-info'>No vehicles found.</div>";
}
// set page footer
include_once "vehicle/layout_footer.php";
?>
