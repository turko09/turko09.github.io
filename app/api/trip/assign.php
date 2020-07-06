<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/driver.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/passenger.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/trip.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/vehicle.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/onesignal.php';

// Declare use on objects to be used
use Exception;
use PDOException;

// Set default response headers
Http::SetDefaultHeaders('POST');

// Check API Key
if (!Auth::Authenticate()) {
    Http::ReturnError(401, array('message' => 'Invalid API Key provided.'));    
    return;
}

// Check if request method is correct
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Http::ReturnError(405, array('message' => 'Request method is not allowed.'));
    return;
}

// Extract request body
$input = json_decode(file_get_contents("php://input"));

if (is_null($input)) {
    Http::ReturnError(400, array('message' => 'Trip details are empty.'));
} else {
    try {
        // Create Db object
        $db = new Db('SELECT * FROM `trip` WHERE id = :id LIMIT 1');

        // Bind parameters
        $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);

        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Trip not found.'));
        } else {
            // Trip  was found
            $record = $db->fetchAll()[0];
            $trip = new Trip($record);

            // Create Db object
            $db = new Db('UPDATE `trip` SET vehicleid = :vehicleid, stage = :stage, datemodified = :datemodified WHERE id = :id');

            // Bind parameters
            $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
            $db->bindParam(':vehicleid', property_exists($input, 'vehicleid') ? $input->vehicleid : 0);
            $db->bindParam(':stage', 'Assigned');
            $db->bindParam(':datemodified', date('Y-m-d H:i:s'));

            // Execute
            $db->execute();

            // Commit transaction
            $db->commit();

            // Retrieve vehicle details
            $db = new Db('SELECT * FROM `vehicle` WHERE id = :vehicleid');
            $db->bindParam(':vehicleid', $input->vehicleid);
            $db->execute();
            $record = $db->fetchAll()[0];
            $vehicle = new Vehicle($record);

            // Retrieve driver details
            $db = new Db('SELECT * FROM `driver` WHERE id = :driverid');
            $db->bindParam(':driverid', $vehicle->driverid);
            $db->execute();
            $record = $db->fetchAll()[0];
            $driver = new Driver($record);

            // Retrieve passenger details
            $db = new Db('SELECT * FROM `passenger` WHERE id = :passengerid');
            $db->bindParam(':passengerid', $trip->passengerid);
            $db->execute();
            $record = $db->fetchAll()[0];
            $passenger = new Passenger($record);

            // Build data
            $data = array(
                'tripid' => $trip->id,
                'passengerid' => $passenger->id,
                'driverid' => $driver->id,
                'vehicleid' => $vehicle->id,
            );

            // Send to OneSignal
            $onesignal = new OneSignal();
            $onesignal->send(
                $data,
                'Trip assigned!',
                'Hey ' . $driver->firstname . ', you\'ve been assigned to a trip booked by a passenger named ' . $passenger->firstname . ' ' . $passenger->lastname . '. You have an option to accept or reject it.',
                $driver->playerid);

            // Reply with successful response
            Http::ReturnSuccess(array('message' => 'Trip assigned.', 'id' => $input->id));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
