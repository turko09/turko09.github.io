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
            $db = new Db('UPDATE `trip` SET rating = :rating, datemodified = :datemodified WHERE id = :id');

            // Set rating
            $rating = 3;
            if (property_exists($input, 'rating')) {
                if ($input->rating > 5) {
                    $rating = 5;
                } else if ($input->rating < 1) {
                    $rating = 1;
                } else {
                    $rating = (int) $input->rating;
                }
            }

            // Bind parameters
            $db->bindParam(':id', property_exists($input, 'id') ? $input->id : 0);
            $db->bindParam(':rating', $rating);
            $db->bindParam(':datemodified', date('Y-m-d H:i:s'));

            // Execute
            $db->execute();

            // Commit transaction
            $db->commit();

            if ($trip->vehicleid != null) {
                // Retrieve vehicle details
                $db = new Db('SELECT * FROM `vehicle` WHERE id = :vehicleid');
                $db->bindParam(':vehicleid', $trip->vehicleid);
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

                $ratePrefix = '';
                if ($rating < 4) {
                    $ratePrefix = 'only ';
                }

                $ratePostfix = '';
                if ($rating === 5) {
                    $ratePostfix = ' That\'s really awesome!';
                } else if ($rating === 4) {
                    $ratePostfix = ' That\'s great!';
                } else if ($rating === 3) {
                    $ratePostfix = ' You can improve next time.';
                } else {
                    $ratePostfix = ' What happened on the trip?';
                }

                $starword = 'stars';
                if ($rating < 2) {
                    $starword = 'star';
                }

                // Send to OneSignal
                $onesignal = new OneSignal();
                $onesignal->send(
                    $data,
                    'Trip rated!',
                    'Hey ' . $driver->firstname . ', your passenger ' . $passenger->firstname . ' rated his trip with ' . $ratePrefix . $rating . ' ' . $starword . '! ' . $ratePostfix,
                    $driver->playerid);
            }

            // Reply with successful response
            Http::ReturnSuccess(array('message' => 'Trip rated.', 'id' => $input->id));
        }
    } catch (PDOException $pe) {
        Db::ReturnDbError($pe);
    } catch (Exception $e) {
        Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
    }
}
