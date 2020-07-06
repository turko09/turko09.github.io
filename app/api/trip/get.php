<?php
namespace TeamAlpha\Web;

// Require classes
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/trip.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/models/triplistitem.php';

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
$vehicleid = 0;
$stage = '';

// Extract request query string
if (array_key_exists('id', $_GET)) {
    $id = intval($_GET['id']);
}
if (array_key_exists('vehicleid', $_GET)) {
    $vehicleid = intval($_GET['vehicleid']);
}
if (array_key_exists('stage', $_GET)) {
    $stage = $_GET['stage'];
}
if ($id === 0 && $stage === '' && $vehicleid === 0) {
    Http::ReturnError(400, array('message' => 'Trip id or trip stage was not provided.'));
    return;
}
try {
    if ($id === 0) {
        // Id was not given
        // Return all trips for a stage and vehicle id
        $datestart = array_key_exists('datestart', $_GET) ? $_GET['datestart'] . ' 00:00:00' : '1000-01-01 00:00:00';
        $dateend = array_key_exists('dateend', $_GET) ? $_GET['dateend'] . ' 23:59:59' : '9999-12-31 23:59:59';
        // Create Db object
        $db = new Db('SELECT * FROM `trip` WHERE stage LIKE :stage AND datecreated BETWEEN :datestart AND :dateend' . ($vehicleid === 0 ? '' : ' AND vehicleid = :vehicleid'));
        // Bind parameters
        $db->bindParam(':stage', '%' . $stage . '%');
        $db->bindParam(':datestart', $datestart);
        $db->bindParam(':dateend', $dateend);
        if ($vehicleid !== 0) {
            $db->bindParam(':vehicleid', $vehicleid);
        }
        $response = array();
        // Execute
        if ($db->execute() > 0) {
            // Drivers were found
            $records = $db->fetchAll();
            foreach ($records as &$record) {
                $trip = new TripListItem($record);
                array_push($response, $trip);
            }
        }
        // Reply with successful response
        Http::ReturnSuccess($response);
    } else {
        // Create Db object
        $db = new Db('SELECT * FROM `trip` WHERE id = :id LIMIT 1');
        // Bind parameters
        $db->bindParam(':id', $id);
        // Execute
        if ($db->execute() === 0) {
            Http::ReturnError(404, array('message' => 'Trip not found.'));
        } else {
            // Driver document was found
            $record = $db->fetchAll()[0];
            $trip = new Trip($record);
            // Reply with successful response
            Http::ReturnSuccess($trip);
        }
    }
} catch (PDOException $pe) {
    Db::ReturnDbError($pe);
} catch (Exception $e) {
    Http::ReturnError(500, array('message' => 'Server error: ' . $e->getMessage() . '.'));
}
