<?php
// retrieve one vehicle will be here
// get ID of the vehicle to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/vehicle.php';
//include_once 'objects/category.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$vehicle = new Vehicle($db);
//$category = new Category($db);
 
// set ID property of vehicle to be edited
$vehicle->id = $id;
 
// read the details of vehicle to be edited
$vehicle->readOne();
 
?>
<!-- 'update vehicle' form will be here -->

<?php 
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
                <h1 class="h2"> Vehicle</h1>
                            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                              <a href='../vehicle.php' class='btn btn-default pull-right'>VIEW VEHICLE</a>
                            </div>
              </div>
 <?php
// if the form was submitted
if($_POST){
 
    // set vehicle property values
    //$vehicle->id = $_POST['id'];
    $vehicle->driverid = $_POST['driverid'];
    $vehicle->plateno = $_POST['plateno'];
    $vehicle->type = $_POST['type'];
    $vehicle->make = $_POST['make'];
    $vehicle->model = $_POST['model'];
    $vehicle->color = $_POST['color'];
    $vehicle->active = $_POST['active'];
    $vehicle->available = $_POST['available'];
 
    // update the vehicle
    if($vehicle->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "vehicle was updated.";
        echo "</div>";
    }
 
    // if unable to update the vehicle, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update vehicle.";
        echo "</div>";
    }
}
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Driver ID</td>
            <td><input type='text' name='driverid' value='<?php echo $vehicle->driverid; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Plate No</td>
            <td><input type='text' name='plateno' value='<?php echo $vehicle->plateno; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Type</td>
            <td><input type='text' name='type' value='<?php echo $vehicle->type; ?>' class='form-control' /></td>
        </tr>
 
       <tr>
            <td>Make</td>
            <td><input type='text' name='make' value='<?php echo $vehicle->make; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>Model</td>
            <td><input type='text' name='model' value='<?php echo $vehicle->model; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>Color</td>
            <td><input type='text' name='color' value='<?php echo $vehicle->color; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>Active</td>
            <td><input type='text' name='active' value='<?php echo $vehicle->active; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>Available</td>
            <td><input type='text' name='available' value='<?php echo $vehicle->available; ?>' class='form-control' /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
 
    </table>
</form>
<?php
// set page footer
include_once "layout_footer.php";
?>
