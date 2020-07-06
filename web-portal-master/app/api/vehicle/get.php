<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/vehicle.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/vehiclelistitem.php';

// Declare use on objects to be used
use Exception;
use PDOException;

// HTTP headers for response
Http::SetDefaultHeaders('GET');

// Check API Key
if (!Auth::Authenticate()) {
    Http::ReturnError(401, array('message' => 'Invalid API Key provided.'));    
    return;
}

// Check if request method is correct
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Http::ReturnError(405, array('message' => 'Request method is not allowed.'));
    return;
}

$id = 0;
$driverid = 0;
$sourcelat = 0.00;
$sourcelong = 0.00;
$radius = 0;

// Extract request query string
if (array_key_exists('id', $_GET)) {
    $id = intval($_GET['id']);
}
if (array_key_exists('driverid', $_GET)) {
    $driverid = intval($_GET['driverid']);
}
if (array_key_exists('sourcelat', $_GET)) {
    $sourcelat = floatval($_GET['sourcelat']);
}
if (array_key_exists('sourcelong', $_GET)) {
    $sourcelong = floatval($_GET['sourcelong']);
}
if (array_key_exists('radius', $_GET)) {
    $radius = intval($_GET['radius']);
}

try {
    if ($id > 0) {
        // Return all vehicles for a driver

        // Create Db object
        $db = new Db('SELECT * FROM `vehicle` WHERE id = :id LIMIT 1');

        // Bind parameters
        $db->bindParam(':id', $id);

        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Vehicle not found.'));
        } else {
            // Driver document was found
            $record = $db->fetchAll()[0];
            $vehicle = new Vehicle($record);

            // Reply with successful response
            Http::ReturnSuccess($vehicle);
        }
    } else if ($driverid > 0) {
        // Return vehicles for a driver

        // Create Db object
        $db = new Db('SELECT * FROM `vehicle` WHERE driverid = :driverid');

        // Bind parameters
        $db->bindParam(':driverid', $driverid);

        $response = array();

        // Execute
        if ($db->execute() > 0) {
            // Drivers were found
            $records = $db->fetchAll();
            foreach ($records as &$record) {
                $vehicle = new VehicleListItem($record);
                array_push($response, $vehicle);
            }
        }

        // Reply with successful response
        Http::ReturnSuccess($response);
    } else {
        // Return vehicle near a location

        // Create Db object
        $db = new Db('SELECT *,
                        ( 6371 * acos( cos( radians(:sourcelat) ) * cos( radians(locationlat) )
                            * cos( radians(locationlong) - radians(:sourcelong) ) + sin( radians(:sourcelat) )
                            * sin(radians(locationlat)) ) ) AS distance
                         FROM `vehicle`' . ($radius > 0 ? ' HAVING distance <= :radius' : ''));

        // Bind parameters
        $db->bindParam(':sourcelat', $sourcelat);
        $db->bindParam(':sourcelong', $sourcelong);
        if ($radius > 0) {
            $db->bindParam(':radius', $radius);
        }

        $response = array();

        // Execute
        if ($db->execute() > 0) {
            // Drivers were found
            $records = $db->fetchAll();
            foreach ($records as &$record) {
                $vehicle = new VehicleListItem($record);
                array_push($response, $vehicle);
            }
        }

        // Reply with successful response
        Http::ReturnSuccess($response);
    }
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}
