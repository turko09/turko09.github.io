<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/vehicle.php';
include_once 'objects/driver.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects
$vehicle = new Vehicle($db);
$driver = new Driver($db);
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
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
 
    // set vehicle property values
    $vehicle->driverid = $_POST['driverid'];
    $vehicle->plateno = $_POST['plateno'];
    $vehicle->type = $_POST['type'];
    $vehicle->make = $_POST['make'];
	$vehicle->color = $_POST['color'];
	$vehicle->photo = $_POST['photo'];
	$vehicle->active = $_POST['active'];
	//$vehicle->free = $_POST['free'];
	$vehicle->locationlat = $_POST['locationlat'];
	$vehicle->locationlong = $_POST['locationlong'];
    $vehicle->datecreated = $_POST['datecreated'];
    $vehicle->datemodified = $_POST['datemodified'];
 
    // create the vehicle
    if($vehicle->create()){
        echo "<div class='alert alert-success'>vehicle was created.</div>";
    }
 
    // if unable to create the vehicle, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create vehicle.</div>";
    }
} 
?>
<!-- PHP post code will be above -->
 
<!-- HTML form for creating a vehicle -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Driver ID</td>
			<!--<td><input type='text' name='driverid' class='form-control' /></td> -->
			<td>
            
			  <?php
			// read the vehicle categories from the database
			$stmt = $driver->read();
			 
			// put them in a select drop-down
			echo "<select class='form-control' name='driverid'>";
				echo "<option>Select driver...</option>";
			 
				while ($row_driver = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row_driver);
					echo "<option value='{$id}'>{$firstname}</option>";
				}
			 
			echo "</select>";
			?>
            </td>
            
            
        </tr>
 
        <tr>
            <td>Plate No</td>
            <td><input type='text' name='plateno' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Type</td>
            <td><textarea name='type' class='form-control'></textarea></td>
        </tr>
 
        <tr>
            <td>Make</td>
            <td><input type='text' name='make' class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Model</td>
            <td><input type='text' name='model' class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Photo</td>
            <td><input type='text' name='photo' class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Color</td>
            <td><input type='text' name='color' class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Active</td>
            <td><input type='text' name='active' class='form-control' /></td>
        </tr>

        <tr>
            <td>Available</td>
            <td><input type='text' name='available' class='form-control' /></td>
        </tr>
        
		
		<tr>
            <td>Latitude</td>
            <td><input type='text' name='locationlat' class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Longitude</td>
            <td><input type='text' name='locationlong' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Date Created</td>
            <td><input type='text' name='datecreated' class='form-control' /></td>
        </tr>

        <tr>
            <td>Date Modified</td>
            <td><input type='text' name='datemodified' class='form-control' /></td>
        </tr>
 
 
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Add</button>
            </td>
        </tr>
 
    </table>
</form>
<?php 
// footer
include_once "layout_footer.php";
?>
