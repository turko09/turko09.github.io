<?php
// get ID of the vehicle to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/vehicle.php';

 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$vehicle = new Vehicle($db);
//$category = new Category($db);
 
// set ID property of vehicle to be read
$vehicle->id = $id;
 
// read the details of vehicle to be read
$vehicle->readOne();
// set page headers
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
                <h1 class="h2"> Vehicle</h1>
                            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                              <a href='../vehicle.php' class='btn btn-default pull-right'>VIEW VEHICLE</a>
                            </div>
              </div>
 <?php

// HTML table for displaying a vehicle details
echo "<table class='table table-hover table-responsive table-bordered'>";
 

	echo "<tr>";
        echo "<td>ID</td>";
        echo "<td>{$vehicle->id}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Driver ID</td>";
        echo "<td>{$vehicle->driverid}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Plate No</td>";
        echo "<td>{$vehicle->plateno}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Type</td>";
        echo "<td>{$vehicle->type}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Make</td>";
        echo "<td>{$vehicle->make}</td>";
    echo "</tr>";
	
    echo "<tr>";
        echo "<td>Model</td>";
        echo "<td>{$vehicle->model}</td>";
    echo "</tr>";	

	echo "<tr>";
        echo "<td>Color</td>";
        echo "<td>{$vehicle->color}</td>";
    echo "</tr>";
	
	echo "<tr>";
        echo "<td>Active</td>";
        echo "<td>{$vehicle->active}</td>";
    echo "</tr>";
	
	echo "<tr>";
        echo "<td>Available</td>";
        echo "<td>{$vehicle->available}</td>";
    echo "</tr>";
	
	echo "<tr>";
        echo "<td>Latitude</td>";
        echo "<td>{$vehicle->locationlat}</td>";
    echo "</tr>";
	
	echo "<tr>";
        echo "<td>Longitude</td>";
        echo "<td>{$vehicle->locationlong}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>Date Created</td>";
        echo "<td>{$vehicle->datecreated}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>Date Modified</td>";
        echo "<td>{$vehicle->datemodified}</td>";
    echo "</tr>";	    
 
echo "</table>"; 
// set footer
include_once "layout_footer.php";
?>
