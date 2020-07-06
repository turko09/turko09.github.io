<?php
// check if value was posted
if($_POST){
 
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/vehicle.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // prepare vehicle object
    $vehicle = new Vehicle($db);
     
    // set vehicle id to be deleted
    $vehicle->id = $_POST['object_id'];
     
    // delete the vehicle
    if($vehicle->delete()){
        echo "Object was deleted.";
    }
     
    // if unable to delete the vehicle
    else{
        echo "Unable to delete object.";
    }
}
?>
